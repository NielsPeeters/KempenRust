<?php
class Klant extends CI_Controller {
     public function __construct() {
         /**
        * standaard controller constructor
        * laadt helpers
        */
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('notation');
    }

    public function index() {
        /**
        * Laadt de pagina waarop je boeking kan maken
        */
        $data['title'] = 'Boeking maken';
        $data['author'] = 'Peeters Ellen';
        $data['user'] = $this->authex->getUserInfo();
        $user = $this->authex->getUserInfo();
        if($user->soort==1) {
            $this->load->model('arrangement_model');
            $data['arrangementen'] = $this->arrangement_model->getAllArrangementen();
            
            $this->load->model('pension_model');
            $data['pensions'] = $this->pension_model->getAll();
            
            $partials = array('navbar' => 'main_navbar', 'content' => 'klant/boeking_maken1', 'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        } else {
            redirect("/home/index");
        }       
    }
    
    public function arrangementGekozen() {
        $data['title'] = 'Boeking maken';
        $data['author'] = 'Peeters Ellen';
        $data['user'] = $this->authex->getUserInfo();
        $user = $this->authex->getUserInfo();
        if($user->soort==1) {         
            $partials = array('navbar' => 'main_navbar', 'content' => 'klant/boeking_maken2', 'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        } else {
            redirect("/home/index");
        }      
    }
}
