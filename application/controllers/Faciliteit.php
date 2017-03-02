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
        /**
        * Laadt de pagina waarop je faciliteiten kan beheren
        * geeft een array van faciliteit objecten mee
        */
        $data['title'] = 'Faciliteiten beheren';
        $data['author'] = 'Ellen Peeters';
        $data['user'] = $this->authex->getUserInfo();
        
        $this->load->model('Faciliteit_model'); /**< model inladen */
        $data['types'] = $this->Faciliteit_model->getAll();

        $partials = array('navbar' => 'main_navbar', 'content' => 'admin/faciliteit/faciliteit_beheren', 'footer'=>'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function haalFaciliteit() {
        /**
         * haalt een faciliteit object op
         */
        $faciliteitId = $this->input->get('$faciliteitId');

        if ($faciliteitId < 0) {
            $data['type'] = $this->getEmptyFaciliteit();
        } else {
            $this->load->model('Faciliteit_model');
            $data['type'] = $this->Faciliteit_model->get($faciliteitId);
        }

        $this->load->view("admin/faciliteit/ajax_faciliteit", $data);
    }

    function getEmptyFaciliteit() {
        /**
        * Creërt een leeg faciliteit object
        * \return faciliteit een leeg faciliteit object
        */
        $faciliteit = new stdClass();

        $faciliteit->id = 0;
        $faciliteit->naam = '';
        $faciliteit->prijs = 0;

        return $faciltieit;
    }
    
    public function verwijderFaciliteit() {
        /**
         * verwijdert een faciliteit object als hieraan geen boekingen verbonden zijn
         */
        $id = $this->input->get('id');
        $this->load->model('Extra_model');
        $result = $this->Extra_model->getAllByFaciliteit($id);
        $size = count($result);
        if ($size == 0) {
            $this->load->model('Faciliteit_model');
            $this->Faciliteit_model->delete($id);
            echo 0;
        } else {
            echo 1;
        }
    }

    public function schrijfJSONObject() {
        /**
         * haalt de waarden van het faciliteit object op en update of insert deze in de database
         */
        $object = new stdClass();
        $object->id = $this->input->post('id');
        $object->naam = $this->input->post('naam');

        $this->load->model('Faciliteit_model');
        if ($object->id == 0) {
            $this->Faciliteit_model->insert($object);
        } else {
            $this->Faciliteit_model->update($object);
        }
        echo 0;
    }

    public function haalKamertypes() {
        /**
         * haalt faciliteiten terug op
         */
        $this->load->model('Faciliteit_model');
        $data['types'] = $this->Faciliteit_model->getAll();
        $this->load->view('admin/faciliteit/ajax_faciliteit', $data);
    }
}
