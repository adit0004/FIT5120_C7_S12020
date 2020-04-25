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
        $this->load->view('general/header');
        $this->load->view('general/home');
        $this->load->view('general/footer',['activePage'=>'home']);
    }

    public function fetchWeather($lat, $long)
    {
        return $this->weatheraqi->fetchWeatherData($lat, $long);
    }

    public function fetchAqi($lat, $long)
    {
        return $this->weatheraqi->fetchAqiData($lat, $long);
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
                    $data['y'][$d['age']] = ($d['met_guidelines_proportional']+$data['y'][$d['age']])/2;
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
                    $data['n'][$d['age']] = ($d['met_guidelines_proportional']+$data['n'][$d['age']])/2;
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
        $this->load->view('general/header');
        $this->load->view('general/charts', $data);
        $this->load->view('general/footer',['activePage'=>'charts']);
    }

    public function getDataForCharts()
    {
        $data = $this->input->post('data') || null;
        $filters = $this->input->post('filters') || null;
        echo "<pre>".print_r($this->model->fetchDataForChart($data, $filters),1);die();
    }

    public function addFilesToDb()
    {
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
        $this->model->addJsonDataToDb($strings);
    }

    public function getWeatherAndAqi($index = 0)
    {
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
