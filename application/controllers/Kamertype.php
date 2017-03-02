<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kamertype extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('notation');
        $this->load->library('email');
    }
    
    public function index() {
        $data['title'] = 'Kamertypes beheren';
        $data['author'] = 'Tim Van de Voorde';
        $data['user'] = $this->authex->getUserInfo();
        
           //model inladen
        $this->load->model('KamerType_model');
        $data['types'] = $this->KamerType_model->getAll();

        $partials = array('navbar' => 'main_navbar', 'content' => 'admin/kamertype/kamertype_lijst', 'footer'=>'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
    
    public function overzicht() {
        $this->load->model('KamerType_model');
        $data['types'] = $this->KamerType_model->getAll();

        $this->load->view('admin/kamertype/kamertype_lijst', $data);
    }
    
    public function update() {
        $kamertype->id = $this->input->post('id');
        $kamertype->omschrijving = $this->input->post('omschrijving');

        $this->load->model('KamerType_model');
        if ($kamertype->id == 0) {
            $id = $this->KamerType_model->insert($kamertype);
        } else {
            $this->KamerType_model->update($kamertype);
        }

        echo $id;
    }
    
     public function detail() {
        $id = $this->input->get('id');
        $this->load->model('KamerType_model');
        $kamertype = $this->KamerType_model->get($id);
        echo json_encode($kamertype);
    }

    public function delete() {
        $id = $this->input->post('id');

        $this->load->model('KamerType_model');
        $deleted = $this->KamerType_model->delete($id);

        echo $deleted;
    }
}
