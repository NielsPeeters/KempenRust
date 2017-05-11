<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Factuur extends CI_Controller {

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
         * Laadt de pagina waarop je facturen kan beheren/afprinten
         * geeft een array van factuur objecten mee
         */
        $data['title'] = 'Facturen beheren';
        $data['author'] = 'Peeters Niels';
        $data['user'] = $this->authex->getUserInfo();
        $user = $this->authex->getUserInfo();
        if($user->soort>1) {
            $this->load->model('Factuur_model');
            $this->load->model('Boeking_model');
            $data['facturen'] = $this->Factuur_model->getAllWithBoekingWithPersoon();


            $partials = array('navbar' => 'main_navbar', 'content' => 'werknemer/factuur/factuur_beheren', 'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        } else {
            redirect("/home/index");
        }
    }

    public function haalFactuur() {
        /**
         * Haalt een factuur object op
         */
        $factuurId = $this->input->get('factuurId');
        if($factuurId<0){
            $this->newFactuur();
        }
        else{
            $this->load->model('Factuur_model');
            $data['factuur']= $this->Factuur_model->getFactuurWithBooking($factuurId);
            $this->load->model('Boeking_model');
            $data['boeking']= $this->Boeking_model->getBoekingWithAll($data['factuur']->boekingId);
            $this->load->model('BoekingTypePersoon_model');
            $data['boekingTypePersonen'] = $this->BoekingTypePersoon_model->getByBoeking($data['factuur']->boekingId);
            $this->load->model('arrangement_model');
            $data['arrangementen'] = $this->arrangement_model->getAll();
            $this->load->model('typePersoon_model');
            $data['typePersonen'] = $this->typePersoon_model->getAll();
            $this->load->model('pension_model');
            $data['pensions'] = $this->pension_model->getAll();
            $this->load->model('kamerBoeking_model');
            $data['kamerBoekingen'] = $this->kamerBoeking_model->getWithBoeking($data['factuur']->boekingId);
            $this->load->model('kamer_model');
            $data['kamers'] = $this->kamer_model->getAllWithKamerType();


            $this->load->view("werknemer/factuur/ajax_factuur", $data);

        }
    }


    public function verwijderboeking(){
        /**
         * Verwijdert een factuur object als hieraan geen boekingen verbonden zijn
        */
        $user = $this->authex->getUserInfo();
        if($user->soort>2) {
            $id = $this->input->get('id');
            $this->load->model('boekingboeking_model');
            $result = $this->boekingboeking_model->getAllByboeking($id);
            $size = count($result);
            if ($size == 0) {
                $this->load->model('Factuur_model');
                $this->Factuur_model->delete($id);
                echo 0;
            } else {
                echo 1;
            }
        }
    }


    function newFactuur() {
        /**
         * Creërt een leeg factuur object
         */

        $data['factuur']=$this->getEmptyFactuur();

        $this->load->model('kamerType_model');
        $data['kamerTypes'] = $this->kamerType_model->getAll();

        $this->load->model('Boeking_model');
        $data['boeking']= $this->Boeking_model->getAll();

        $this->load->model('arrangement_model');
        $data['arrangementen'] = $this->arrangement_model->getAll();

        $this->load->model('typePersoon_model');
        $data['typePersonen'] = $this->typePersoon_model->getAll();

        $this->load->model('pension_model');
        $data['pensions'] = $this->pension_model->getAll();

        $this->load->view("werknemer/factuur/ajax_factuur", $data);
    }

    public function getEmptyFactuur(){
        /**
         * Ophalen en invullen van een niew factuur object
         * \return factuur een leef factuur object
         */
        $factuur = new stdClass();

        $factuur->id = '0';
        $factuur->boekingId='0';
        $factuur->betaald = False;
        $factuur->datumFactuur= date('Y/m/D H:M:S');
        $factuur->datumBetaling= null;
        $factuur->voorschotBetaald= False;

        return $factuur;
    }

    public function schrijfFactuur(){
        /**
         * Haalt de waarden van het factuur object op en update of insert deze in de database
         */
        $object = new stdClass();
        $object->id = $this->input->post('id');
        $object->naam = ucfirst(strtolower($this->input->post('naam')));

        $this->load->model('Factuur_model');
        if ($object->id == 0) {
            $this->Factuur_model->insert($object);
        } else {
            $this->Factuur_model->update($object);
        }
        echo 0;
    }







}
