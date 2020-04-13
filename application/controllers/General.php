<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
		$this->load->view('general/home');
    }

    public function testMethods()
    {
        $this->load->view('general/testMethods');
    }

    public function fetchWeather()
    {
        $lat = $this->input->post('lat');
        $long = $this->input->post('long');
        echo json_encode($this->weatheraqi->fetchWeatherData($lat, $long));
    }

    public function fetchAqi()
    {
        $lat = $this->input->post('lat');
        $long = $this->input->post('long');
        echo json_encode($this->weatheraqi->fetchAqiData($lat, $long));
    }
}
