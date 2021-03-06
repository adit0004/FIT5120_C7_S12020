<?php
defined('BASEPATH') or exit('No direct script access allowed');

class WeatherAqi
{
    /**
     * Method to return the weather data of a location as a stdObject
     *
     * @param number $lat
     * @param number $long
     * @return stdObject The weather data 
     */
    public function fetchWeatherData($lat, $long)
    {
        // Trim down the latitude and longitude to about 1,111 meters (2 decimal places)
        $lat = round($lat, 2);
        $long = round($long, 2);

        // Set the API key for the API call
        $openweatherApiKey = "ac08cab12e5f2679a75f781cc6d1745f";

        $url = "http://api.openweathermap.org/data/2.5/weather?lat=" . $lat . "&lon=" . $long . "&appid=" . $openweatherApiKey;

        // Get the data from the URL
        $json = file_get_contents($url);

        // Parse the json string as an array
        $weatherData = json_decode($json);

        return $weatherData;
    }

    /**
     * Method to return the AQI data of a location in an array
     *
     * @param number $lat
     * @param number $long
     * @return number The AQI
     */
    public function fetchAqiData($lat, $long)
    {
        // Trim down the latitude and longitude to about 1,111 meters (2 decimal places)
        $lat = round($lat, 2);
        $long = round($long, 2);

        // Set the token for the AQI API
        $aqiApiToken = "e7a039782b788f5ac965622700b7961213f6d9a8";

        $url = "https://api.waqi.info/feed/geo:" . $lat . ";" . $long . "/?token=" . $aqiApiToken;

        // Get the data from the URL
        $json = file_get_contents($url);

        // // Parse the json string as an array
        // $aqiData = json_decode($json);

        // $aqi = $aqiData->data->aqi;

        return $json;
    }
}
