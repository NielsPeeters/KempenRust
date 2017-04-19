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
        $this->load->library('email');
    }

    public function index() {
        /**
        * Laadt de pagina waarop je boeking kan maken
        */
        $user = $this->authex->getUserInfo();
        
        if($user->soort==1) {
            $data['title'] = 'Boeking maken';
            $data['author'] = 'Peeters Ellen';
            $data['user'] = $user;
            
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
    
    public function arrangementGekozen()
    {
        $user = $this->authex->getUserInfo();
        
        /*
         * haal de waarden uit de form op en set de userdata
         */
        $begindatum = $this->input->get('begindatum');
        $this->session->set_userdata('begindatum', $begindatum);

        $einddatum = $this->input->get('einddatum');
        $this->session->set_userdata('einddatum', $einddatum);

        $arrangementId = $this->input->get('arrangement');
        
        if($arrangementId == 0) {
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
        $boeking = $this->maakBoeking($user, $begindatum, $einddatum, $arrangementId);
        $this->session->set_userdata('boeking', $boeking);
        
        /*
         * laad de pagina om boeking te vervolledigen
         */
        $data['title'] = 'Boeking maken';
        $data['author'] = 'Peeters Ellen';
        $data['user'] = $user;
        
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
        
        $typeId = $this->input->post('kamertype');
        $voorkeur = $this->input->post('voorkeur');
        $kamerId = 0;
        $vast = 0;
        $kamers = array();
        
        //haal alle persoontypes op en haal per persoontype het opgegeven aantal op
        $totaal = $this->haalPersoonTypes($boeking);
        
        //heeft klant een voorkeur voor een specifieke kamer aangeduid?
        if ($voorkeur == "ja") {
            /*
             * indien voorkeur, zet de kamerId = id van de gekozen kamer
             */
            $kamerId = $this->input->post('kamer');
            $vast = 1;
        } else {
            /*
             * indien geen voorkeur, genereer een random kamer van het gekozen type
             */
            $kamerId = $this->genereerKamer($typeId);
        }
        
        /*
         * lees userdata kamers indien dit bestaat
         */
        if($this->session->has_userdata('kamers')){
            $kamers = $this->session->userdata('kamers');
        }
        
        /*
         * haal kamer op adhv het gekozen/gegenereerde kamerId en voeg kamer toe aan tabel kamerBoeking
         */
        $this->load->model('kamer_model');
        $kamer = $this->kamer_model->get($kamerId);
        $kamerBoeking = $this->maakKamerBoeking($boeking, $kamer, $totaal, $vast);
        
        /*
         * update userdata kamers
         */
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
    
    public function annuleerBoeking()
    {
        if($this->session->has_userdata('boeking')){
            $boeking = $this->session->userdata('boeking');
            $this->load->model('boeking_model');
            $this->boeking_model->delete($boeking->id);
            $this->session->unset_userdata('boeking');
        }
        
        $this->unsetUserdata();
    }
    
    public function bevestigBoeking()
    {
        /*
         * vul boeking info verder aan met opmerking
         */
        $opmerking = $this->input->get('opmerking');
        $this->session->set_userdata('opmerking', $opmerking);
        
        if ($opmerking != "/")
        {
           $boeking = $this->session->userdata('boeking');
           $boeking->opmerking = $opmerking;
           $this->load->model('boeking_model');
           $this->boeking_model->update($boeking);
           $boeking = $this->boeking_model->get($boeking->id);
           $this->session->set_userdata('boeking', $boeking);
        } 
    }
    
    public function toonBevestiging()
    {
        $pensionId = 0;
        
        /*
         * lees userdata en unset daarna userdata
         */
        $begindatum = $this->session->userdata('begindatum');
        $data['begindatum'] = $begindatum;
        
        $einddatum = $this->session->userdata('einddatum');
        $data['einddatum'] = $einddatum;
        
        $kamers = $this->session->userdata('kamers');
        $data['kamers'] = $kamers;
        
        $boeking = $this->session->userdata('boeking');

        $arrangementId = $this->session->userdata('arrangementId');
        
        if($this->session->has_userdata('pensionId')){
            $arrangementId = 0;
            
            $pensionId = $this->session->userdata('pensionId');
            $this->load->model('pension_model');
            $pension = $this->pension_model->get($pensionId);
            $data['pension'] = $pension;
            
            /*
             * bereken aantal dagen dat verblijf duurt
             */
            $this->berekenAaantalDagen($begindatum, $einddatum);
        } else {
            $this->load->model('arrangement_model');
            $arrangement = $this->arrangement_model->get($arrangementId);
            $data['arrangement'] = $arrangement;
        }
        
        $this->unsetUserdata();
        
        /*
         * prijs berekenen
         */
        $totaal = $this->berekenPrijs($boeking);
        $data['prijs'] = $totaal;
        
        /*
         * stuur mail
         */
        $user = $this->authex->getUserInfo();
        $this->sendmail($user->email, $boeking, $arrangementId, $pensionId, $kamers, $totaal);
        
        /*
         * laad de pagina waar bevestiging wordt getoond
         */
        $data['title'] = 'Boeking maken';
        $data['author'] = 'Peeters Ellen';
        $data['user'] = $user;
        
        $partials = array('navbar' => 'main_navbar', 'content' => 'klant/boeking_bevestiging', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data); 
    }
    
    private function sendmail ($to, $boeking, $arrangementId, $pensionId, $kamers, $totaal)
    {
        // the message
        $bericht = "Beste\n\n";
        $bericht .= "U heeft een boeking gemaakt op " . toDDMMYYYY($boeking->tijdstip) . " voor volgende periode: " . toDDMMYYYY($boeking->startDatum) . " - " . toDDMMYYYY($boeking->eindDatum) . ".\n";
        $bericht .= "U heeft gekozen voor een ";
        $bericht .= $this->haalPensionOfArrangement($arrangementId, $pensionId);
        $bericht .= " en u heeft volgende kamers geboekt: ";
        $bericht .= $this->haalKamers($kamers);        
        $bericht .= ". U moet in totaal €" . $totaal . " betalen.\n\n";
        $bericht .= "Wanneer de boeking wordt goedgekeurd, krijgt u nog een bevestigingsmail.\n\n";
        $bericht .= "Met vriendelijke groeten\n";
        $bericht .= "Hotel Kemperust";
            
        $this->email->from('r0633567@student.thomasmore.be', 'Ellen Peeters');
        $this->email->to($to);
        $this->email->subject('Uw boeking - geboekt op ' . toDDMMYYYY($boeking->tijdstip));
        $this->email->message($bericht);
        $this->email->send();
    }
    
    function berekenPrijs($boeking)
    {
        $aantalMensen = 0;
        $index = 0;
        $totaal = 0;
        
        /*
         * haal alle kamerboekingen van de boeking op
         */
        $this->load->model('kamerBoeking_model');
        $kamerBoekingen = $this->kamerBoeking_model->getWithBoeking($boeking->id);
        
        /*
         * haal alle type personen op
         */
        $this->load->model('boekingTypePersoon_model');
        $typePersonen = $this->boekingTypePersoon_model->getByBoeking($boeking->id);
        
        foreach($typePersonen as $typePersoon) {
            /*
             * vergellijk aantal van dit type persoon met totaal in geboekte kamer
             */
            if($aantalMensen >= $kamerBoekingen[$index]->aantalMensen){ 
                $index++;
                $aantalMensen = 0;
            }
            
            /*
             * haal kamertype van de geboekte kamer
             */
            $this->load->model('kamer_model');
            $kamerBoeking = $this->kamer_model->get($kamerBoekingen[$index]->kamerId);
                     
            /*
             * haal soort prijs voor aantal van dit type persoon
             */
            $this->load->model('soortPrijs_model');
            $soortPrijs = $this->soortPrijs_model->getByAantal($typePersoon->aantal);
            
            /*
             * bereken prijs voor geboekte kamer voor dit type persoon
             */
            $this->load->model('prijs_model');
            $prijs = $this->prijs_model->getPrijs($boeking->arrangementId, $kamerBoeking->kamerTypeId, $soortPrijs->id);
            
            /*
             * totaal omhoog doen
             */
            $totaal += 1;
            
            /*
             * aantal mensen omhoog doen
             */
            $aantalMensen = $aantalMensen + $typePersoon->aantal;
        }
        
        return $totaal;
    }
    
    function berekenAaantalDagen($begindatum, $einddatum)
    {
        $date1=date_create($begindatum);
        $date2=date_create($einddatum);
        $verschil=date_diff($date1,$date2);
        $aantalDagen = (int)$verschil->format("%a");
        
        return $aantalDagen;
    }
    
    function genereerKamer($typeId)
    {
        $kamerId = 0;
        
        $this->load->model('kamer_model');
        $beschikbareKamers = $this->kamer_model->getAllBeschikbaar($this->session->userdata('begindatum'), $this->session->userdata('einddatum'));
            
        foreach($beschikbareKamers as $id => $info) {
            $kamer = $this->kamer_model->get($id);
                
            if ($kamer->kamerTypeId == $typeId) {
                $kamerId = $kamer->id;
            }
        }
        
        return $kamerId;
    }
    
    function maakBoeking($user, $begindatum, $einddatum, $arrangementId)
    {
        /**
        * Creërt een leeg boeking object en vult het op met info
        * \return boeking het ingevulde boeking object
        */
        $boeking = new stdClass();
        $boeking->persoonId = $user->id;
        $boeking->startDatum = $begindatum;
        $boeking->eindDatum = $einddatum;
        $boeking->arrangementId = $arrangementId;
        $date = date('Y-m-d H:i:s');
        $boeking->tijdstip = $date;
        $boeking->goedgekeurd = 0;
        $boeking->opmerking = NULL;
        
        $this->load->model('boeking_model');
        $boeking->id = $this->boeking_model->insert($boeking);
        
        return $boeking;
    }
    
    function maakKamerBoeking($boeking, $kamer, $totaal, $vast)
    {
        /**
        * Creërt een leeg kamerBoeking object en vult het op met info
        * \return kamerBoeking het ingevulde kamerBoeking object
        */
        $kamerBoeking = new stdClass();
        $kamerBoeking->boekingId = $boeking->id;
        $kamerBoeking->kamerId = $kamer->id;
        $kamerBoeking->aantalMensen = $totaal;
        $kamerBoeking->staatVast = $vast;
        
        $this->load->model('kamerBoeking_model');
        $kamerBoeking->id = $this->kamerBoeking_model->insert($kamerBoeking);
        
        return $kamerBoeking;
    }
    
    function haalPersoonTypes($boeking)
    {
        $totaal = 0;
        $personen = array();
        
        $this->load->model('typePersoon_model');
        $persoontypes = $this->typePersoon_model->getAll();
        
        /*
         * haal per type het opgegeven aantal op
         */
        foreach($persoontypes as $type) {
            $aantal = $this->input->post('persoon' . $type->id);
            $personen[$type->id] = $aantal;
            
            /*
             * voeg data toe aan tabel boekingtypepersoon
             */
            if($aantal != 0){
                $boekingTypePersoon = new stdClass();
                $boekingTypePersoon->typePersoonId = $type->id;
                $boekingTypePersoon->boekingId = $boeking->id;
                $boekingTypePersoon->aantal = $aantal;
                $this->load->model('boekingTypePersoon_model');
                $boekingTypePersoon->id = $this->boekingTypePersoon_model->insert($boekingTypePersoon);
            }
        }
        
        foreach($personen as $id => $aantal) {
            $totaal = $totaal + $aantal;
        }
        
        return $totaal;
    }
    
    function unsetUserdata()
    {
        if($this->session->has_userdata('begindatum')){
            $this->session->unset_userdata('begindatum');
        }
        
        if($this->session->has_userdata('einddatum')){
            $this->session->unset_userdata('einddatum');
        }
        
        if($this->session->has_userdata('arrangementId')){
            $this->session->unset_userdata('arrangementId');
        }
        
        if($this->session->has_userdata('boeking')){
            $this->session->unset_userdata('boeking');
        }

        if($this->session->has_userdata('kamers')){
            $this->session->unset_userdata('kamers');
        }
        
        if($this->session->has_userdata('pensionId')){
            $this->session->unset_userdata('pensionId');
        }
    }
    
    function haalPensionOfArrangement($arrangementId, $pensionId)
    {
        $bericht = "";
        
        if($arrangementId == 0) {
            $this->load->model('pension_model');
            $pension = $this->pension_model->get($pensionId);
            $bericht .= $pension->naam;
        } else {
            $this->load->model('arrangement_model');
            $arrangement = $this->arrangement_model->get($arrangementId);
            $bericht .= $arrangement->naam;
        }
        
        return $bericht;
    }
    
    function haalKamers($kamers)
    {
        $teller = 0;
        $bericht = "";
        
        foreach ($kamers as $id => $info) {
            $delen = explode('.', $info);
            
            if($teller == 0) {
                $bericht .= $delen[1];
            } else {
                $bericht .= ", " . $delen[1];
            }
            
            $teller++;
        }
        
        return $bericht;
    }
}
