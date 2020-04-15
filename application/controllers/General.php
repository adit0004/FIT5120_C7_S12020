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

    public function showCharts()
    {
        $dataForChart = $this->model->fetchDataForChart();
        $data['y'] = [];
        $data['n'] = [];
        $data['male'] = [];
        $data['female'] = [];
        foreach($dataForChart as $d)
        {
            if($d['met_guidelines'] == "Yes")
            {
                if(isset($data['y'][$d['age']]))
                    $data['y'][$d['age']] += $d['met_guidelines_proportional'];
                else
                    $data['y'][$d['age']] = $d['met_guidelines_proportional'];
                if($d['gender'] == 'Male')
                {
                    $data['male']['y'][] = $d['met_guidelines_proportional'];
                }
                else if($d['gender'] == 'Female')
                {
                    $data['female']['y'][] = $d['met_guidelines_proportional'];
                }
            }
            else if($d['met_guidelines'] == "No")
            {
                if(isset($data['n'][$d['age']]))
                    $data['n'][$d['age']] += $d['met_guidelines_proportional'];
                else
                    $data['n'][$d['age']] = $d['met_guidelines_proportional'];
                if($d['gender'] == 'Male')
                {
                    $data['male']['n'][] = $d['met_guidelines_proportional'];
                }
                else if($d['gender'] == 'Female')
                {
                    $data['female']['n'][] = $d['met_guidelines_proportional'];
                }
            }
        }
        $this->load->view('general/charts', $data);
    }

    public function getDataForCharts()
    {
        $data = $this->input->post('data') || null;
        $filters = $this->input->post('filters') || null;
        echo "<pre>".print_r($this->model->fetchDataForChart($data, $filters),1);die();
    }
}
