<?php
class WeatherModel extends CI_Model {

    public function get_weather($lat, $lon) {
        $api_key = '104de18d1a6bae3fc939707ac7b5de7c'; // API Key
        $url = "http://api.openweathermap.org/data/2.5/weather?lat={$lat}&lon={$lon}&appid={$api_key}&lang=es&units=metric";
    
        $response = file_get_contents($url);
        return json_decode($response, true);
    }
}
