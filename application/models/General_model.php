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
}
?>