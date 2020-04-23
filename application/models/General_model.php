<?php
class General_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetchDataForChart($data=false, $filters=false)
    {
        if ((empty($data) || $data == 'met_guidelines') && empty($filters))
        {
            return $this->db->query("SELECT age,met_guidelines,gender,met_guidelines_proportional FROM met_guidelines")->result_array();
        }
    }

    function addJsonDataToDb($strings)
    {

        // Variable to hold all data
        $fields = [];
        
        // Variable to hold table names to create for these datasets
        $tableNames = [];
        
        // Get all data from JSON strings passed to this method in the fields array, and get the table names in the tableNames array
        foreach($strings as $index=>&$string)
        {
            $json = json_decode($string);
            $tableNames[$index] = $json[0]->datasetid;
            foreach($json as $key=>&$value)
            {
                // Don't need shape for now
                unset($value->fields->geo_shape);
                
                // Also, if this is the barbeques data, there's a column called 'id' with all 0 values. Drop it.
                if($index == 7)
                {
                    unset($value->fields->id);
                }
                $values = (array) ($value->fields);
                ksort($values);
                $fields[$index][] = $values;
            }
        }
        
        // Clean up the tableNames array
        // Some names are in the form of open-spaces-city-of-greater-geelong
        // These names can be replaced with open_spaces, since we're targeting the City of Greater Geelong
        foreach($tableNames as &$tableName)
        {
            $nameArray = explode("-",$tableName);
            
            // Last two elements will be greater geelong, strip it off
            array_pop($nameArray);
            array_pop($nameArray);
            
            // If the last element is 'of', pop it as well
            if($nameArray[count($nameArray) - 1] == 'of')
            array_pop($nameArray);
            
            // If the last element is 'city', pop it as well
            if($nameArray[count($nameArray) - 1] == 'city')
            array_pop($nameArray);
            
            $tableName = implode('_',$nameArray);
        }
        
        // Variable to hold all column names for all tables
        $columnNames = [];
        foreach($fields as $index=>$field)
        {

            // Just need the first element of each array to get fields since data is consistent
            // INCORRECT ASSUMPTION. 

            // Find the element with maximum fields
            $maxLength = 0;
            $pos = 0;
            foreach($field as $key=>$record)
            {
                if($maxLength < count(array_keys($record)))
                {
                    $maxLength = count(array_keys($record));
                    $pos = $key;
                }
            }

            // Get the names of the columns from this field
            $columnNames[$index] = array_keys($field[$pos]);
        }

        // Some fields don't have all the columns, add "N/A" values
        foreach($fields as $index=>&$field)
        {
            foreach($field as &$f)
            {
                $f = (array) $f;
                $missingValues = array_diff($columnNames[$index], array_keys((array) $f));

                foreach($missingValues as $pos=>$missingCol)
                {
                    $naVal = array($missingCol => "N/A");
                    $newList = array_merge(array_slice($f,0,$pos+1), $naVal,array_slice($f,$pos+1));
                    $f = $newList;
                }
                unset($missingValues);
            }
        }
        
        // For each dataset, create a table with all varchars set to 100 for now
        // Syntax - CREATE TABLE tableName (col1 datatype any_options, col2 datatype, ...., coln datatype);
        for($i = 0 ; $i < count($tableNames) ; $i++)
        {
            // Generate the string that goes inside the bracket in the CREATE TABLE statement
            $strToCreate = "id integer auto_increment primary key, `" . implode("` VARCHAR(100), `", $columnNames[$i]) . "` VARCHAR(100)";
            
            // Create the actual tables
            $this->db->query("CREATE TABLE IF NOT EXISTS " . $tableNames[$i] . " (".$strToCreate.")");
        }

        // Start inserting data into the database
        // For every dataset...
        foreach($fields as $key=>$field)
        {
            // For every row in every dataset...
            foreach($field as $f)
            {
                // Build the insert query string
                $insert = [];
                foreach($f as $column=>$value)
                {
                    if($value != 0 && empty($value))
                        $value = $this->db->escape('N/A');
                    
                    if($column == 'geo_point_2d') {
                        $insert[] = $this->db->escape(implode(',', $value));
                    }

                    else {
                        $insert[] = $this->db->escape($value);
                    }
                }

                // The insert query string is an array so far, make it a comma-separated string now
                $insertStr = implode(",", $insert);
                
                // Insert into database
                $this->db->query("INSERT INTO " . $tableNames[$key] . " VALUES (null, ".$insertStr.")");
                
                // Clear the variable for the next iteration
                unset($missingValues);
            }
        }

        // Create a table to store all area names that are NOT in open_spaces, and their corresponding images
        // Only dog walking, golf course, art center, barbeque areas, bike trails, accessible amenities,parishes and hospitals in featured
        $featured = ['accessible_amenities','art_centres','barbeques','bike_paths','dog_walking_areas','emergency_hospitals','golf_courses','parishes'];
        $this->db->query("CREATE TABLE areas_information (area_id integer primary key auto_increment, area_name varchar(50) not null, table_name varchar(50) not null, area_image_url varchar(255), featured integer default 0)");
        for($i = 1 ; $i < count($tableNames) ; $i++)
        {
            $areaName = ucwords(str_replace("_"," ",$tableNames[$i]));
            $default = 0;
            if(in_array($tableNames[$i],$featured))
                $default = 1;
            $this->db->query("INSERT INTO areas_information VALUES (null, '".$areaName."','".$tableNames[$i]."',null, ".$default.")");
        }
        
        // Variable dumps for seeing what's happening in every step.
        // echo "<pre>".print_r($columnNames,1);die();
        // echo "<pre>".print_r($tableNames,1);die();
        // echo "<pre>".print_r($fields,1);die();
    }

    function loadFeaturedSpaces()
    {
        return $this->db->query("SELECT * FROM areas_information WHERE featured = 1 ORDER BY area_name")->result_array();
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
