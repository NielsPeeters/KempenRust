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
        $data['title'] = 'Personen beheren';

        $this->load->model('persoon_model');
        $data['personen'] = $this->persoon_model->getAll();

        $partials = array('header' => 'main_header', 'content' => 'map/persoon_lijst');
        $this->template->load('main_master', $partials, $data);
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
        $persoon->postcode ='';
        $persoon->telefoon='';
        $persoon->bus = '';
        $persoon->email ='';
        $persoon->wachtwoord='';

        return $persoon;
    }

    public function toevoegen() {
        $data['persoon'] = $this->getEmptyPersoon();
        $data['title'] = 'Persoon toevoegen';

        $partials = array('header' => 'main_header', 'content' => 'map/persoon_lijst');
        $this->template->load('main_master', $partials, $data);
    }

    public function wijzigen($id) {
        $this->load->model('persoon_model');
        $data['persoon'] = $this->persoon_model->update($id);
        $data['title'] = 'Persoon wijzigen';

        $partials = array('header' => 'main_header', 'content' => 'map/persoon_lijst');
        $this->template->load('main_master', $partials, $data);
    }

    public function verwijderen($id) {
        $this->load->model('persoon_model');
        $data['persoon'] = $this->persoon_model->delete($id);

        redirect('/brouwerij/index');
    }

    public function haalpersoon() {
      $persoonId = $this->input->get('persoonId');
      $this->load->model('persoon_model');
      $data['persoon']= $this->persoon_model->get($persoonId);
      $this->load->view("map/ajax_persoon", $data);
    }

    public function verwijderPersoon()
    {
         $id = $this->input->post('id');
         $this->load->model('persoon_model');
         $this->soort_model->delete($id);
      
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
        $persoon->wachtwoord=sha1($wachtwoord);
        $persoon->id = $this->authex->register($persoon->email, $persoon);
        $this->emailVrij($persoon);
    }

        public function emailVrij($persoon){
              if ($persoon->id == 0) {
                //email adres is al in gebruik
                $emailVrij="0";
                $this->naarRegistreer($persoon,$emailVrij);
            } else {
                //user account aangemaakt
                redirect('home/index');
            }
        }

        public function naarRegistreer($persoon,$emailVrij){
            $data['emailVrij']=$emailVrij;
            $data['persoon']= $persoon;
            $data['title']= 'Registeer';
            $data['author'] = 'Laenen Nathalie';
            $data['user'] = $this->authex->getUserInfo();
            $partials = array('navbar' => 'main_navbar','content' => 'map/registreer','footer'=>'main_footer');
            $this->template->load('main_master', $partials, $data);
        }

      public function nieuw() {
        $data['title'] = 'Registreer';
        $data['persoon']= $this->getEmptyPersoon();
        $data['emailVrij']="1"; //email niet in gebruik
        $data['author'] = 'Laenen Nathalie';
        $data['user'] = $this->authex->getUserInfo();
        $partials = array('navbar' => 'main_navbar','content' => 'map/registreer','footer'=>'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

   

    

}
