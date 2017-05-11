<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Persoon extends CI_Controller {
     /**
      * Persoon controller
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
        $this->load->library('email');
    }

    public function index() {
        /**
         * Laadt de pagina waarop je personen kan beheren
         * geeft een array van persoon objecten mee
         */
        $data['title'] = 'Personen beheren';
        $data['author'] = 'Van de Voorde Tim';
        $data['user'] = $this->authex->getUserInfo();
        $user = $this->authex->getUserInfo();
        if ($user->soort == 3) {
            $this->load->model('persoon_model');
            $data['klanten'] = $this->persoon_model->getAll();

            $partials = array('navbar' => 'main_navbar', 'content' => 'admin/klant/klant_beheren', 'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        } else {
            redirect("/home/index");
        }
    }

    public function haalPersoon() {
        /**
         * haalt een persoon object op
         */
        $persoonId = $this->input->post('persoonId');
        if ($persoonId < 0) {
            $data['klant'] = $this->getEmptyPersoon();
        } else {
            $this->load->model('persoon_model');
            $data['klant'] = $this->persoon_model->get($persoonId);
        }


        $this->load->view("admin/klant/ajax_klant", $data);
    }

    function getEmptyPersoon() {
        /**
         * haalt een leeg persoonobject op
         */
        $persoon = new stdClass();

        $persoon->id = 0;
        $persoon->naam = '';
        $persoon->voornaam = '';
        $persoon->gemeente = '';
        $persoon->soort = '1';
        $persoon->huisnummer = '';
        $persoon->straat = '';
        $persoon->postcode = '';
        $persoon->telefoon = '';
        $persoon->bus = '';
        $persoon->email = '';
        $persoon->wachtwoord = '';

        return $persoon;
    }

    public function verwijderPersoon() {
        /**
         * Verwijdert een persoon object als hieraan geen boekingen verbonden zijn
         */
        $id = $this->input->get('id');
        
        $this->load->model('persoon_model');
        $persoon = $this->persoon_model->get($id);
        
        $this->load->model('boeking_model');
        $result = $this->boeking_model->getAllByPersoon($id);
        $size = count($result);
        if ($size == 0 && $persoon->soort != 3) {
            $this->load->model('persoon_model');
            $this->persoon_model->delete($id);
            echo 0;
        } else {
            echo 1;
        }
    }

    public function schrijfJSONObject() {
        /**
         * haalt de waarden van het persoon object op en update of insert deze in de database
         */
        $object = new stdClass();

        $object->id = $this->input->post('id');
        $object->naam = ucfirst(strtolower($this->input->post('naam')));
        $object->voornaam = ucfirst(strtolower($this->input->post('voornaam')));
        $object->postcode = $this->input->post('postcode');
        $object->gemeente = ucfirst(strtolower($this->input->post('gemeente')));
        $object->straat = ucfirst(strtolower($this->input->post('straat')));
        $object->huisnummer = $this->input->post('huisnummer');
        $object->bus = $this->input->post('bus');
        $object->telefoon = $this->input->post('telefoon');
        $object->email = strtolower($this->input->post('email'));
        //$object->wachtwoord = $this->input->post('wachtwoord');  
        $wachtwoord = $this->input->post('wachtwoord');
        if($this->input->post('wachtwoord') != "" || $this->input->post('wachtwoord') != null){
            $object->wachtwoord = sha1($wachtwoord);
        }
        $object->soort = $this->input->post('soort');

        $this->load->model('persoon_model');
        if ($object->id == 0) {
            $this->persoon_model->insert($object);
        } else {
            $this->persoon_model->update($object);
        }
        redirect("/persoon/index");
    }

    public function haalPersonen() {
        /**
         * haalt personen terug op
         */
        $this->load->model('persoon_model');
        $data['klanten'] = $this->persoon_model->getAll();
        $this->load->view('admin/persoon/ajax_persoon', $data);
    }

    public function registreer() {
        /**
         * registreert een persoon
         */
        $persoon = new stdClass();

        $persoon->naam = $this->input->post('naam');
        $persoon->voornaam = $this->input->post('voornaam');
        $persoon->email = $this->input->post('email');
        $persoon->straat = $this->input->post('straat');
        $persoon->bus = $this->input->post('bus');
        $persoon->huisnummer = $this->input->post('huisnummer');
        $persoon->gemeente = $this->input->post('gemeente');
        $persoon->postcode = $this->input->post('postcode');
        $persoon->telefoon = $this->input->post('telefoon');
        $persoon->soort = "1";
        $wachtwoord = $this->input->post('wachtwoord');
        $persoon->wachtwoord = sha1($wachtwoord);
        $persoon->id = $this->authex->register($persoon->email, $persoon);
        $this->emailVrij($persoon);
    }

    public function emailVrij($persoon) {
        /**
         * gaat terug naar registreerpagina
         * \param $persoon persoon dat ingelogd is
         */
        if ($persoon->id == 0) {
            //email adres is al in gebruik
            $emailVrij = "0";
            $this->naarRegistreer($persoon, $emailVrij);
        } else {
            //user account aangemaakt
            redirect('home/index');
        }
    }

    public function naarRegistreer($persoon, $emailVrij) {
        /**
         * gaat terug naar registreerpagina
         * \param $persoon persoon dat ingelogd is
         * \param $emailVrij is email nog vrij of niet
         */
        $data['emailVrij'] = $emailVrij;
        $data['persoon'] = $persoon;
        $data['title'] = 'Registeer';
        $data['author'] = 'Laenen Nathalie';
        $data['user'] = $this->authex->getUserInfo();
        $partials = array('navbar' => 'main_navbar', 'content' => 'gebruiker/registreer', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function nieuw() {
        /**
         * gaat naar registreren
         */
        $data['title'] = 'Registreer';
        $data['persoon'] = $this->getEmptyPersoon();
        $data['emailVrij'] = "1"; //email niet in gebruik
        $data['author'] = 'Laenen Nathalie';
        $data['user'] = $this->authex->getUserInfo();
        $partials = array('navbar' => 'main_navbar', 'content' => 'gebruiker/registreer', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

}
