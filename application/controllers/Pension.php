<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pension extends CI_Controller {

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
        * Laadt de pagina waarop je de pensions kan beheren
        * geeft een array van pension objecten mee
        */
        $data['title'] = 'Pensions beheren';
        $data['author'] = 'Laenen Nathalie';
        $data['user'] = $this->authex->getUserInfo();
        $user = $this->authex->getUserInfo();
        if($user->soort>=3) {
            $this->load->model('arrangement_model');
            $data['pensions'] = $this->arrangement_model->getAllPensions();

            $partials = array('navbar' => 'main_navbar', 'content' => 'admin/pension/pension_beheren', 'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        } else {
            redirect("/home/index");
        }       
    }

    public function haalPension() {
        /**
        * Haalt een pension object op
        */
        $pensionId = $this->input->get('pensionId');
        if($pensionId<0){
            $data['pension'] = $this->getEmptyPension();
        }
        else{
            $this->load->model('arrangement_model');
            $data['pension'] = $this->arrangement_model->get($pensionId);
            }
        $this->load->view("admin/pension/ajax_pension", $data);
    }

    public function verwijderPension(){
        /**
        * Verwijdert een pension object
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

    function getEmptyPension() {
        /**
        * Creërt een leeg pension object
        * \return pension een leeg pension object
        */
        $pension = new stdClass();

        $pension->id = 0;
        $pension->naam = '';
        $pension->beginDag = null;
        $pension->eindDag = null;
        $pension->omschrijving = '';
        $pension->isArrangement = 0;
        
        return $pension;
    }

    public function schrijfPension(){
        /**
        * Haalt de waarden van het pension object op en update of insert deze in de database
        */
        $object = new stdClass();
        $object->id = $this->input->post('id');
        $object->naam = ucfirst(strtolower($this->input->post('naam')));
        $object->beginDag = null;
        $object->eindDag = null;
        $object->omschrijving = ucfirst($this->input->post('omschrijving'));
        $object->isArrangement = 0;
            
        $this->load->model('arrangement_model');
        $this->load->model('prijs_model');
        if ($object->id == 0) {
            $id = $this->arrangement_model->insert($object);
            $this->prijs_model->insertPrijsByArrangemantId($id);
        } else {
            $this->arrangement_model->update($object);
        }
        redirect('pension/index');
    }
}
