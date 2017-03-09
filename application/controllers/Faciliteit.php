<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Faciliteit extends CI_Controller {
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
        * Laadt de pagina waarop je faciliteiten kan beheren
        * geeft een array van faciliteit objecten mee
        */
        $data['title'] = 'Faciliteiten beheren';
        $data['author'] = 'Ellen Peeters';
        $data['user'] = $this->authex->getUserInfo();
        $user = $this->authex->getUserInfo();
        if($user->soort==3) {
            $this->load->model('faciliteit_model');
            $data['faciliteiten'] = $this->faciliteit_model->getAll();

            $partials = array('navbar' => 'main_navbar', 'content' => 'admin/faciliteit/faciliteit_beheren', 'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        } else {
            redirect("/home/index");
        }       
    }

    public function haalFaciliteit() {
        /**
        * Haalt een faciliteit object op
        */
        $faciliteitId = $this->input->get('faciliteitId');
        if($faciliteitId<0){
            $data['faciliteit'] = $this->getEmptyFaciliteit();
        }
        else{
            $this->load->model('faciliteit_model');
            $data['faciliteit'] = $this->faciliteit_model->get($faciliteitId);
        }
        
        $this->load->view("admin/faciliteit/ajax_faciliteit", $data);
    }

    public function verwijderFaciliteit(){
        /**
        * Verwijdert een faciliteit object
        */
        $id = $this->input->get('id');
        $this->load->model('faciliteit_model');
        $this->faciliteit_model->delete($id);
        
        echo 0;
    }

    function getEmptyFaciliteit() {
        /**
        * Creërt een leeg faciliteit object
        * \return faciliteit een leeg faciliteit object
        */
        $faciliteit = new stdClass();

        $faciliteit->id = '0';
        $faciliteit->naam = '';
        $faciliteit->prijs = '0';

        return $faciliteit;
    }

    public function schrijfFaciliteit(){
        /**
        * Haalt de waarden van het faciliteit object op en update of insert deze in de database
        */
        $object = new stdClass();
        $object->id = $this->input->post('id');
        $object->naam = $this->input->post('naam');
        $object->prijs = $this->input->post('prijs');

        $this->load->model('faciliteit_model');
        if ($object->id == 0) {
            $this->faciliteit_model->insert($object);
        } else {
            $this->faciliteit_model->update($object);
        }
        redirect('faciliteit/index');
    }
}
