<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kamertype extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('notation');
        $this->load->library('email');
    }
    
        public function index() {
        /**
        * Laadt de pagina waarop je kamertypes kan beheren
        * geeft een array van kamertype objecten mee
        */
        $data['title'] = 'Kamertypes beheren';
        $data['author'] = 'Van de Voorde Tim';
        $data['user'] = $this->authex->getUserInfo();

        $this->load->model('kamerType_model');
        $data['types'] = $this->kamerType_model->getAll();

        $partials = array('navbar' => 'main_navbar', 'content' => 'admin/kamertype/kamertype_beheren', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function haalKamertype() {
        /**
        * haalt een kamertype object en alle kamertypes op
        */
        $kamerTypeId = $this->input->get('$kamerTypeId');
        
        $this->load->model('kamerType_model');
        $data['type'] = $this->kamerType_model->getAll();
        
        $this->load->view("admin/kamertype/ajax_kamertype", $data);
    }

    public function verwijderKamertype(){
        /**
        * verwijderdt een kamertype object als hieraan geen kamers verbonden zijn
        */
        $id = $this->input->get('id');
        $this->load->model('kamerType_model');
        $result = $this->kamerType_model->getAllByType($id);
        $size = count($result);
        if ($size==0){
            $this->load->model('kamerType_model');
            $this->kamerType_model->delete($id);
            echo 0;
        }
        else {echo 1;}
        
        
    }

    public function schrijfJSONObject(){
        /**
        * haalt de waarden van het kamertype object op en update of insert deze in de database
        */
        $object = new stdClass();
        $object->id = $this->input->post('id');
        $object->omschrijving = $this->input->post('omschrijving');
       
        $this->load->model('kamerType_model');
        if ($object->id == 0) {
            $this->kamerType_model->insert($object);
        } else {
            $this->kamerType_model->update($object);
        }
        echo 0;
    }

    public function haalKamertypes(){
        /**
        * haalt kamertypes terug op
        */
        $this->load->model('kamerType_model');
        $data['types']= $this->kamerType_model->getAll();
        $this->load->view('admin/kamertype/ajax_kamertype', $data);
    }
}

