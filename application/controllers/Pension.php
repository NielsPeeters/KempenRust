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
            $this->load->model('pension_model');
            $data['pensions'] = $this->pension_model->getAll();

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
            $this->load->model('pension_model');
            $data['pension'] = $this->pension_model->get($pensionId);
            }
        $this->load->view("werknemer/pension/ajax_pension", $data);
    }

    public function verwijderPension(){
        /**
        * Verwijderdt een pension object
        */
        $id = $this->input->get('id');
        $this->load->model('arrangement_model');
        $arrangement = $this->arrangement_model->getAllByPension($id);
        
        $this->load->model('boeking_model');
        $result = $this->boeking_model->getAllByArrangement($arrangement->id);
        $size = count($result);
        if ($size==0){
            $this->arrangement_model->delete($arrangement->id);
            
            $this->load->model('pension_model');
            $this->pension_model->delete($id);
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

        $pension->id = '0';
        $pension->naam = '';
        return $pension;
    }

    public function schrijfPension(){
        /**
        * Haalt de waarden van het pension object op en update of insert deze in de database
        */
        $object = new stdClass();
        $object->id = $this->input->post('id');
        $object->naam = $this->input->post('naam');

        $arrangement = $this->getEmptyArrangement($object->naam, $object->id);
            
        $this->load->model('pension_model');
        $this->load->model('arrangement_model');
        if ($object->id == 0) {
            $pensionId = $this->pension_model->insert($object);
            
            $arrangement->pensionId = $pensionId;
            
            $this->arrangement_model->insert($arrangement);
        } else {
            $this->pension_model->update($object);

            $this->arrangement_model->update($arrangement);
        }
        redirect('pension/index');
    }
    
    function getEmptyArrangement($naam, $pensionId){
        $arrangement = new stdClass();
        $arrangement->naam = 'Pension';
        $arrangement->beginDag = null;
        $arrangement->eindDag = null;
        $arrangement->omschrijving = $naam;
        $arrangement->isArrangement = 0;
        $arrangement->pensionId = $pensionId;
        
        return $arrangement;
    }
}
