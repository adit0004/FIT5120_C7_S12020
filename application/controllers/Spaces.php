<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spaces extends CI_Controller {
 
    /**
     * Constructor - Loads the model for this controller
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Spaces_model', 'model');
    }

    public function fetchWeather($lat, $long)
    {
        return $this->weatheraqi->fetchWeatherData($lat, $long);
    }

    public function fetchAqi($lat, $long)
    {
        return $this->weatheraqi->fetchAqiData($lat, $long);
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
        $this->load->view('spaces/spaces', $data);
        $this->load->view('general/footer', ['activePage' => 'places']);
    }

    public function moreSpaces()
    {
        // This page needs to show the featured spaces as well, get them from DB
        $data['places'] = $this->model->loadAllSpaces(); 
        
        // Build the image path here
        foreach($data['places'] as &$place)
        {
            $place['area_image_url'] = base_url().'assets/img/spaces/'.$place['area_image_url'];
        }
        $this->load->view('general/header');
        $this->load->view('spaces/moreSpaces', $data);
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
        $this->load->view('spaces/placesMap', $data);
        $this->load->view('general/footer', ['activePage' => 'placesMap']);
    }
}
