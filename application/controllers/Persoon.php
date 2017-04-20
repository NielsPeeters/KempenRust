<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Persoon extends CI_Controller {

    public function __construct() {
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
         * Verwijderdt een persoon object als hieraan geen boekingen verbonden zijn
         */
        $id = $this->input->get('id');
        $this->load->model('boeking_model');
        $result = $this->boeking_model->getAllByPersoon($id);
        $size = count($result);
        if ($size == 0) {
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
        $object->naam = $this->input->post('naam');
        $object->voornaam = $this->input->post('voornaam');
        $object->postcode = $this->input->post('postcode');
        $object->gemeente = $this->input->post('gemeente');
        $object->straat = $this->input->post('straat');
        $object->huisnummer = $this->input->post('huisnummer');
        $object->bus = $this->input->post('bus');
        $object->telefoon = $this->input->post('telefoon');
        $object->email = $this->input->post('email');
        //$object->wachtwoord = $this->input->post('wachtwoord');      
        $wachtwoord = $this->input->post('wachtwoord');
        $object->wachtwoord = sha1($wachtwoord);
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
        $data['emailVrij'] = $emailVrij;
        $data['persoon'] = $persoon;
        $data['title'] = 'Registeer';
        $data['author'] = 'Laenen Nathalie';
        $data['user'] = $this->authex->getUserInfo();
        $partials = array('navbar' => 'main_navbar', 'content' => 'gebruiker/registreer', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function nieuw() {
        $data['title'] = 'Registreer';
        $data['persoon'] = $this->getEmptyPersoon();
        $data['emailVrij'] = "1"; //email niet in gebruik
        $data['author'] = 'Laenen Nathalie';
        $data['user'] = $this->authex->getUserInfo();
        $partials = array('navbar' => 'main_navbar', 'content' => 'gebruiker/registreer', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

}
