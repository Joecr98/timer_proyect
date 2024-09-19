<?php 
define('BASEPATH') OR exit('No direct script access allowed');

class Tiempo extends CI_Controller {

    public function index() {
        $temperatura = $this->get_weather('Guatemala');

        $this->load->view('weather',['temperatura' => $temperatura]);
    }

    private function get_weather
}