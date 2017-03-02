<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Faciliteit extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('notation');
        $this->load->library('email');
    }
    
    public function index() {
        $data['title'] = 'Faciliteiten beheren';
        $data['author'] = 'Ellen Peeters';
        $data['user'] = $this->authex->getUserInfo();
        
        $this->load->model('Faciliteit_model'); /**< model inladen */
        $data['types'] = $this->faciliteit_model->getAll();

        $partials = array('navbar' => 'main_navbar', 'content' => 'admin/faciliteit/faciliteit_lijst', 'footer'=>'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
}
