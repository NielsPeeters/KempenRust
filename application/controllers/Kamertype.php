<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kamertype extends CI_Controller {

    public function __construct() {
        /**
        * standaard controller constructor
        * laadt helpers
        */
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
        $user = $this->authex->getUserInfo();
        
        if($user->soort==3) {
        $this->load->model('kamerType_model');
        $data['types'] = $this->kamerType_model->getAll();
        

        $partials = array('navbar' => 'main_navbar', 'content' => 'admin/kamertype/kamertype_beheren', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
         } else {
            redirect("/home/index");
        }     
    }

    public function haalKamertype() {
        /**
         * haalt een kamertype object op
         */
        $kamerTypeId = $this->input->get('kamerTypeId');
        if($kamerTypeId<0){
            $data['type'] = $this->getEmptyKamertype();
        }
        else{
            $this->load->model('kamerType_model');
            $data['type'] = $this->kamerType_model->get($kamerTypeId);
        }
        
        
        $this->load->view("admin/kamertype/ajax_kamertype", $data);
    }

    function getEmptyKamertype() {
        /**
        * Creërt een leeg kamer object
        * \return kamer een leeg kamer object
        */
        $kamertype = new stdClass();

        $kamertype->id = '0';
        $kamertype->omschrijving = '';

        return $kamertype;
    }
    
    public function verwijderKamertype() {
        /**
         * verwijdert een kamertype object als hieraan geen kamers verbonden zijn
         */
        $id = $this->input->get('id');
        $this->load->model('kamer_model');
        $result = $this->kamer_model->getAllByType($id);
        $size = count($result);
        if ($size == 0) {
            $this->load->model('kamerType_model');
            $this->kamerType_model->delete($id);
            $this->load->model('prijs_model');
            $this->prijs_model->deleteByKamerTypeId($id);
            echo 0;
        } else {
            echo 1;
        }
    }

    public function schrijfJSONObject() {
        /**
         * haalt de waarden van het kamertype object op en update of insert deze in de database
         */
        $object = new stdClass();
        $object->id = $this->input->post('id');
        $object->omschrijving = ucfirst($this->input->post('omschrijving'));

        $this->load->model('kamerType_model');
        $this->load->model('prijs_model');
        if ($object->id == 0) {
            $id = $this->kamerType_model->insert($object);
            $this->prijs_model->insertPrijsByKamerTypeId($id);
        } else {
            $this->kamerType_model->update($object);
        }
        redirect("/kamertype/index");
    }

    public function haalKamertypes() {
        /**
         * haalt kamertypes terug op
         */
        $this->load->model('kamerType_model');
        $data['types'] = $this->kamerType_model->getAll();
        $this->load->view('admin/kamertype/ajax_kamertype', $data);
    }

}
