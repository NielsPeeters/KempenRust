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
            $data['title']  = 'Lessen';
            $data['nobox'] = true;      // geen extra rand rond hoofdmenu
            $data['auteur']="Team05";
            
            $partials = array('header' => 'main_header', 'content' => 'main_menu');
            $this->template->load('main_master', $partials, $data);
	}

    

}
