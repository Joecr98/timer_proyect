<?php
class WeatherModel extends CI_Model {

    private $apiKey = '104de18d1a6bae3fc939707ac7b5de7c'; // API Key

    public function get_weather($city) {
        $url = "http://api.openweathermap.org/data/2.5/weather?q={$city}&lang=es&units=metric&appid={$this->apiKey}";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
}
