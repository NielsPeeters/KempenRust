<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Boeking extends CI_Controller {

    public function __construct() {
         /**
        * standaard controller constructor
        * laadt helpers
        */
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('notation');
        $this->load->library('pagination');
    }

    public function index() {
        /**
        * Laadt de pagina waarop je boekingen kan beheren
        * geeft een array van boeking objecten mee
        */
    
        $data['title'] = 'boekingen beheren';
        $data['author'] = 'Laenen Nathalie';
        $data['user'] = $this->authex->getUserInfo();

        $this->load->model('boeking_model');
        $this->load->model('arrangement_model');
        $data['arrangementen']=$this->arrangement_model->getAll();
        $user = $this->authex->getUserInfo();
        if($user->soort>1) {
            $this->load->model('boeking_model');
            $data['boekingen'] = $this->boeking_model->getBoekingenWith();

            $partials = array('navbar' => 'main_navbar', 'content' => 'werknemer/boeking/boeking_zoeken', 'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        } else {
            redirect("/home/index");
        }       
    }



    public function haalboeking() {
        /**
        * Haalt een boeking object op
        */
        $boekingId = $this->input->get('boekingId');
        if($boekingId==0){
            $this->newBoeking();
        }
        else{
            $this->load->model('boeking_model');
            $data['boeking']= $this->boeking_model->getBoekingWithAll($boekingId);
            $this->load->model('boekingTypePersoon_model');
            $data['boekingTypePersonen'] = $this->boekingTypePersoon_model->getByBoeking($boekingId);
            $this->load->model('arrangement_model');
            $data['arrangementen'] = $this->arrangement_model->getAll();
            $this->load->model('typePersoon_model');
            $data['typePersonen'] = $this->typePersoon_model->getAll();
            $this->load->model('pension_model');
            $data['pensions'] = $this->pension_model->getAll();
            $this->load->model('kamerBoeking_model');
            $data['kamerBoekingen'] = $this->kamerBoeking_model->getWithBoeking($boekingId);
            $this->load->model('kamer_model');
            $data['kamers'] = $this->kamer_model->getAllWithKamerType();
            

            $this->load->view("werknemer/boeking/ajax_boeking", $data);
          
            }
    }

    public function verwijderBoeking(){
        /**
        * Verwijderdt een boeking object
        */
        $id = $this->input->get('id');
        $this->load->model('boeking_model');
        $this->boeking_model->delete($id);

        echo 0;
        
    }

    public function verwijderKamer(){
        /**
        * Verwijderdt een kamerboeking object
        */
        $id = $this->input->get('id');
        $this->load->model('kamerBoeking_model');
        $this->kamerBoeking_model->delete($id);

        echo 0;
        
    }

    function newBoeking() {
        /**
        * Creërt een leeg boeking object
        * \return boeking een leeg boeking object
        */
        
        $data['boeking']=$this->getEmptyBoeking();

        $this->load->model('kamerType_model');
        $data['kamerTypes'] = $this->kamerType_model->getAll();

        $this->load->model('arrangement_model');
        $data['arrangementen'] = $this->arrangement_model->getAll();

        $this->load->model('typePersoon_model');
        $data['typePersonen'] = $this->typePersoon_model->getAll();
      
        $this->load->model('pension_model');
        $data['pensions'] = $this->pension_model->getAll();

        $this->load->model('persoon_model');
         $data['personen'] = $this->persoon_model->getAll();

        $this->load->view("werknemer/boeking/ajax_boeking", $data);
    }

    public function getEmptyBoekingTypePersoon($id){
        $boekingTypePersoon = new stdClass();

        $boekingTypePersoon->typePersoonId = $id ;
        $boekingTypePersoon->aantal = '0';
        $boekingTypePersoon->boekingId ='0';
        $boekingTypePersoon->id = '0';

        return $boekingTypePersoon;
    }

    public function getEmptyBoeking(){
        $boeking = new stdClass();

        $boeking->id = '0';
        $boeking->persoonId='0';
        $boeking->naam = '';
        $boeking->arrangementId='0';
        $boeking->opmerking='';
        $boeking->startDatum='';
        $boeking->eindDatum='';
        $boeking->tijdstip='';
        $boeking->goedgekeurd='0';

        return $boeking;
    }

    public function schrijfBoeking(){
        /**
        * Haalt de waarden van het boeking object op en update of insert deze in de database
        */
        $this->load->model('arrangement_model');
        $arrangement = $this->arrangement_model->getByOmschrijving($this->input->post('arrangement'));

        $boeking = new stdClass();
        $boeking->id = $this->input->post('id');
        $boeking->goedgekeurd = $this->input->post('goedgekeurd');
        $persoonId = $this->input->post('persoonId');
        $boeking->startDatum = $this->input->post('startDatum');
        $boeking->eindDatum = $this->input->post('eindDatum');
        $boeking->arrangementId = $arrangement->id;
        $boeking->tijdstip = date('Y-m-d H:i:s',$_SERVER['REQUEST_TIME']);
        $boeking->opmerking = $this->input->post('opmerking');
        $this->load->model('boeking_model');
        $this->session->set_userdata('einddatum', $boeking->eindDatum);
        $this->session->set_userdata('begindatum', $boeking->beginDatum);

        $this->load->model('typePersoon_model');
        $persoontypes = $this->typePersoon_model->getAll();
        
        $new = 0;
            
        if ($boeking->id == 0) {
            $namen = explode(" ", $persoonId);
           

            $this->load->model('persoon_model');
            $persoonId = $this->persoon_model->getWithNaam($namen[0],$namen[1]);
            $boeking->persoonId = $persoonId->id;
            
            

            $boeking->id=$this->boeking_model->insert($boeking);
        } else {
            $new=1;
            $boeking->persoonId=$persoonId;
            $this->boeking_model->update($boeking);
        }

        $this->session->set_userdata('boekingId', $boeking->id);

         foreach($persoontypes as $type) {
            $persoonId = $type->id;
            $aantal = $this->input->post('persoon' . $persoonId);
            $personen[$persoonId] = $aantal;

            /*
             * voeg data toe aan tabel boekingtypepersoon
             */
            
            $boekingTypePersoon = new stdClass();
            $boekingTypePersoon->typePersoonId = $persoonId;
            $boekingTypePersoon->boekingId = $boeking->id;
            $boekingTypePersoon->aantal = $aantal;
            $this->load->model('boekingTypePersoon_model');
            if($new==0){
                $this->boekingTypePersoon_model->insert($boekingTypePersoon);
            }
            else{
                $this->boekingTypePersoon_model->update($boekingTypePersoon);
            }
            
            
        }

        $this->load->model('arrangement_model');
        $data['arrangementen']=$this->arrangement_model->getAll();
        echo $arrangementen;

    }

    public function nieuweKamer() { 
        
        $this->load->model('kamer_model');
        $data["kamers"]  = $this->kamer_model->getAllBeschikbaarWithType($this->session->userdata('begindatum'), $this->session->userdata('einddatum'));

        $this->load->view('werknemer/boeking/ajax_kamertoevoegen', $data);
    }

    public function gekozenKamers(){
        //$boekingId = 
        
        $this->load->model('kamerBoeking_model');
        $kamers = $this->kamerBoeking_model->getWithBoeking($this->session->userdata('boekingId'));
        $data["kamerBoekingen"] = $kamers;
        $this->load->model('kamer_model');
        $data["kamers"] = $this->kamer_model->getAllWithKamerType();
        $this->load->view("werknemer/boeking/ajax_kamers", $data);
        
    }
    
    public function voegKamerToe(){
        /*
         * voeg kamer toe aan tabel kamerboeking
         */
        $kamerBoeking = new stdClass();
        $kamerBoeking->boekingId = $this->session->userdata('boekingId');
        $kamerBoeking->kamerId = $this->input->post('kamer');
        $kamerBoeking->aantalMensen = $this->input->post('aantal');
        $kamerBoeking->staatVast = $this->input->post('voorkeur');
        $this->load->model('kamerBoeking_model');
        $kamerBoeking->id = $this->kamerBoeking_model->insert($kamerBoeking);
        echo 0;
    }
    

     public function setGoedkeuring(){
        /**
        * veranderd de waarde van goedgekeurd van de boeking
        */
        
        $id = $this->input->get('id');
        $this->load->model('boeking_model');
        $boeking = $this->boeking_model->get($id);
        if($boeking->goedgekeurd==0){
             $boeking->goedgekeurd=1;
        }
        else{
            $boeking->goedgekeurd=0;
        }
        $this->boeking_model->update($boeking);
       
        redirect("boeking/index");
    }

    








}
