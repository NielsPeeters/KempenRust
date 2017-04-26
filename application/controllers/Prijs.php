<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class prijs extends CI_Controller {

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
        * Laadt de pagina waarop je prijzen kan beheren
        * geeft een array van prijs objecten mee
        */
        $data['title'] = 'Prijzen beheren';
        $data['author'] = 'Peeters Niels';
        $data['user'] = $this->authex->getUserInfo();
        $user = $this->authex->getUserInfo();
        if($user->soort==3) {
            $this->load->model('Arrangement_model');
            $data['arrangementen'] = $this->Arrangement_model->getAll();

            $this->load->model('KamerType_model');
            $data['kamerTypes'] = $this->KamerType_model->getAll();

            $partials = array('navbar' => 'main_navbar', 'content' => 'admin/prijs/prijs_beheren', 'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        } else {
            redirect("/home/index");
        }       
    }

    public function haalprijs() {
        /**
        * Haalt een prijs object en alle prijstypes op
        */
        $arrangementId = $this->input->get('arrangementId');
        $kamerTypeId = $this->input->get('kamerTypeId');

        $this->load->model('prijs_model');
        $data['prijzen'] = $this->prijs_model->getPrijsByArrangementAndKamerType($arrangementId, $kamerTypeId);
        $this->load->view("admin/prijs/ajax_prijs", $data);
    }

    public function schrijfprijs(){
        /**
        * Haalt de waarden van het prijs object op en update of insert deze in de database
        */
        $prijs0 = new stdClass();
        $prijs1 = new stdClass();

        $prijs0->id = $this->input->post('id0');
        $prijs1->id = $this->input->post('id1');
        $prijs0->actuelePrijs = $this->input->post('prijs0');
        $prijs1->actuelePrijs = $this->input->post('prijs1');

        $this->load->model('prijs_model');
        $this->prijs_model->update($prijs0);
        $this->prijs_model->update($prijs1);
        redirect('prijs/index');
    }


}
