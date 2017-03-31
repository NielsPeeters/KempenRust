<?php
class Klant extends CI_Controller {
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
        * Laadt de pagina waarop je boeking kan maken
        */
        $data['title'] = 'Boeking maken';
        $data['author'] = 'Peeters Ellen';
        $data['user'] = $this->authex->getUserInfo();
        $user = $this->authex->getUserInfo();
        if($user->soort==1) {
            $this->load->model('arrangement_model');
            $arrangementen = $this->arrangement_model->getAllArrangementen();
            $data["arrangementen"] = $arrangementen;
            
            $this->load->model('pension_model');
            $data['pensions'] = $this->pension_model->getAll();
            
            $partials = array('navbar' => 'main_navbar', 'content' => 'klant/boeking_maken1', 'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        } else {
            redirect("/home/index");
        }       
    }
    
    public function arrangementGekozen() {
        $data['title'] = 'Boeking maken';
        $data['author'] = 'Peeters Ellen';
        $data['user'] = $this->authex->getUserInfo();
        
        /*
         * haal de waarden uit de form op en set de userdata
         */
        /*
         * begindatum
         */
        $begindatum = $this->input->get('begindatum');
        $this->session->set_userdata('begindatum', $begindatum);
        /*
         * einddatum
         */
        $einddatum = $this->input->get('einddatum');
        $this->session->set_userdata('einddatum', $einddatum);
        /*
         * arrangementId
         */
        $arrangementId = $this->input->get('arrangement');
        $this->session->set_userdata('arrangementId', $arrangementId);
        
        if($arrangementId == 0) {
            /*
             * pensionId
             */
            $pensionId = $this->input->get('pension');
            $this->session->set_userdata('pensionId', $pensionId);
        }
        
        $this->load->model('typePersoon_model');
        $data["types"] = $this->typePersoon_model->getAll();
        
        $partials = array('navbar' => 'main_navbar', 'content' => 'klant/boeking_maken2', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data); 
    }
    
    public function nieuweKamer() {        
        $this->load->model('typePersoon_model');
        $data["persoontypes"] = $this->typePersoon_model->getAll();
        
        $this->load->model('kamer_model');
        $kamers = $this->kamer_model->getAllBeschikbaar($this->session->userdata('begindatum'), $this->session->userdata('einddatum'));
        $data["kamers"] = $kamers;

        $types = $this->kamer_model->getAllTypesByKamers();
        $data["kamertypes"] = $types;
        
        $this->load->view('klant/ajax_kamertoevoegen', $data);
    }
    
    public function voegKamerToe(){
        $typeId = $this->input->post('kamertype');
        $voorkeur = $this->input->post('voorkeur');
        
        $kamers = array();
        
        if($this->session->has_userdata('kamers')){
            $kamers = $this->session->userdata('kamers');
        } else {
            //$kamers[""];
        }
    }
}
