<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class TypePersoon extends CI_Controller{
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
         * Laadt de pagina waarop je typepersoonen kan beheren
         * geeft een array van typepersoon objecten mee
         */
        $data['title'] = 'Persoontype\'s beheren';
        $data['author'] = 'Peeters Niels';
        $data['user'] = $this->authex->getUserInfo();
        $user = $this->authex->getUserInfo();
        if($user->soort==3) {
            $this->load->model('TypePersoon_model');
            $data['typePersonen'] = $this->TypePersoon_model->getAll();

            $partials = array('navbar' => 'main_navbar', 'content' => 'admin/typePersoon/typePersoon_beheren', 'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        } else {
            redirect("/home/index");
        }
    }

    public function haalTypePersoon() {
        /**
         * Haalt een typepersoon object en alle Types op
         */
        $typePersoonId = $this->input->get('typePersoon');
        if($typePersoonId<0){
            $data['typePersoon'] = $this->getEmptyTypePersoon();
        }
        else{
            $this->load->model('TypePersoon_model');
            $data['typePersoon'] = $this->TypePersoon_model->getWithTypePersoon($typePersoonId);
        }

        $this->load->view("admin/typePersoon/ajax_typePersoon", $data);
    }

    public function verwijderTypePersoon(){
        /**
         * Verwijderdt een TypePersoon object als hieraan geen boekingen verbonden zijn
         */
        $id = $this->input->get('id');
        $this->load->model('BoekingTypePersoon_model');
        $result = $this->BoekingTypePersoon_model->getAllByTypePersoon($id);
        $size = count($result);
        if ($size==0){
            $this->load->model('TypePersoon_model');
            $this->TypePersoon_model->delete($id);
            echo 0;
        }
        else {echo 1;}


    }

    function getEmptyTypePersoon() {
        /**
         * Creërt een leeg typepersoon object
         * \return typePersoon een leeg typepersoon object
         */
        $typePersoon = new stdClass();

        $typePersoon->id = '0';
        $typePersoon->soort = '';
        $typePersoon->korting = '';


        return $typePersoon;
    }

    public function schrijfTypePersoon(){
        /**
         * Haalt de waarden van het typepersoon object op en update of insert deze in de database
         */
        $object = new stdClass();
        $object->id = $this->input->post('id');
        $object->soort = $this->input->post('soort');
        $object->korting = $this->input->post('korting');

        $this->load->model('TypePersoon_model');
        if ($object->id == 0) {
            $this->TypePersoon_model->insert($object);
        } else {
            $this->TypePersoon_model->update($object);
        }
        redirect('TypePersoon/index');
    }
}