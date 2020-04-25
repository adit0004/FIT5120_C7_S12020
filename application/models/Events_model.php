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
        $query = $this->db->query("SELECT * FROM events WHERE ".$nameWhere." AND ".$dateWhere." ORDER BY dtstart desc LIMIT ".(($page-1)*10).",10 ");
        return $query->result_array();
    }

    public function fetchEventsCount($page = 1, $name = 0, $startDate = 0, $endDate = 0)
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
        $query = $this->db->query("SELECT count(*) as count FROM events WHERE ".$nameWhere." AND ".$dateWhere." ORDER BY dtstart desc");
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
}
