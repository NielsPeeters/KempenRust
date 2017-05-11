<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class KamerBoeking extends CI_Controller {

    /**
     * KamerBoeking controller
     * Verzorgt communicatie tussen model en view
     */
    public function __construct() {
        /**
         * standaard controller constructor
         * laadt helpers
         */
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('notation');
    }

    public function getWithBoeking($id) {
        /**
         * haalt specifieke boeking met id
         * \param $id id van gekozen kamer
         */
        $this->load->model('kamerBoeking_model');
        $data['kamers'] = $this->kamerBoeking_model->getWithBoeking($id);
        $this->load->view("werknemer/boeking/ajax_kamerBoeking", $data);
    }

    public function verwijder($id) {
        /**
         * Verwijdert een boeking object als hieraan geen boekingen verbonden zijn
         * \param $id het id van de te verwijderen kamer
         */
        $this->load->model('kamerBoeking_model');
        $this->kamerBoeking_model->delete($id);
        echo 0;
    }

    function newBoeking() {
        /**
         * Creërt een leeg boeking object
         * \return boeking een leeg boeking object
         */
        $data['boeking'] = $this->getEmptyBoeking();

        $this->load->model('kamerType_model');
        $data['kamerTypes'] = $this->kamerType_model->getAll();

        $this->load->model('arrangement_model');
        $data['arrangementen'] = $this->arrangement_model->getAll();

        $this->load->model('typePersoon_model');
        $data['typePersonen'] = $this->typePersoon_model->getAll();

        $this->load->model('pension_model');
        $data['pensions'] = $this->pension_model->getAll();

        foreach ($data['typePersonen']as $typepersoon) {
            $data['boekingTypePersonen'] = $this->getEmptyBoekingTypePersoon($typepersoon->id);
        }

        $this->load->view("werknemer/boeking/ajax_boeking", $data);
    }

}
