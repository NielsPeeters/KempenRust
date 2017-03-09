<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {
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
        * Laadt de pagina waarop je menu's kan beheren
        * geeft een array van menu objecten mee
        */
        $data['title'] = 'Faciliteiten beheren';
        $data['author'] = 'Ellen Peeters';
        $data['user'] = $this->authex->getUserInfo();
        $user = $this->authex->getUserInfo();
        if($user->soort==3) {
            $this->load->model('menu_model');
            $data['menus'] = $this->menu_model->getAll();

            $partials = array('navbar' => 'main_navbar', 'content' => 'admin/menu/menu_beheren', 'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        } else {
            redirect("/home/index");
        }       
    }

    public function haalMenu() {
        /**
        * Haalt een menu object op
        */
        $menuId = $this->input->get('menuId');
        if($menuId<0){
            $data['menu'] = $this->getEmptyMenu();
        }
        else{
            $this->load->model('menu_model');
            $data['menu'] = $this->menu_model->get($menuId);
        }
        
        $this->load->view("admin/menu/ajax_menu", $data);
    }

    public function verwijderMenu(){
        /**
        * Verwijdert een menu object
        */
        $id = $this->input->get('id');
        $this->load->model('menu_model');
        $resultArrangementen = $this->menu_model->getWithArrangementen($id);
        $resultBoekingen = $this->menu_model->getWithBoekingen($id);
        
        if(count($resultArrangementen) == 0 && count($resultBoekingen) == 0){
            $this->menu_model->delete($id);
            echo 0;
        } else {
            echo -1;
        }
    }

    function getEmptyMenu() {
        /**
        * Creërt een leeg menu object
        * \return menu een leeg menu object
        */
        $menu = new stdClass();

        $menu->id = '0';
        $menu->naam = '';

        return $menu;
    }

    public function schrijfMenu(){
        /**
        * Haalt de waarden van het menu object op en update of insert deze in de database
        */
        $object = new stdClass();
        $object->id = $this->input->post('id');
        $object->naam = $this->input->post('naam');

        $this->load->model('menu_model');
        if ($object->id == 0) {
            $this->menu_model->insert($object);
        } else {
            $this->menu_model->update($object);
        }
        redirect('menu/index');
    }
}