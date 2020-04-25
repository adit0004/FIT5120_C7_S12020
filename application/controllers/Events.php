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

    public function fetchWeather($lat, $long)
    {
        return $this->weatheraqi->fetchWeatherData($lat, $long);
    }

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
        // // Get the column names
        // $columnNames = [];
        
        // $maxLength = 0;
        // $pos = 0;

        // foreach($json as $key=>&$item)
        // {
        //     $item = (array)$item;
        //     if($maxLength < count(array_keys($item)))
        //     {
        //         $maxLength = count(array_keys($item));
        //         $pos = $key;
        //     }        
        // }

        // $columnNames = array_keys($json[$pos]);

        // echo "<pre>".print_r($columnNames,1)."</pre>";

        // $nullables = [];

        // foreach($json as $key=>&$item)
        // {
        //     foreach($columnNames as $column)
        //     {
        //         if(!in_array($column, array_keys($item)) && !in_array($column, $nullables))
        //             $nullables[] = $column;
        //     }
        // }

        // echo "<pre>".print_r($nullables,1);die();

        // Each item is an stdObject, make it an array instead
        foreach($json as $key=>&$item)
        {
            $item = (array)$item;        
        }

        $this->model->addDataToDb($json);
        // echo "<pre>".print_r($json,1);die();
    }

    public function showEvents($page = 1, $name = 0, $startDate = 0, $endDate = 0)
    {

        $filters['name'] = empty($this->input->post('name'))?($name==0?0:$name):$this->input->post('name');
        $filters['startDate'] = empty($this->input->post('startDate'))?($startDate == 0?0:$startDate):$this->input->post('startDate');
        $filters['endDate'] = empty($this->input->post('endDate'))?($endDate == 0?0:$endDate):$this->input->post('endDate');
        $data['earliestDate'] = $this->model->fetchEarliestDate();
        $data['latestDate'] = $this->model->fetchLatestDate();
        $filters['startDate'] = urldecode($filters['startDate']);
        $filters['endDate'] = urldecode($filters['endDate']);
        $data['events'] = $this->model->fetchEventsData($page, $filters['name'], $filters['startDate'], $filters['endDate']);
        $data['filters'] = $filters;
        $data['count'] = $this->model->fetchEventsCount($page, $filters['name'], $filters['startDate'], $filters['endDate']);
        $data['page'] = $page;
        $data['pages'] = ceil($data['count']/10);
        // echo "<pre>".print_r($data,1);die();
        $this->load->view('general/header');
        $this->load->view('events/events', $data);
        $this->load->view('general/footer', ['activePage' => 'events']);
    }
}
