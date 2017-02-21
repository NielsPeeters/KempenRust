<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    // +----------------------------------------------------------
    // | Lekkerbier
    // +----------------------------------------------------------
    // | 2 ITF - 201x-201x
    // +----------------------------------------------------------
    // | Home controller
    // |
    // +----------------------------------------------------------
    // | Thomas More Kempen
    // +----------------------------------------------------------

    
    	public function __construct()
	{
            parent::__construct();
            
        }

	public function index()
	{
            $data['title']  = 'Lessen';
            $data['nobox'] = true;      // geen extra rand rond hoofdmenu
            
            $partials = array('header' => 'main_header', 'content' => 'main_menu');
            $this->template->load('main_master', $partials, $data);
	}

}
