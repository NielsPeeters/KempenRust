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
        $this->load->library('email');
    }

    public function index() {
        /**
        * Laadt de pagina waarop je boekingen kan beheren
        * geeft een array van boeking objecten mee
        */
    
        $data['title'] = 'Boekingen beheren';
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

    public function berekenPrijs(){
          /**
        * Berekend de prijs van een boeking zonder kortingen
        */
        $totaal=0;
        $prijs=0;
        $this->load->model('prijs_model');
        $this->load->model('boeking_model');
        $this->load->model('kamer_model');
        $this->load->model('kamerBoeking_model');
        $this->load->model('typePersoon_model');
        
        $boekingId = $this->session->userdata('boekingId');
        $kamerBoekingen = $this->kamerBoeking_model->getWithBoeking($boekingId);
        $boeking = $this->boeking_model->get($boekingId);
        
        foreach($kamerBoekingen as $kamerBoeking){
            $aantal = $kamerBoeking->aantalMensen;
            $kamer = $this->kamer_model->get($kamerBoeking->kamerId);
            if($aantal>1){
                 $prijs = $this->prijs_model->getPrijsTotaal($boeking->arrangementId, $kamer->kamerTypeId, $aantal);
                 $prijs = $prijs->actuelePrijs * $aantal;
            }else{
                $prijs = $this->prijs_model->getPrijsTotaal($boeking->arrangementId, $kamer->kamerTypeId, $aantal);
                $prijs = $prijs->actuelePrijs;
            }
               $totaal += (float) $prijs;
        }
        
          $this->load->model('arrangement_model');
          $arrangement = $this->arrangement_model->get($boeking->arrangementId);
          
          if($arrangement->isArrangement == 0){
           
              $dagen = strtotime($boeking->eindDatum) - strtotime($boeking->startDatum);
              $dagen = floor($dagen / (60 * 60 * 24));
              //echo $dagen + "dagen";
              //echo $totaal + "totaal";
              $totaal = (float)$totaal*$dagen;
          }

        echo $totaal;
        
    }

    public function checkAantallen(){
        /*
        * Gaat na of het aantal opgegeven personen per kamer in de kamers past.
        */
            $boekingId = $this->session->userdata('boekingId');
            $this->load->model('boekingTypePersoon_model');
            $boekingTypePersonen = $this->boekingTypePersoon_model->getByBoeking($boekingId);
            $totaalPersonen = 0;
            $personen = 0;
            foreach($boekingTypePersonen as $boekingTypePersoon){
                $totaalPersonen += (int) $boekingTypePersoon->aantal;
            }
            $this->load->model('kamerBoeking_model');
            $kamerBoekingen = $this->kamerBoeking_model->getWithBoeking($boekingId);
            foreach($kamerBoekingen as $kamerBoeking){
                    $personen += (int) $kamerBoeking->aantalMensen;
            }
         
            if($totaalPersonen != $personen){
                echo 0;
            }
            else{
                redirect("boeking/index");
            }
            
    }

    public function haalboeking() {
        /**
        * Haalt een boeking object op
        */
        $boekingId = $this->input->get('boekingId');
        if($boekingId==0){
            $this->newBoeking();
            $this->session->set_userdata('boekingId', '0');
        }
        else{
            $this->load->model('boeking_model');
            $data['boeking']= $this->boeking_model->getBoekingWithAll($boekingId);
            $this->load->model('boekingTypePersoon_model');
            $data['boekingTypePersonen'] = $this->boekingTypePersoon_model->getByBoeking($boekingId);
            $this->load->model('arrangement_model');
            $data['arrangementen'] = $this->arrangement_model->getArrangementen(1);
            $data['pensions'] = $this->arrangement_model->getArrangementen(0);
            $this->load->model('typePersoon_model');
            $data['typePersonen'] = $this->typePersoon_model->getAll();
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
        
        $boeking = $this->getEmptyBoeking();

        $this->load->model('kamerType_model');
        $data['kamerTypes'] = $this->kamerType_model->getAll();

        $this->load->model('arrangement_model');
        $data['arrangementen'] = $this->arrangement_model->getArrangementen(1);
        $data['pensions'] = $this->arrangement_model->getArrangementen(0);

        $this->load->model('boekingTypePersoon_model');
        $data['boekingTypePersonen'] = $this->boekingTypePersoon_model->getByBoeking($boeking->id);

        $this->load->model('typePersoon_model');
        $data['typePersonen'] = $this->typePersoon_model->getAll();

        $this->load->model('persoon_model');
        $data['personen'] = $this->persoon_model->getAll();

        $data['boeking']=$boeking;

        $this->load->view("werknemer/boeking/ajax_boeking", $data);
    }


    public function getEmptyBoeking(){
        /*
        *Genereerd een leeg boeking object
        *\return een leeg boeking object
        */
        $boeking = new stdClass();
        $this->session->set_userdata('boekingId', '0');
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
        $this->load->model('arrangement_model');
        $arrangement = $this->arrangement_model->getByOmschrijving($this->input->post('arrangement'));

        if($arrangement->isArrangement == 0 ){
            $arrangement = $this->input->post('pension');
        }else{
            $arrangement = $arrangement->id;
        }
        $boeking = new stdClass();
        $boeking->id = $this->input->post('id');
        $boeking->goedgekeurd = $this->input->post('goedgekeurd');
        $persoonId = $this->input->post('persoonId');
        $boeking->startDatum = $this->input->post('startDatum');
        $boeking->eindDatum = $this->input->post('eindDatum');
        $boeking->arrangementId = $arrangement;
        $boeking->tijdstip = date('Y-m-d H:i:s',$_SERVER['REQUEST_TIME']);
        $boeking->opmerking = $this->input->post('opmerking');
        $this->load->model('boeking_model');
        $this->session->set_userdata('einddatum', $boeking->eindDatum);
        $this->session->set_userdata('startdatum', $boeking->startDatum);
       
        $this->load->model('typePersoon_model');
        $persoontypes = $this->typePersoon_model->getAll();
        
        $new = 0;

        if ($boeking->id == 0 && $this->session->userdata("boekingId")==0) {
            $namen = explode(" ", $persoonId);
            $boeking->goedgekeurd = 0;
            
            $this->load->model('persoon_model');
            $persoonId = $this->persoon_model->getWithNaam($namen[0],$namen[1]);
            
            $boeking->persoonId = $persoonId->id;
            $boeking->id = $this->boeking_model->insert($boeking);
            $this->session->set_userdata('boekingId', $boeking->id);
            
        } else {
            $new=1;
            $boeking->persoonId=$persoonId;
            $this->boeking_model->update($boeking);
            if($boeking->id != 0){
                 $this->session->set_userdata('boekingId', $boeking->id);
            }
        }

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
        $data['boeking']=$boeking;
        //echo $data;

    }

    public function nieuweKamer() { 
        /*
        * Haalt alle kamers op die beschikbaar zijn op de datums van de boeking
        *\return een verzameling kamer objecten
        */
        $this->load->model('kamer_model');
        $data["kamers"]  = $this->kamer_model->getAllBeschikbaarWithType($this->session->userdata('startdatum'), $this->session->userdata('einddatum'));

        $this->load->view('werknemer/boeking/ajax_kamertoevoegen', $data);
    }

    public function gekozenKamers(){
        /*
        *Haalt alle kamers op die bij de boeking horen
        *\return een verzameling kamer objecten
        */
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
        $this->kamerBoeking_model->insert($kamerBoeking);
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
             $this->sendmail($id);
        }
        else{
            $boeking->goedgekeurd=0;
        }
        $this->boeking_model->update($boeking);
        redirect("boeking/index");
    }

private function sendmail($id) {
    /*
    *verzend een email naar het email adres van de klant
    *\param id het id van de betrokken boeking
    */
       
        $this->load->model('boeking_model');
        $boeking = $this->boeking_model->getBoekingWithAll($id);
        $this->email->from('r0589993@student.thomasmore.be', 'Hotel Kempenrust');
        $this->email->to($boeking->persoon->email);
        $this->session->set_userdata('boekingId',$boeking->id);
        $this->email->subject('Boeking goedgekeurd');
        $bericht = "Beste\n\n";
        $bericht .= "Uw boeking werd goedgekeurd. \n";
        $bericht .= toDDMMYYYY($boeking->startDatum) . " - " . toDDMMYYYY($boeking->eindDatum) . "\n";
        $bericht .= "U koos voor de volgende formule: " . $boeking->arrangement . ",\n"; 
        $bericht .= "en onderstaande kamers:";
        $bericht .= "";
        $bericht .= "Gelieve een voorschot van €20 te storten op rekeningnummer BE230 026 631 772.\n\n";
        $bericht .= "Met vriendelijke groeten\n";
        $bericht .= "Hotel Kempenrust";

        $this->email->message($bericht);
        $this->email->send();
        $this->session->set_userdata('boekingId',0);
    }
    


  public function dashboard() {
        /**
         * Laadt de pagina waarop je kamertypes kan beheren
         * geeft een array van kamertype objecten mee
         */
        $data['title'] = 'Dashboard';
        $data['author'] = 'Van de Voorde Tim';
        $data['user'] = $this->authex->getUserInfo();
        
        if($user->soort>=2) {
        $this->load->model('boeking_model');
        $data['boekingen'] = $this->boeking_model->getBoekingenWith();
        } else
        {
             redirect("/home/index");
        }
        
        $partials = array('navbar' => 'main_navbar', 'content' => 'werknemer/dashboard/dashboard', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }








}
