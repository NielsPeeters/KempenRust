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

        $this->load->model('typekamer_model');
        $data['types'] = $this->typekamer_model->getAll();

        $partials = array('navbar' => 'main_navbar', 'content' => 'admin/kamertype/kamertype_lijst', 'footer'=>'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
    
    public function overzicht() {
        $this->load->model('typekamer_model');
        $data['types'] = $this->typekamer_model->getAll();

        $this->load->view('admin/kamertype/kamertype_lijst', $data);
    }
    
    public function update() {
        $kamertype->id = $this->input->post('id');
        $kamertype->omschrijving = $this->input->post('omschrijving');

        $this->load->model('typekamer_model');
        if ($kamertype->id == 0) {
            $id = $this->typekamer_model->insert($kamertype);
        } else {
            $this->typekamer_model->update($kamertype);
        }

        echo $id;
    }
    
     public function detail() {
        $id = $this->input->get('id');
        $this->load->model('typekamer_model');
        $kamertype = $this->typekamer_model->get($id);
        echo json_encode($kamertype);
    }

    public function delete() {
        $id = $this->input->post('id');

        $this->load->model('typekamer_model');
        $deleted = $this->typekamer_model->delete($id);

        echo $deleted;
    }
}
