<?php
class Spaces_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    function loadFeaturedSpaces()
    {
        return $this->db->query("SELECT * FROM areas_information WHERE featured = 1 ORDER BY area_name")->result_array();
    }

    function loadAllSpaces()
    {
        return $this->db->query("SELECT * FROM areas_information ORDER BY area_name")->result_array();
    }

    function fetchAreasCategory($spacesId)
    {
        return $this->db->query("SELECT area_name FROM areas_information WHERE area_id = ".$spacesId)->row_array()['area_name'];
    }

    function fetchDataForMaps($spacesId, $filters, $page = 1)
    {
        $distance = $filters['distanceFromUser'];

        $filters['category'] = $this->db->escape($filters['category']);
        $distanceWhere = ' 1 = 1 ';
        $orderBy = ' ';
        if($filters['userLocation']['latitude'] < 0)
            $filters['userLocation']['latitude'] *= (-1);
        $distanceLatString = '';
        $distanceLongString = '';
            
        if($filters['userLocation']['latitude'] == 0){
            $distanceWhere = ' 1 = 1 ';
        }
        else{
            if($distance == '100')
                $distanceWhere = ' ABS(t.lat) - '.$filters['userLocation']['latitude'].' < 2 AND ABS(t.long) - '.$filters['userLocation']['longitude'].' < 2 ';
            else if($distance == '10')
                $distanceWhere = ' ABS(t.lat) - '.$filters['userLocation']['latitude'].' < 0.1 AND ABS(t.long) - '.$filters['userLocation']['longitude'].' < 0.1 ';
            else if ($distance == '5')
                $distanceWhere = ' ABS(t.lat) - '.$filters['userLocation']['latitude'].' < 0.05 AND ABS(t.long) - '.$filters['userLocation']['longitude'].' < 0.05 ';
            else if ($distance == '1')
                $distanceWhere = ' ABS(t.lat) - '.$filters['userLocation']['latitude'].' < 0.01 AND ABS(t.long) - '.$filters['userLocation']['longitude'].' < 0.01 ';
            $distanceLatString = ' ,ABS(t.lat) - '.$filters['userLocation']['latitude'].' as latString';
            $distanceLongString = ' ,ABS(t.lat) - '.$filters['userLocation']['longitude'].' as longString';
            $orderBy = ' ORDER BY latString asc, longString asc ';
        }

        $categoryWhere = ' 1 = 1 ';
        if($filters['category'] != "'All'" && !empty($filters['category']))
            $categoryWhere = ' os.OSCATEGORY = '.$filters['category'].' ';

        $tableName = $this->db->query("SELECT table_name FROM areas_information WHERE area_id = ".$spacesId)->row_array()['table_name'];
        $queryString = "SELECT t.*, os.OSCATEGORY ".$distanceLatString.$distanceLongString." FROM ".$tableName." t LEFT OUTER JOIN open_space os ON os.lat = t.lat AND os.long = t.long WHERE ".$categoryWhere." AND ".$distanceWhere.$orderBy."LIMIT ".(($page-1)*10).",10";
        // echo $queryString;die();
        return $this->db->query($queryString)->result_array();
    }

    function fetchPageCount($spacesId, $filters)
    {
        $distance = $filters['distanceFromUser'];

        $filters['category'] = $this->db->escape($filters['category']);
        $distanceWhere = ' 1 = 1 ';

        if($distance == '100')
            $distanceWhere = ' ABS(t.lat - '.$filters['userLocation']['latitude'].') < 2 AND ABS(t.long - '.$filters['userLocation']['longitude'].') < 2 ';
        else if($distance == '10')
            $distanceWhere = ' ABS(t.lat - '.$filters['userLocation']['latitude'].') < 0.1 AND ABS(t.long - '.$filters['userLocation']['longitude'].') < 0.1 ';
        else if ($distance == '5')
            $distanceWhere = ' ABS(t.lat - '.$filters['userLocation']['latitude'].') < 0.05 AND ABS(t.long - '.$filters['userLocation']['longitude'].') < 0.05 ';
        else if ($distance == '1')
            $distanceWhere = ' ABS(t.lat - '.$filters['userLocation']['latitude'].') < 0.01 AND ABS(t.long - '.$filters['userLocation']['longitude'].') < 0.01 ';

        $categoryWhere = ' 1 = 1 ';
        if($filters['category'] != "'All'" && !empty($filters['category']))
            $categoryWhere = ' os.OSCATEGORY = '.$filters['category'].' ';

        $tableName = $this->db->query("SELECT table_name FROM areas_information WHERE area_id = ".$spacesId)->row_array()['table_name'];
        $queryString = "SELECT count(*) as c FROM ".$tableName." t LEFT OUTER JOIN open_space os ON os.lat = t.lat AND os.long = t.long WHERE ".$categoryWhere." AND ".$distanceWhere;
        return $this->db->query($queryString)->row_array()['c'];
    }
}
