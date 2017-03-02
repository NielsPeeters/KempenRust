<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kamer extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('notation');
    }

    public function index() {
        /**
        * Laadt de pagina waarop je kamers kan beheren
        * geeft een array van kamer objecten mee
        */
        $data['title'] = 'Kamers beheren';
        $data['author'] = 'Laenen Nathalie';
        $data['user'] = $this->authex->getUserInfo();

        $this->load->model('kamer_model');
        $data['kamers'] = $this->kamer_model->getAll();

        $partials = array('navbar' => 'main_navbar', 'content' => 'map/kamer_beheren', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function haalKamer() {
        /**
        * haalt een kamer object en alle kamertypes op
        */
        $kamerId = $this->input->get('kamerId');
        if($kamerId<0){
            $data['kamer'] = $this->getEmptyKamer();
        }
        else{
            $this->load->model('kamer_model');
            $data['kamer'] = $this->kamer_model->getWithKamerType($kamerId);
            }
        $this->load->model('kamerType_model');
        $data['kamertypes'] = $this->kamerType_model->getall();
        
        $this->load->view("map/ajax_kamer", $data);
    }

    public function verwijderKamer(){
        /**
        * verwijderdt een kamer object als hieraan geen boekingen verbonden zijn
        */
        $id = $this->input->get('id');
        $this->load->model('kamerboeking_model');
        $result = $this->kamerboeking_model->getAllByKamer($id);
        $size = count($result);
        if ($size==0){
            $this->load->model('kamer_model');
            $this->kamer_model->delete($id);
            echo 0;
        }
        else {echo 1;}
        
        
    }

    function getEmptyKamer() {
        /**
        * Creërt een leeg kamer object
        * \return kamer een leeg kamer object
        */
        $kamer = new stdClass();

        $kamer->id = '0';
        $kamer->naam = '';
        $kamer->aantalPersonen = '';
        $kamer->kamerTypeId = '1';
        $kamer->beschikbaar = '0';

        return $kamer;
    }

    public function schrijfJSONObject(){
        /**
        * haalt de waarden van het kamer object op en update of insert deze in de database
        */
        $object = new stdClass();
        $object->id = $this->input->post('id');
        $object->naam = $this->input->post('naam');
        $object->aantalPersonen = $this->input->post('aantalpersonen');
        $object->kamerTypeId = $this->input->post('kamertype');
        $object->beschikbaar = $this->input->post('beschikbaar');

        $this->load->model('kamer_model');
        if ($object->id == 0) {
            $this->kamer_model->insert($object);
        } else {
            $this->kamer_model->update($object);
        }
        echo 0;
        //redirect('/kamer/index');
    }

    public function haalKamers(){
        $this->load->model('kamer_model');
        $data['kamers']= $this->kamer_model->getAll();
        $this->load->view('map/ajax_kamers', $data);
    }

}
