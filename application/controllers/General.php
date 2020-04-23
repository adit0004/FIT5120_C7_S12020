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

    public function showSpaces()
    {
        // This page needs to show the featured spaces as well, get them from DB
        $data['places'] = $this->model->loadFeaturedSpaces(); 
        
        // Build the image path here
        foreach($data['places'] as &$place)
        {
            $place['area_image_url'] = base_url().'assets/img/spaces/'.$place['area_image_url'];
        }
        $this->load->view('general/header');
        $this->load->view('general/spaces', $data);
        $this->load->view('general/footer', ['activePage' => 'places']);
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

    public function showSpacesMap($spaceId, $page = 1, $distanceFromUser = 'All', $latitude = 0, $longitude = 0, $category = 'All')
    {
        $filters['distanceFromUser'] = empty($this->input->post('distanceFilter'))?($distanceFromUser == 'All'?'All':$distanceFromUser):$this->input->post('distanceFilter');
        $filters['userLocation']['latitude'] = $this->input->post('lat') == 0? ($latitude == 0?0:$latitude):$this->input->post('lat');
        $filters['userLocation']['longitude'] = $this->input->post('long') == 0? ($longitude == 0?0:$longitude):$this->input->post('long');
        $filters['category'] = empty($this->input->post('categoryFilter'))?($category == 'All'?'All':$category):$this->input->post('categoryFilter');
        $data['spaceId'] = $spaceId;
        $data['spaces'] = $this->model->fetchDataForMaps($spaceId, $filters, $page);
        foreach($data['spaces'] as &$space)
        {
            if(!empty($space['name']))
                $space['name'] = ucwords(strtolower($space['name']));
        }
        $data['page'] = $page;
        $data['pages'] = ceil($this->model->fetchPageCount($spaceId, $filters)/10);
        $data['categoryName'] = $this->model->fetchAreasCategory($spaceId);
        $data['filters'] = $filters;
        $data['category'] = [
            'LL' => 'Linear and Linkage',
            'S' => 'Sport',
            'IP' => 'Informal Parks',
            'LA' => 'Landscape and Amenity',
            'CH' => 'Conservation, Habitat and Heritage',
            'WL' => 'Waterway and Lake',
            'FB' => 'Foreshore, Beach and Ocean',
            'US' => 'Utilities and Services',
            'PF' => 'Possible Future Use',
            'U' => 'Undeveloped',
            'CL' => 'Crown Land'
        ];

        $this->load->view('general/header');
        $this->load->view('general/placesMap', $data);
        $this->load->view('general/footer', ['activePage' => 'placesMap']);
    }
}
