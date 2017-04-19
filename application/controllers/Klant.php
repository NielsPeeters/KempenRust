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
        $data['user'] = $user;
        
        if($user->soort==1) {
            $this->laadPagina('klant/boeking_maken1');
        } else {
            redirect("/home/index");
        }       
    }
    
    public function arrangementGekozen() {        
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
        $boeking = $this->getEmptyBoeking($begindatum, $einddatum, $arrangementId);
        $this->session->set_userdata('boeking', $boeking);
        
        /*
         * laad de pagina om boeking te vervolledigen
         */
        $this->laadPagina('klant/boeking_maken2');
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
        /*
         * voegt kamer toe aan boeking
         */
        $totaal = 0;
        $personen = array();
        $kamerId = 0;
        $vast = 0;
        $kamers = array();
        
        $typeId = $this->input->post('kamertype');
        $voorkeur = $this->input->post('voorkeur');

        $boeking = $this->session->userdata('boeking');
        
        /*
         * haal alle persoontypes
         */
        $this->load->model('typePersoon_model');
        $persoontypes = $this->typePersoon_model->getAll();
        
        /*
         * voor elk type haal je het aantal personen op
         */
        foreach($persoontypes as $type) {
            $aantal = $this->input->post('persoon' . $type->id);
            $personen[$type->id] = $aantal;
            
            /*
             * voeg data toe aan tabel boekingtypepersoon als aantal > 0
             */
            if($aantal > 0){
                $boekingTypePersoon = $this->getEmptyBoekingTypePersoon($type->id, $boeking, $aantal);
                
                $this->load->model('boekingTypePersoon_model');
                $boekingTypePersoon->id = $this->boekingTypePersoon_model->insert($boekingTypePersoon);
            }
        }
        
        /*
         * verhoog totaal aantal personen
         */
        foreach($personen as $id => $aantal) {
            $totaal = $totaal + $aantal;
        }
        
        /*
         * heeft persoon aangeduid of dat hij/zij een voorkeur heeft voor een specifieke kamer?
         */
        if ($voorkeur == "ja") {
            /*
             * indien voorkeur, zet de kamerId gelijk aan het id van de gekozen kamer
             */
            $kamerId = $this->input->post('kamer');
            $vast = 1;
        } else {
            /*
             * indien geen voorkeur, genereer random kamer van gekozen type
             */
            $kamerId = $this->genereerRandomKamer($typeId);
        }
        
        /*
         * lees userdata kamers indien dit bestaat
         */
        if($this->session->has_userdata('kamers')){
            $kamers = $this->session->userdata('kamers');
        }
        
        /*
         * haal kamerinfo adhv het gekozen/gegenereerde kamerId
         */
        $this->load->model('kamer_model');
        $kamer = $this->kamer_model->get($kamerId);
        
        /*
         * voeg kamer toe aan tabel kamerboeking
         */
        $kamerBoeking = $this->getEmptyKamerBoeking($boeking, $kamer, $totaal, $vast);
        
        $kamers[$kamer->id] = $kamerBoeking->id . "." . $kamer->naam;
        $this->session->set_userdata('kamers', $kamers);
        
        /*
         * laad de pagina opnieuw
         */
        $this->laadPagina('klant/boeking_maken2'); 
    }
    
    public function annuleerBoeking()
    {
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
        $aantalDagen = 1;
        $user = $this->authex->getUserInfo();
        
        /*
         * lees userdata en unset daarna userdata
         */
        $boeking = $this->session->userdata('boeking');

        $begindatum = $this->session->userdata('begindatum');
        $data['begindatum'] = $begindatum;

        $einddatum = $this->session->userdata('einddatum');
        $data['einddatum'] = $einddatum;
        
        $kamers = $this->session->userdata('kamers');
        $data['kamers'] = $kamers;
        
        $arrangementId = $this->session->userdata('arrangementId');
        
        if($this->session->has_userdata('pensionId'))
        {       
            $arrangementId = 0;
            $pensionId = $this->session->userdata('pensionId');
            $this->load->model('pension_model');
            $pension = $this->pension_model->get($pensionId);
            $data['pension'] = $pension;
            
            /*
             * bereken aantal dagen dat verblijf duurt
             */
            $verschil = date_diff($begindatum, $einddatum);
            $aantalDagen = (int)$verschil->format("%a");
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
        $this->sendmail($user->email, $boeking, $arrangementId, $pensionId, $kamers, $totaal);
        
        /*
         * laad de pagina waar bevestiging wordt getoond
         */
        $this->laadPagina('klant/boeking_bevestiging');
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
        $bericht .= "Gelieve een voorschot van €20 te storten op rekeningnummer BE230 026 631 772.\n\n";
        $bericht .= "Met vriendelijke groeten\n";
        $bericht .= "Hotel Kemperust";
            
        $this->email->from('r0633567@student.thomasmore.be', 'Ellen Peeters');
        $this->email->to($to);
        $this->email->subject('Uw boeking - geboekt op ' . toDDMMYYYY($boeking->tijdstip));
        $this->email->message($bericht);
        $this->email->send();
    }
    
    function getEmptyBoeking($begindatum, $einddatum, $arrangementId)
    {
        /**
        * Creërt een leeg boeking object
        * \return boeking een leeg boeking object
        */
        $boeking = new stdClass();
        $user = $this->authex->getUserInfo();
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
    
    function getEmptyBoekingTypePersoon($persoonId, $boeking, $aantal)
    {
        /**
        * Creërt een leeg boekingtypepersoon object
        * \return boekingtypepersoon een leeg boekingtypepersoon object
        */
        $boekingTypePersoon = new stdClass();
        $boekingTypePersoon->typePersoonId = $persoonId;
        $boekingTypePersoon->boekingId = $boeking->id;
        $boekingTypePersoon->aantal = $aantal;
    }
    
    function getEmptyKamerBoeking($boeking, $kamer, $totaal, $vast)
    {
        /**
        * Creërt een leeg kamerBoeking object
        * \return kamerBoeking een leeg kamerBoeking object
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
    
    function genereerRandomKamer($typeId)
    {
        /*
         * genereert random kamer van een type
         */
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
            $boeking = $this->session->userdata('boeking');
            $this->load->model('boeking_model');
            $this->boeking_model->delete($boeking->id);
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
        $pensionOfArrangement = "";
        
        if($arrangementId == 0) {
            $this->load->model('pension_model');
            $pension = $this->pension_model->get($pensionId);
            $pensionOfArrangement = $pension->naam;
        } else {
            $this->load->model('arrangement_model');
            $arrangement = $this->arrangement_model->get($arrangementId);
            $pensionOfArrangement = $arrangement->naam;
        }
        
        return $pensionOfArrangement;
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
    
    function berekenPrijs($boeking)
    {
        $aantalMensen = 0;
        $index = 0;
        $totaal = 0;
        
        $this->load->model('kamerBoeking_model');
        $kamerBoekingen = $this->kamerBoeking_model->getWithBoeking($boeking->id);
        
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
            $this->load->model('kamerType_model');
            $kamerType = $this->kamerType_model->get($kamerBoeking->kamerTypeId);
            
            /*
             * haal soort prijs voor aantal van dit type persoon
             */
            $this->load->model('soortPrijs_model');
            $soortPrijs = $this->soortPrijs_model->getByAantal($typePersoon->aantal); /* aangemaakt */
            
            /*
             * bereken prijs voor geboekte kamer voor dit type persoon
             */
            $this->load->model('prijs_model');
            $prijsInfo = $this->prijs_model->getPrijs($boeking->arrangementId, $kamerType->id,$soortPrijs->id); /* aangemaakt */  
            $prijs = ((float)$prijsInfo->actuelePrijs);
            
            /*
             * totaal omhoog doen
             */
            $totaal = $totaal + (float)$prijs;
            
            /*
             * aantal mensen omhoog doen
             */
            $aantalMensen = $aantalMensen + $typePersoon->aantal;
        }
        
        return $totaal;
    }
    
    function laadPagina($pagina)
    {
        $data['title'] = 'Boeking maken';
        $data['author'] = 'Peeters Ellen';
        $user = $this->authex->getUserInfo();
        $data['user'] = $user;
        
        $this->load->model('arrangement_model');
        $arrangementen = $this->arrangement_model->getAllArrangementen();
        $data["arrangementen"] = $arrangementen;
            
        $this->load->model('pension_model');
        $data['pensions'] = $this->pension_model->getAll();
        
        $this->load->model('typePersoon_model');
        $data["types"] = $this->typePersoon_model->getAll();
        
        $partials = array('navbar' => 'main_navbar', 'content' => $pagina, 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data); 
    }
}
