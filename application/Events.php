<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events extends CI_Controller {
 
    /**
     * Constructor - Loads the model for this controller
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Events_model', 'model');
    }

    // Fetch weather from the library
    public function fetchWeather($lat, $long)
    {
        return $this->weatheraqi->fetchWeatherData($lat, $long);
    }

    // Fetch AQI from the library
    public function fetchAqi($lat, $long)
    {
        return $this->weatheraqi->fetchAqiData($lat, $long);
    }

    public function fetchEventsFromDataset()
    {
        $xml = file_get_contents('https://www.geelongaustralia.com.au/rss/events-all.aspx');
        $xml = simplexml_load_string($xml);
        $json = json_decode(json_encode($xml));
        // Only need the channel->item
        // echo "<pre>".print_r($json->channel->item,1);die();
        $json = $json->channel->item;
        
        /**
         * This bit was meant to run only once, when the table was being created. It was run, and its purpose was satisfied.
         */
        // Get the column names
        $columnNames = [];
        
        $maxLength = 0;
        $pos = 0;

        foreach($json as $key=>&$item)
        {
            $item = (array)$item;
            if($maxLength < count(array_keys($item)))
            {
                $maxLength = count(array_keys($item));
                $pos = $key;
            }        
        }
        // Ensure all keys are now here
        $columnNames = array_keys($json[$pos]);
        echo "<pre>".print_r($columnNames,1)."</pre>";

        // Which columns can be null?
        $nullables = [];

        foreach($json as $key=>&$item)
        {
            foreach($columnNames as $column)
            {
                if(!in_array($column, array_keys($item)) && !in_array($column, $nullables))
                    $nullables[] = $column;
            }
        }
        // echo "<pre>".print_r($nullables,1);die();

        // Each item is an stdObject, make it an array instead
        foreach($json as $key=>&$item)
        {
            $item = (array)$item;        
        }

        $this->model->addDataToDb($json);
        // echo "<pre>".print_r($json,1);die();
    }


    public function login($error = 0) 
    {
        $this->load->view('general/login', ['error' => $error]);
    }

    // Show events page
    public function showEvents($page = 1, $name = 0, $startDate = 0, $endDate = 0)
    {
        $headerData['breadcrumbs'] = [
            "Home" => site_url(['general','index']),
            "Events" => "#!"
        ];

        if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] != true)
        {
            $this->login(); return;
        }
        // If the filters are coming from the form, use those
        // Else if the filters are coming from the url, use those
        // Else use 0s
        $filters['name'] = empty($this->input->post('name'))?($name==0?0:$name):$this->input->post('name');
        $filters['startDate'] = empty($this->input->post('startDate'))?($startDate == 0?0:$startDate):$this->input->post('startDate');
        $filters['endDate'] = empty($this->input->post('endDate'))?($endDate == 0?0:$endDate):$this->input->post('endDate');
        
        // Fetch the earliest and latest dates for the default values
        $data['earliestDate'] = $this->model->fetchEarliestDate();
        $data['latestDate'] = $this->model->fetchLatestDate();

        // Filters has startDate and endDate as 11%20Apr%202020, convert to 11 Apr 2020 so strtotime can parse it
        $filters['startDate'] = urldecode($filters['startDate']);
        $filters['endDate'] = urldecode($filters['endDate']);

        // Fetch the events
        $data['events'] = $this->model->fetchEventsData($page, $filters['name'], $filters['startDate'], $filters['endDate']);
        $data['filters'] = $filters;
        
        // Fetch the total number of events
        $data['count'] = $this->model->fetchEventsCount($page, $filters['name'], $filters['startDate'], $filters['endDate']);
        $data['page'] = $page;
        $data['pages'] = ceil($data['count']/10);
        
        $this->load->view('general/header', $headerData);
        $this->load->view('events/events', $data);
        $this->load->view('general/footer', ['activePage' => 'events']);
    }
}
