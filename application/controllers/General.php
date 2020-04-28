<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Controls home and charts pages
*/
class General extends CI_Controller {
 
    /**
     * Constructor - Loads the model for this controller
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('General_model', 'model');
    }
    
    /**
     * Present the home page
     * @return void
     */
	public function index()
	{
        $this->load->view('general/header');
        $this->load->view('general/home');
        $this->load->view('general/footer',['activePage'=>'home']);
    }

    // Fetch weather from the library for the given lat,long
    public function fetchWeather($lat, $long)
    {
        return $this->weatheraqi->fetchWeatherData($lat, $long);
    }

    // Fetch AQI from the library for the given lat,long
    public function fetchAqi($lat, $long)
    {
        return $this->weatheraqi->fetchAqiData($lat, $long);
    }

    // Display the health facts page
    public function showCharts()
    {
        $this->load->view('general/header');
        $this->load->view('general/charts');
        $this->load->view('general/footer',['activePage'=>'charts']);
    }

    // Add files from JSON to database
    public function addFilesToDb()
    {
        // Read all json strings as strings into an array
        $strings = [
            0 => file_get_contents(base_url().'assets/dataFiles/0.json'),
            1 => file_get_contents(base_url().'assets/dataFiles/1.json'),
            2 => file_get_contents(base_url().'assets/dataFiles/2.json'),
            3 => file_get_contents(base_url().'assets/dataFiles/3.json'),
            4 => file_get_contents(base_url().'assets/dataFiles/4.json'),
            5 => file_get_contents(base_url().'assets/dataFiles/5.json'),
            6 => file_get_contents(base_url().'assets/dataFiles/6.json'),
            7 => file_get_contents(base_url().'assets/dataFiles/7.json'),
            8 => file_get_contents(base_url().'assets/dataFiles/8.json'),
            9 => file_get_contents(base_url().'assets/dataFiles/9.json'),
            10 => file_get_contents(base_url().'assets/dataFiles/10.json'),
            11 => file_get_contents(base_url().'assets/dataFiles/11.json'),
            12 => file_get_contents(base_url().'assets/dataFiles/12.json')
        ];

        // Pass this array to the model
        $this->model->addJsonDataToDb($strings);
    }

    // Fetch weather and AQI using this controller's methods and return them as a JSON object
    public function getWeatherAndAqi($index = 0)
    {
        // Only do this if we have a valid lat/long pair
        if (!empty($this->input->post('lat')))
        {
            $lat = $this->input->post('lat');
            $long = $this->input->post('long');
        }
        $weather = $this->fetchWeather($lat, $long);
        $aqi = $this->fetchAqi($lat, $long);
        echo json_encode(['weather'=>$weather, 'aqi'=>$aqi, 'index'=>$index]);
    }
}
