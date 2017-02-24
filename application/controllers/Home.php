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
            $data['title']  = 'Dit is de $data[\'title\'] = "xxx"';
            $data['nobox'] = true;      // geen extra rand rond hoofdmenu
            $data['author'] = 'Niels Peeters';
            $data['user'] = $this->authex->getUserInfo();

            //main_content moet vervangen worden naar map/arangementen bij finale afwerking!
            $partials = array('navbar' => 'main_navbar', 'content' => 'main_content', 'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
	}

    

}
