<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class kamertype extends CI_Controller {

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
        

        $this->load->model('typekamer_model');
        $data['types'] = $this->typekamer_model->getAll();

        $partials = array('navbar' => 'main_navbar', 'content' => 'admin/kamertype/kamertype_lijst', 'footer'=>'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
    
    public function overzicht() {
        $this->load->model('typeKamer_model');
        $data['types'] = $this->typeKamer_model->getAll();

        $this->load->view('admin/kamertype/kamertype_lijst', $data);
    }
    
    public function update() {
        $kamertype->id = $this->input->post('id');
        $kamertype->omschrijving = $this->input->post('omschrijving');

        $this->load->model('typeKamer_model');
        if ($kamertype->id == 0) {
            $id = $this->typeKamer_model->insert($kamertype);
        } else {
            $this->typeKamer_model->update($kamertype);
        }

        echo $id;
    }
    
     public function detail() {
        $id = $this->input->get('id');
        $this->load->model('typeKamer_model');
        $kamertype = $this->typeKamer_model->get($id);
        echo json_encode($kamertype);
    }

    public function delete() {
        $id = $this->input->post('id');

        $this->load->model('typeKamer_model');
        $deleted = $this->typeKamer_model->delete($id);

        echo $deleted;
    }
}
