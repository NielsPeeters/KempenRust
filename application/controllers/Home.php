<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {


    
    	public function __construct()
	{
            parent::__construct();
            $this->load->helper('form');
            $this->load->helper('notation');
    }

	public function index()
	{
            $data['title']  = 'Hotel Kempenrust';
            $data['nobox'] = true;      // geen extra rand rond hoofdmenu
            $data['user'] = $this->authex->getUserInfo();

            //map/arangementen is tijdelijke frontpage
            $partials = array('header' => 'main_header', 'content' => 'map/arangementen', 'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
	}

    

}
