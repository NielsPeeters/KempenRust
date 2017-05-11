<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Arrangement extends CI_Controller {

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
        * Laadt de pagina waarop je de arrangementen kan beheren
        * geeft een array van arrangement objecten mee
        */
        $data['title'] = 'Arrangementen beheren';
        $data['author'] = 'Peeters Ellen';
        $data['user'] = $this->authex->getUserInfo();
        $user = $this->authex->getUserInfo();
        if($user->soort>=3) {
            $this->load->model('arrangement_model');
            $data['arrangementen'] = $this->arrangement_model->getAllArrangementen();

            $partials = array('navbar' => 'main_navbar', 'content' => 'admin/arrangement/arrangement_beheren', 'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        } else {
            redirect("/home/index");
        }       
    }

    public function haalArrangement() {
        /**
        * Haalt een arrangement object op
        */
        $arrangementId = $this->input->get('arrangementId');
        if($arrangementId<0){
            $data['arrangement'] = $this->getEmptyArrangement();
        }
        else{
            $this->load->model('arrangement_model');
            $data['arrangement'] = $this->arrangement_model->get($arrangementId);
        }
        $this->load->view("admin/arrangement/ajax_arrangement", $data);
    }

    public function verwijderArrangement(){
        /**
        * Verwijdert een arrangement object
        */
        $id = $this->input->get('id');
        $this->load->model('boeking_model');
        $result = $this->boeking_model->getAllByArrangement($id);
        $size = count($result);
        if ($size==0){
            $this->load->model('arrangement_model');
            $this->arrangement_model->delete($id);
            $this->load->model('prijs_model');
            $this->prijs_model->deleteByArrangementId($id);
            echo 0;
        } else {
            echo 1;
        }
    }

    function getEmptyArrangement() {
        /**
        * Creërt een leeg arrangement object
        * \return arrangement een leeg arrangement object
        */
        $arrangement = new stdClass();

        $arrangement->id = '0';
        $arrangement->naam = '';
        $arrangement->beginDag = '';
        $arrangement->eindDag = '';
        $arrangement->omschrijving = '';
        $arrangement->isArrangement = 1;
        
        return $arrangement;
    }

    public function schrijfArrangement(){
        /**
        * Haalt de waarden van het arrangement object op en update of insert deze in de database
        */

        $object = new stdClass();
        $object->id = $this->input->post('id');
        $object->naam = ucfirst(strtolower($this->input->post('naam')));
        $object->beginDag = ucfirst(strtolower($this->input->post('begindag')));
        $object->eindDag = ucfirst(strtolower($this->input->post('einddag')));
        $object->omschrijving = ucfirst($this->input->post('omschrijving'));
        $object->isArrangement = 1;
        
        $this->load->model('arrangement_model');
        $this->load->model('prijs_model');
        if ($object->id == 0) {
            $id = $this->arrangement_model->insert($object);
            $this->prijs_model->insertPrijsByArrangemantId($id);
        } else {
            $this->arrangement_model->update($object);
        }
        
        redirect('arrangement/index');
    }
}
