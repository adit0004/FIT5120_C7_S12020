<?php
class Events_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function addDataToDb($data)
    {
        foreach($data as &$item)
        {
            $insertCols = [];
            $insertVals = [];
            foreach($item as $key=>&$value) {
                $insertCols[] = $key;
                $value = $this->db->escape($value);
                if ($key == "pubDate" || $key == 'dtstart' || $key == 'dtend')
                {
                    $value = substr($value, 6,11);
                    echo $value." ";
                    $value = date('Y-m-d', strtotime($value));
                    echo $value."<br>";
                    $insertVals[] = $this->db->escape($value);
                }
                else{
                    $insertVals[] = $value;
                }
            }
            $insertColsString = implode(",", $insertCols);
            $insertValsString = implode(",", $insertVals);
            // $queryString = "INSERT INTO events(event_id, ".$insertColsString.") VALUES(null, ".$insertValsString.")";
            // echo $queryString;
            $this->db->query("INSERT INTO events(event_id, ".$insertColsString.") VALUES(null, ".$insertValsString.")");
        }
        // echo "<pre>".print_r($data, 1);die();
    }

    public function fetchEventsData($page = 1, $name = 0, $startDate = 0, $endDate = 0)
    {
        $nameWhere = ' 1 = 1 ';
        if($name != 0)
        {
            $nameWhere = ' title LIKE "%'.$this->db->escape_str($name).'%" ';
        }
        $dateWhere = '';
        if($startDate == 0 && $endDate == 0)
        {
            $dateWhere = ' 1 = 1 ';
        }
        else if ($startDate == 0)
        {
            
            $dateWhere = ' dtstart >= "'.$startDate.'" ';
        }
        else if ($endDate == 0)
        {
            
            $dateWhere = ' dtend <= "'.$endDate.'" ';
        }
        else
        {
            
            $dateWhere = ' dtstart >= "'.$startDate.'" AND dtend <= "'.$endDate.'" ';
        }
        $query = $this->db->query("SELECT * FROM events WHERE ".$nameWhere." AND ".$dateWhere." ORDER BY dtstart desc LIMIT ".(($page-1)*10).",10 ");
        return $query->result_array();
    }
}
