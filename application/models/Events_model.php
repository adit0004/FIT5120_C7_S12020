<?php
class Events_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Add the XML data to database
// Add the XML data to database
    public function addDataToDb($data)
    {
        // For each record...
        foreach($data as &$item)
        {
            // Get what columns it has
            $insertCols = [];

            // And what values each column 
            $insertVals = [];

            // For each column=>value pair, escape all values for DB insert 
            foreach($item as $key=>&$value) {
                // Get column name
                // $insertCols[] = $key;
                // Get value
                $value = $this->db->escape($value);
                // Parse dates
                if ($key == "pubDate")
                {
                    $value = substr($value, 6,11);
                    $value = date('Y-m-d', strtotime($value));
                    $insertVals[$key] = $this->db->escape($value);
                }
                elseif(($key == 'dtstart' || $key == 'dtend') && !isset($insertVals['dtstart']))
                {
                    $value = substr($value, 6,11);
                    $value = date('Y-m-d', strtotime($value));
                    $insertVals[$key] = $this->db->escape($value);
                }
                elseif ($key == 'dtstart' || $key == 'dtend') 
                {
                    // Explicitly mark continue so that it doesn't override the dsummary parsing
                    continue;
                }
                elseif ($key == "dsummary") {
                    $date_check = explode(" ", $value);
                    if(isset($date_check[sizeof($date_check)-8]) && strtolower($date_check[sizeof($date_check)-8]) == "from" && strtolower($date_check[sizeof($date_check)-4]) == "to")
                    {
                        // if(!in_array('dtstart', $insertCols))
                        //     $insertCols[] = 'dtstart';
                        // if(!in_array('dtend', $insertCols))
                        //     $insertCols[] = 'dtend';
                        $insertVals['dtstart'] = $this->db->escape(date("Y-m-d", strtotime($date_check[sizeof($date_check)-7]." ".$date_check[sizeof($date_check)-6]." ".$date_check[sizeof($date_check)-5])));
                        $insertVals['dtend'] = $this->db->escape(date("Y-m-d", strtotime($date_check[sizeof($date_check)-3]." ".$date_check[sizeof($date_check)-2]." ".str_replace("'", "", $date_check[sizeof($date_check)-1]))));
                    }
                    $insertVals[$key] = $value;
                }
                else{
                    $insertVals[$key] = $value;
                }
            }
            // Make the query params
            $insertColsString = implode(",", array_keys($insertVals));
            $insertValsString = implode(",", $insertVals);

            echo "<pre>".print_r($insertVals,1)."</pre>";
            
            // echo "INSERT INTO events(event_id, ".$insertColsString.") VALUES(null, ".$insertValsString.")";
            // Insert
            $this->db->query("INSERT INTO events(event_id, ".$insertColsString.") VALUES(null, ".$insertValsString.")");
        }

        // Once this is done, remove duplicate rows
        $this->db->query("DELETE a FROM events as a, events as b where a.event_id < b.event_id and a.title <=> b.title and a.description <=> b.description and a.link <=> b.link and a.pubdate <=> b.pubdate and a.location <=> b.location and a.dtstart <=> b.dtstart and a.dtend <=> b.dtend");
        // echo "<pre>".print_r($data, 1);die();
    }

    public function fetchEventsData($page = 1, $name = 0, $startDate = 0, $endDate = 0, $category="All")
    {
        $nameWhere = ' 1 = 1 ';
        if($name !== 0)
        {
            $nameWhere = ' title LIKE "%'.$this->db->escape_str($name).'%" ';
        }
        $dateWhere = '';
        if($startDate == 0 && $endDate == 0)
        {
            $dateWhere = ' 1 = 1 ';
        }
        else if ($endDate == 0)
        {
            $format = "d M Y";
            $dateObj = DateTime::createFromFormat($format, $startDate);
            $dateWhere = ' dtstart >= "'.$dateObj->format("Y-m-d").'" ';
        }
        else if ($startDate == 0)
        {
            $format = "d M Y";
            $dateObj = DateTime::createFromFormat($format, $endDate);
            $dateWhere = ' dtend <= "'.$dateObj->format("Y-m-d").'" ';
        }
        else
        {
            $format = "d M Y";
            $dateObj = DateTime::createFromFormat($format, $startDate);
            $dateObj2 = DateTime::createFromFormat($format, $endDate);
            $dateWhere = ' dtstart >= "'.$dateObj->format("Y-m-d").'" AND dtend <= "'.$dateObj2->format("Y-m-d").'" ';
        }

        $categoryWhere = ' 1 = 1 ';
        if($category != "All")
        {
            $categoryWhere = " event_category = ".$this->db->escape($category)." ";
        }

        $query = $this->db->query("SELECT * FROM events WHERE ".$nameWhere." AND ".$dateWhere." AND ".$categoryWhere." AND dtend > '".date('Y-m-d',strtotime('yesterday'))."' ORDER BY dtstart asc LIMIT ".(($page-1)*9).",9 ");
        // echo "SELECT * FROM events WHERE ".$nameWhere." AND ".$dateWhere." AND dtend > '".date('Y-m-d',strtotime('yesterday'))."' ORDER BY dtstart desc LIMIT ".(($page-1)*10).",10 ";die();
        return $query->result_array();
    }

    public function fetchEventsCount($page = 1, $name = 0, $startDate = 0, $endDate = 0, $category = "All")
    {
        $nameWhere = ' 1 = 1 ';
        if($name !== 0)
        {
            $nameWhere = ' title LIKE "%'.$this->db->escape_str($name).'%" ';
        }
        $dateWhere = '';
        if($startDate == 0 && $endDate == 0)
        {
            $dateWhere = ' 1 = 1 ';
        }
        else if ($endDate == 0)
        {
            $format = "d M Y";
            $dateObj = DateTime::createFromFormat($format, $startDate);
            $dateWhere = ' dtstart >= "'.$dateObj->format("Y-m-d").'" ';
        }
        else if ($startDate == 0)
        {
            $format = "d M Y";
            $dateObj = DateTime::createFromFormat($format, $endDate);
            $dateWhere = ' dtend <= "'.$dateObj->format("Y-m-d").'" ';
        }
        else
        {
            $format = "d M Y";
            $dateObj = DateTime::createFromFormat($format, $startDate);
            $dateObj2 = DateTime::createFromFormat($format, $endDate);
            $dateWhere = ' dtstart >= "'.$dateObj->format("Y-m-d").'" AND dtend <= "'.$dateObj2->format("Y-m-d").'" ';
        }
        $categoryWhere = ' 1= 1 ';
        if($category != "All")
        {
            $categoryWhere = " event_category = ".$this->db->escape($category)." ";
        }
         $query = $this->db->query("SELECT count(*) as count FROM events WHERE ".$nameWhere." AND ".$dateWhere." AND ".$categoryWhere." AND dtend > '".date('Y-m-d',strtotime('yesterday'))."' ORDER BY dtstart asc");
        return $query->row_array()['count'];
    }

    public function fetchEarliestDate()
    {
        return date("d M Y",strtotime($this->db->query("SELECT min(dtstart) as dtstart FROM events WHERE dtstart IS NOT NULL")->row_array()['dtstart']));
    }

    public function fetchLatestDate()
    {
        return date("d M Y",strtotime($this->db->query("SELECT max(dtend) as dtend FROM events WHERE dtend IS NOT NULL")->row_array()['dtend']));
    }

    public function fetchCategories()
    {
        return $this->db->query("SELECT distinct(event_category) as event_category from events ORDER BY event_category asc")->result_array();
    }
}
