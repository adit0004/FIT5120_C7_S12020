<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Spaces controller - Controls all business rules for open spaces
*/
class Spaces extends CI_Controller {
 
    /**
     * Constructor - Loads the model for this controller
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Spaces_model', 'model');
    }


    public function login($error = 0) 
    {
        $this->load->view('general/login', ['error' => $error]);
    }

    /**
    * Fetches weather from the library
    */
    public function fetchWeather($lat, $long)
    {
        return $this->weatheraqi->fetchWeatherData($lat, $long);
    }

    /**
    * Fetches AQI from the library
    */
    public function fetchAqi($lat, $long)
    {
        return $this->weatheraqi->fetchAqiData($lat, $long);
    }

    /**
    * Fetches featured spaces from the database
    */
    public function showSpaces()
    {
        if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] != true)
        {
            $this->login(); return;
        }

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

    /**
    * Fetches all spaces from the database
    */
    public function moreSpaces()
    {

        if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] != true)
        {
            $this->login(); return;
        }

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

    /**
    * Fetches weather and AQI from the methods above and returns as a JSON array
    */
    public function getWeatherAndAqi($index = 0)
    {
        // ONLY PROCEED IF WE HAVE A VALID LAT/LONG pair
        if (!empty($this->input->post('lat'))&&!empty($this->input->post('long')))
        {
            $lat = $this->input->post('lat');
            $long = $this->input->post('long');
        }
        $weather = $this->fetchWeather($lat, $long);
        $aqi = $this->fetchAqi($lat, $long);
        echo json_encode(['weather'=>$weather, 'aqi'=>$aqi, 'index'=>$index]);
    }

    /**
    * Show open spaces on map
    */
    public function showSpacesMap($spaceId, $page = 1, $distanceFromUser = 'All', $latitude = 0, $longitude = 0, $category = 'All')
    {

        if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] != true)
        {
            $this->login(); return;
        }
        
        // If the filter was sent via post, use it
        // Else if it was sent via url, use it
        // Else use 'All'
        $filters['distanceFromUser'] = empty($this->input->post('distanceFilter'))?($distanceFromUser == 'All'?'All':$distanceFromUser):$this->input->post('distanceFilter');
        $filters['userLocation']['latitude'] = $this->input->post('lat') == 0? ($latitude == 0?0:$latitude):$this->input->post('lat');
        $filters['userLocation']['longitude'] = $this->input->post('long') == 0? ($longitude == 0?0:$longitude):$this->input->post('long');
        $filters['category'] = empty($this->input->post('categoryFilter'))?($category == 'All'?'All':$category):$this->input->post('categoryFilter');
        // End filters

        $data['spaceId'] = $spaceId;

        // Fetch data from model
        $data['spaces'] = $this->model->fetchDataForMaps($spaceId, $filters, $page);
        
        // Format to camel case
        foreach($data['spaces'] as &$space)
        {
            if(!empty($space['name']))
                $space['name'] = ucwords(strtolower($space['name']));
        }

        // Pagination details
        $data['page'] = $page;
        //Number of pages = upper rounding off (total spaces / 10)
        $data['pages'] = ceil($this->model->fetchPageCount($spaceId, $filters)/10);
    
        $data['categoryName'] = $this->model->fetchAreasCategory($spaceId);

        $data['filters'] = $filters;
        
        // Unused this iteration
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
