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
        $user = $this->authex->getUserInfo();
        $data['user'] = $user;
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
        $user = $this->authex->getUserInfo();
        $data['user'] = $user;
        
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
        
        if($arrangementId == 0) {
            /*
             * pensionId
             */
            $pensionId = $this->input->get('pension');
            $this->session->set_userdata('pensionId', $pensionId);
            
            /*
             * haal arrangement aan de hand van het pensionId in de tabel arrangement
             */
            $this->load->model('arrangement_model');
            $arrangement = $this->arrangement_model->getAllByPension($pensionId);
            $arrangementId = $arrangement->id;
        }
        
        $this->session->set_userdata('arrangementId', $arrangementId);
        
        /*
         * maak boeking aan
         */
        $boeking = new stdClass();
        $boeking->persoonId = $user->id;
        $boeking->startDatum = $begindatum;
        $boeking->eindDatum = $einddatum;
        $boeking->arrangementId = $arrangementId;
        $date = date('Y-m-d H:i:s');
        $boeking->tijdstip = $date;;
        $boeking->goedgekeurd = 0;
        $boeking->opmerking = "NULL";
        $this->load->model('boeking_model');
        $boeking->id = $this->boeking_model->insert($boeking);
        $this->session->set_userdata('boeking', $boeking);
        
        /*
         * laad de pagina om boeking te vervolledigen
         */
        $this->load->model('typePersoon_model');
        $data["types"] = $this->typePersoon_model->getAll();
        
        $partials = array('navbar' => 'main_navbar', 'content' => 'klant/boeking_maken2', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data); 
    }
    
    public function nieuweKamer() { 
        $this->load->model('typePersoon_model');
        $data['persoontypes'] = $this->typePersoon_model->getAll();
        
        $this->load->model('kamer_model');
        $kamers = $this->kamer_model->getAllBeschikbaar($this->session->userdata('begindatum'), $this->session->userdata('einddatum'));
        $data["kamers"] = $kamers;

        $types = $this->kamer_model->getAllTypesByKamers();
        $data["kamertypes"] = $types;
        
        $this->load->view('klant/ajax_kamertoevoegen', $data);
    }
    
    public function voegKamerToe(){
        $boeking = $this->session->userdata('boeking');
        $totaal = 0;
        $personen = array();
        
        $this->load->model('typePersoon_model');
        $persoontypes = $this->typePersoon_model->getAll();
        
        foreach($persoontypes as $type) {
            $persoonId = $type->id;
            $aantal = $this->input->post('persoon' . $persoonId);
            $personen[$persoonId] = $aantal;
            
            /*
             * voeg data toe aan tabel boekingtypepersoon
             */
            if($aantal != 0){
                $boekingTypePersoon = new stdClass();
                $boekingTypePersoon->typePersoonId = $persoonId;
                $boekingTypePersoon->boekingId = $boeking->id;
                $boekingTypePersoon->aantal = $aantal;
                $this->load->model('boekingTypePersoon_model');
                $boekingTypePersoon->id = $this->boekingTypePersoon_model->insert($boekingTypePersoon);
            }
        }
        
        foreach($personen as $id => $aantal) {
            $totaal = $totaal + $aantal;
        }
        
        $typeId = $this->input->post('kamertype');
        $voorkeur = $this->input->post('voorkeur');
        $kamerId = 0;
        $vast = 0;
        
        if ($voorkeur == "ja") {
            $kamerId = $this->input->post('kamer');
            $vast = 1;
        } else {
            $aantal = 0;
            $this->load->model('kamer_model');
            $beschikbareKamers = $this->kamer_model->getAllBeschikbaar($this->session->userdata('begindatum'), $this->session->userdata('einddatum'));
            
            foreach($beschikbareKamers as $id => $info) {
                $kamer = $this->kamer_model->get($id);
                
                if ($kamer->kamerTypeId == $typeId) {
                    $aantal++;
                }
            }
            
            $kamerId = rand(0, $aantal - 1);
        }
        
        $kamers = array();
        
        if($this->session->has_userdata('kamers')){
            $kamers = $this->session->userdata('kamers');
        }
        
        $this->load->model('kamer_model');
        $kamer = $this->kamer_model->get($kamerId);
        
        /*
         * voeg kamer toe aan tabel kamerboeking
         */
        $kamerBoeking = new stdClass();
        $kamerBoeking->boekingId = $boeking->id;
        $kamerBoeking->kamerId = $kamer->id;
        $kamerBoeking->aantalMensen = $totaal;
        $kamerBoeking->staatVast = $vast;
        $this->load->model('kamerBoeking_model');
        $kamerBoeking->id = $this->kamerBoeking_model->insert($kamerBoeking);
        
        $kamers[$kamer->id] = $kamerBoeking->id . "." . $kamer->naam;
        $this->session->set_userdata('kamers', $kamers);
        
        /*
         * laad de pagina opnieuw
         */
        $data['title'] = 'Boeking maken';
        $data['author'] = 'Peeters Ellen';
        $user = $this->authex->getUserInfo();
        $data['user'] = $user;

        $this->load->model('typePersoon_model');
        $data["types"] = $this->typePersoon_model->getAll();
        $data["gekozenKamers"] = $kamers;
        
        $partials = array('navbar' => 'main_navbar', 'content' => 'klant/boeking_maken2', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data); 
    }
}
