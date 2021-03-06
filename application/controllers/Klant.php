<?php

class Klant extends CI_Controller {

    /**
     * Klant controller
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

    public function help() {
        /**
         * Laadt de help-pagina
         */
        $user = $this->authex->getUserInfo();

        if ($user->soort == 1) {
            $data['title'] = 'Help';
            $data['author'] = 'Peeters Ellen';
            $data['user'] = $user;

            $partials = array('navbar' => 'main_navbar', 'content' => 'klant/help/help', 'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        } else {
            redirect("/home/index");
        }
    }

    public function index() {
        /**
         * Laadt de pagina waarop je boeking kan maken
         */
        $user = $this->authex->getUserInfo();

        if ($user->soort == 1) {
            $data['title'] = 'Boeking maken';
            $data['author'] = 'Peeters Ellen';
            $data['user'] = $user;

            $this->load->model('arrangement_model');
            $data["arrangementen"] = $this->arrangement_model->getAllArrangementen();
            $data['pensions'] = $this->arrangement_model->getAllPensions();

            $partials = array('navbar' => 'main_navbar', 'content' => 'klant/boeking/boeking_maken1', 'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        } else {
            redirect("/home/index");
        }
    }

    public function beheren() {
        /**
         * Laadt de pagina waarop je boekingen kan beheren
         */
        $user = $this->authex->getUserInfo();

        if ($user->soort == 1) {
            $boekingen = array();

            $this->load->model('boeking_model');
            $boekingenPerPersoon = $this->boeking_model->getAllByPersoonOrderByStartDatum($user->id);

            foreach ($boekingenPerPersoon as $boeking) {
                $this->load->model('arrangement_model');
                $boeking->arrangement = $this->arrangement_model->get($boeking->arrangementId);
                $boekingen[$boeking->id] = $boeking;
            }

            $data['title'] = 'Boekingen beheren';
            $data['author'] = 'Peeters Ellen';
            $data['user'] = $user;
            $data["boekingen"] = $boekingen;

            $partials = array('navbar' => 'main_navbar', 'content' => 'klant/boeking/boeking_zoeken', 'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        } else {
            redirect("/home/index");
        }
    }

    public function haalJSONArrangement() {
        /**
         * haalt de info van het gekozen arrangement
         */
        $arrangementId = $this->input->get("arrangementId");
        $this->load->model('arrangement_model');
        $arrangement = $this->arrangement_model->get($arrangementId);
        echo json_encode($arrangement);
    }

    public function haalBoeking() {
        /**
         * Haalt een boeking object op
         */
        $totaalPersonen = 0;
        $kamers = array();

        $boekingId = $this->input->get('boekingId');

        $this->load->model('boeking_model');
        $boeking = $this->boeking_model->get($boekingId);
        $this->load->model('arrangement_model');
        $boeking->arrangement = $this->arrangement_model->get($boeking->arrangementId);
        $this->load->model('kamerBoeking_model');
        $kamerBoekingen = $this->kamerBoeking_model->getAllByBoeking($boeking->id);

        foreach ($kamerBoekingen as $kamerBoeking) {
            $this->load->model('kamer_model');
            $kamer = $this->kamer_model->get($kamerBoeking->kamerId);
            $this->load->model('kamerType_model');
            $kamer->kamerType = $this->kamerType_model->get($kamer->kamerTypeId);
            $kamers[$kamer->id] = $kamer;
        }

        $this->load->model('boekingTypePersoon_model');
        $boekingTypePersonen = $this->boekingTypePersoon_model->getByBoeking($boeking->id);

        foreach ($boekingTypePersonen as $boekingTypePersoon) {
            $totaalPersonen += (int) $boekingTypePersoon->aantal;
        }

        $boeking->aantalPersonen = $totaalPersonen;

        $data["boeking"] = $boeking;
        $data["kamers"] = $kamers;

        $this->load->view("klant/boeking/ajax_boeking", $data);
    }

    public function verwijderBoeking() {
        /**
         * Verwijdert een boeking object
         */
        $id = $this->input->get('id');
        $this->load->model('boeking_model');
        $boeking = $this->boeking_model->get($id);

        if ($boeking->goedgekeurd == 0) {
            $this->boeking_model->delete($id);
            echo 0;
        } else {
            echo -1;
        }
    }

    public function arrangementGekozen() {
        /**
         * laadt de pagina waar je de boeking kan vervolledigen wanneer je een begin-, einddatum en pension of arrangement hebt gekozen
         */
        /*
         * haal de waarden uit de form op en set de userdata
         */
        $begindatum = $this->input->get('begindatum');
        $this->session->set_userdata('begindatum', $begindatum);

        $einddatum = $this->input->get('einddatum');
        $this->session->set_userdata('einddatum', $einddatum);

        $arrangementId = $this->input->get('arrangement');

        if ($arrangementId == 0) {
            $pensionId = $this->input->get('pension');
            $this->session->set_userdata('pensionId', $pensionId);

            /**
             * haal arrangement aan de hand van het pensionId in de tabel arrangement
             */
            $this->load->model('arrangement_model');
            $arrangement = $this->arrangement_model->get($pensionId);
            $arrangementId = $arrangement->id;
        }

        $this->session->set_userdata('arrangementId', $arrangementId);

        /**
         * maak boeking aan
         */
        $boeking = $this->getEmptyBoeking($begindatum, $einddatum, $arrangementId);
        $this->session->set_userdata('boeking', $boeking);

        /**
         * laad de pagina om boeking te vervolledigen
         */
        $data['title'] = 'Boeking maken';
        $data['author'] = 'Peeters Ellen';
        $user = $this->authex->getUserInfo();
        $data['user'] = $user;

        $partials = array('navbar' => 'main_navbar', 'content' => 'klant/boeking/boeking_maken2', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function nieuweKamer() {
        /**
         * haalt de pagina op waar je een nieuwe kamer aan je boeking kunt toevoegen
         */
        $this->load->model('typePersoon_model');
        $data['persoontypes'] = $this->typePersoon_model->getAll();

        $this->load->model('kamer_model');
        $kamers = $this->kamer_model->getAllBeschikbaar($this->session->userdata('begindatum'), $this->session->userdata('einddatum'));
        $data["kamers"] = $kamers;

        $types = $this->kamer_model->getAllTypesByKamers();
        $data["kamertypes"] = $types;

        $this->load->view('klant/boeking/ajax_kamertoevoegen', $data);
    }

    public function voegKamerToe() {
        /**
         * voegt de kamer toe aan de boeking en laadt de pagina opnieuw
         */
        $boeking = $this->session->userdata('boeking');

        $typeId = $this->input->post('kamertype');
        $voorkeur = $this->input->post('voorkeur');
        $kamerId = 0;
        $vast = 0;
        $kamers = array();

        ///haal alle persoontypes op en haal per persoontype het opgegeven aantal op
        $totaal = $this->haalPersoonTypes($boeking);

        ///heeft klant een voorkeur voor een specifieke kamer aangeduid?
        if ($voorkeur == "ja") {
            /**
             * indien voorkeur, zet de kamerId = id van de gekozen kamer
             */
            $kamerId = $this->input->post('kamer');
            $vast = 1;
        } else {
            /**
             * indien geen voorkeur, genereer een random kamer van het gekozen type
             */
            $kamerId = $this->genereerKamer($typeId);
        }

        /**
         * lees userdata kamers indien dit bestaat
         */
        if ($this->session->has_userdata('kamers')) {
            $kamers = $this->session->userdata('kamers');
        }

        /**
         * haal kamer op adhv het gekozen/gegenereerde kamerId en voeg kamer toe aan tabel kamerBoeking
         */
        $this->load->model('kamer_model');
        $kamer = $this->kamer_model->get($kamerId);
        $this->load->model('kamerType_model');
        $kamer->kamerType = $this->kamerType_model->get($kamer->kamerTypeId);
        $kamerBoeking = $this->maakKamerBoeking($boeking, $kamer, $totaal, $vast);

        /**
         * update userdata kamers
         */
        $kamers[$kamer->id] = $kamerBoeking->id . "." . $kamer->naam . "." . $kamer->kamerType->omschrijving;
        $this->session->set_userdata('kamers', $kamers);

        /*
         * laad de pagina opnieuw
         */
        $data['title'] = 'Boeking maken';
        $data['author'] = 'Peeters Ellen';
        $user = $this->authex->getUserInfo();
        $data['user'] = $user;
        $data['gekozenKamers'] = $kamers;

        $partials = array('navbar' => 'main_navbar', 'content' => 'klant/boeking/boeking_maken2', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function annuleerBoeking() {
        /**
         * annuleer de boeking
         */
        if ($this->session->has_userdata('boeking')) {
            $boeking = $this->session->userdata('boeking');
            $this->load->model('boeking_model');
            $this->boeking_model->delete($boeking->id);
            $this->session->unset_userdata('boeking');
        }

        $this->unsetUserdata();
    }

    public function bevestigBoeking() {
        /**
         * vul boeking info verder aan met opmerking
         */
        $opmerking = $this->input->get('opmerking');
        $this->session->set_userdata('opmerking', $opmerking);

        if ($opmerking != "/") {
            $boeking = $this->session->userdata('boeking');
            $boeking->opmerking = $opmerking;
            $this->load->model('boeking_model');
            $this->boeking_model->update($boeking);
            $boeking = $this->boeking_model->get($boeking->id);
            $this->session->set_userdata('boeking', $boeking);
        }
    }

    public function toonBevestiging() {
        /**
         * laadt de pagina waar de bevestiging getoond wordt
         */
        $pensionId = 0;
        $aantalDagen = 1;
        $user = $this->authex->getUserInfo();

        /**
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
        $this->load->model('arrangement_model');
        $arrangement = $this->arrangement_model->get($arrangementId);

        if ($this->session->has_userdata('pensionId')) {
            $pensionId = $arrangementId;
            $arrangementId = 0;
            $data['pension'] = $arrangement;

            /**
             * bereken aantal dagen dat verblijf duurt
             */
            $aantalDagen = $this->berekenAaantalDagen($begindatum, $einddatum);
        } else {
            $data['arrangement'] = $arrangement;
        }

        $this->unsetUserdata();

        /**
         * prijs berekenen
         */
        $totaal = $this->berekenPrijs($boeking, $aantalDagen);
        $data['prijs'] = $totaal;

        /**
         * stuur mail
         */
        $this->sendmail($user->email, $boeking, $arrangementId, $pensionId, $kamers, $totaal);

        /**
         * laad de pagina waar bevestiging wordt getoond
         */
        $data['title'] = 'Boeking maken';
        $data['author'] = 'Peeters Ellen';
        $data['user'] = $user;

        $partials = array('navbar' => 'main_navbar', 'content' => 'klant/boeking/boeking_bevestiging', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    private function sendmail($to, $boeking, $arrangementId, $pensionId, $kamers, $totaal) {
        /**
         * verstuur een mail naar de klant met alle info
         * \param $to naar wie de e-mail gestuurd wordt
         * \param $boeking de geselecteerde boeking
         * \param $arrangementId het id van het gekozen arrangement
         * \param $pensionId het id van het gekozen pesnion
         * \param $kamers de userdata van de gekozen kamers
         * \param $totaal de totale prijs
         */
        $bericht = "Beste\n\n";
        $bericht .= "U heeft een boeking gemaakt op " . toDDMMYYYY($boeking->tijdstip) . " voor volgende periode: " . toDDMMYYYY($boeking->startDatum) . " - " . toDDMMYYYY($boeking->eindDatum) . ".\n";
        $bericht .= "U heeft gekozen voor een ";
        $bericht .= $this->haalPensionOfArrangement($arrangementId, $pensionId);
        $bericht .= " en u heeft volgende kamers geboekt: ";
        $bericht .= $this->haalKamers($kamers);
        $bericht .= ". U moet in totaal €" . toKomma($totaal) . " betalen.\n\n";
        $bericht .= "Gelieve te wachten met de betaling totdat de boeking is goedgekeurd. Wanneer de boeking wordt goedgekeurd, krijgt u nog een bevestigingsmail.\n\n";
        $bericht .= "Met vriendelijke groeten\n";
        $bericht .= "Hotel Kemperust";

        $this->email->from('r0633567@student.thomasmore.be', 'Hotel Kempenrust');
        $this->email->to($to);
        $this->email->subject('Uw boeking - geboekt op ' . toDDMMYYYY($boeking->tijdstip));
        $this->email->message($bericht);
        $this->email->send();
    }

    function getEmptyBoeking($begindatum, $einddatum, $arrangementId) {
        /**
         * Creërt een leeg boeking object
         * \param $begindatum de startdatum
         * \param $einddatum de einddatum
         * \param $arrangementId het id van het gekozen arrangement of pension
         * \return $boeking een leeg boeking object
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

    function getEmptyBoekingTypePersoon($persoonId, $boeking, $aantal) {
        /**
         * Creërt een leeg boekingtypepersoon object
         * \param $persoonId het id van de typePersoon
         * \param $boeking de boeking
         * \param $aantal het aantal personen
         * \return boekingtypepersoon een leeg boekingtypepersoon object
         */
        $boekingTypePersoon = new stdClass();
        $boekingTypePersoon->typePersoonId = $persoonId;
        $boekingTypePersoon->boekingId = $boeking->id;
        $boekingTypePersoon->aantal = $aantal;
    }

    function maakKamerBoeking($boeking, $kamer, $totaal, $vast) {
        /**
         * Creërt een leeg kamerBoeking object en vult het op met info
         * \param $boeking de boeking
         * \param $kamer de gekozen kamer
         * \param $totaal het totaal aantal personen in deze kamer
         * \param $vast bepaalt of dat de kamer vast staat -> voorkeur
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

    function genereerKamer($typeId) {
        /**
         * genereert een random kamer van een bepaalt type
         * \param $typeId het id van de type
         * \return de kamerId van de gegenereerde kamer
         */
        $kamerId = 0;

        $this->load->model('kamer_model');
        $beschikbareKamers = $this->kamer_model->getAllBeschikbaar($this->session->userdata('begindatum'), $this->session->userdata('einddatum'));

        foreach ($beschikbareKamers as $id => $info) {
            $kamer = $this->kamer_model->get($id);

            if ($kamer->kamerTypeId == $typeId) {
                $kamerId = $kamer->id;
            }
        }

        return $kamerId;
    }

    function haalPensionOfArrangement($arrangementId, $pensionId) {
        /**
         * haalt het gekozen arrangement of pension aan de hand van de id
         * \param $arrangementId het id van het gekozen arrangement
         * \param $pensionId het id van de gekozen pension
         */
        $pensionOfArrangement = "";

        $this->load->model('arrangement_model');

        if ($arrangementId == 0) {
            $pension = $this->arrangement_model->get($pensionId);
            $pensionOfArrangement = $pension->naam;
        } else {
            $arrangement = $this->arrangement_model->get($arrangementId);
            $pensionOfArrangement = $arrangement->naam;
        }

        return $pensionOfArrangement;
    }

    function haalKamers($kamers) {
        /**
         * haalt de kamers die bij de boeking horen
         * \param $kamers de userdata van de gekozen kamers
         */
        $teller = 0;
        $bericht = "";

        foreach ($kamers as $id => $info) {
            $delen = explode('.', $info);

            if ($teller == 0) {
                $bericht .= $delen[1] . ' (' . $delen[2] . ')';
            } else {
                $bericht .= ", " . $delen[1] . ' (' . $delen[2] . ')';
            }

            $teller++;
        }

        return $bericht;
    }

    function haalPersoonTypes($boeking) {
        /**
         * haalt alle persoontypes en berekent het totaal aantal personen
         * \param $boeking de boeking
         */
        $totaal = 0;
        $personen = array();

        $this->load->model('typePersoon_model');
        $persoontypes = $this->typePersoon_model->getAll();

        /**
         * haal per type het opgegeven aantal op
         */
        foreach ($persoontypes as $type) {
            $aantal = $this->input->post('persoon' . $type->id);
            $personen[$type->id] = $aantal;

            /**
             * voeg data toe aan tabel boekingtypepersoon
             */
            if ($aantal != 0) {
                $boekingTypePersoon = new stdClass();
                $boekingTypePersoon->typePersoonId = $type->id;
                $boekingTypePersoon->boekingId = $boeking->id;
                $boekingTypePersoon->aantal = $aantal;
                $this->load->model('boekingTypePersoon_model');
                $boekingTypePersoon->id = $this->boekingTypePersoon_model->insert($boekingTypePersoon);
            }
        }

        foreach ($personen as $id => $aantal) {
            $totaal = $totaal + $aantal;
        }

        return $totaal;
    }

    function berekenPrijs($boeking, $aantalDagen) {
        /**
         * berekent de prijs
         * \param $boeking de boeking
         * \param $aantalDagen het aantal dagen dat je geboekt hebt
         */
        $aantalMensen = 0;
        $index = 0;
        $totaal = 0;

        /**
         * haal alle kamerboekingen van de boeking op
         */
        $this->load->model('kamerBoeking_model');
        $kamerBoekingen = $this->kamerBoeking_model->getWithBoeking($boeking->id);

        /**
         * haal alle type personen op
         */
        $this->load->model('boekingTypePersoon_model');
        $typePersonen = $this->boekingTypePersoon_model->getByBoeking($boeking->id);

        foreach ($typePersonen as $typePersoon) {
            /**
             * vergellijk aantal van dit type persoon met totaal in geboekte kamer
             */
            if ($aantalMensen >= $kamerBoekingen[$index]->aantalMensen) {
                $index++;
                $aantalMensen = 0;
            }

            /**
             * haal kamertype van de geboekte kamer
             */
            $this->load->model('kamer_model');
            $kamerBoeking = $this->kamer_model->get($kamerBoekingen[$index]->kamerId);

            /**
             * bereken prijs voor geboekte kamer voor dit type persoon
             */
            $this->load->model('prijs_model');
            $prijs = $this->prijs_model->getPrijsTotaal($boeking->arrangementId, $kamerBoeking->kamerTypeId, $kamerBoekingen[$index]->aantalMensen);

            /**
             * haal korting voor type persoon op
             */
            $this->load->model('typePersoon_model');
            $type = $this->typePersoon_model->get($typePersoon->typePersoonId);

            /**
             * totaal omhoog doen
             */
            $totaal += (floatval($prijs->actuelePrijs) - (floatval($prijs->actuelePrijs) * floatval($type->korting))) * $typePersoon->aantal;

            /**
             * aantal mensen omhoog doen
             */
            $aantalMensen = $aantalMensen + $typePersoon->aantal;
        }

        $totalePrijs = $totaal * $aantalDagen;
        return $totalePrijs;
    }

    function berekenAaantalDagen($begindatum, $einddatum) {
        /**
         * berekent het aantal dagen dat je hebt geboekt indien pension
         * \param $begindatum de startdatum
         * \param $einddatum de einddatum
         */
        $date1 = date_create($begindatum);
        $date2 = date_create($einddatum);
        $verschil = date_diff($date1, $date2);
        $aantalDagen = (int) $verschil->format("%a") + 1;
        return $aantalDagen;
    }

    function unsetUserdata() {
        /**
         * unset de userdata
         */
        if ($this->session->has_userdata('begindatum')) {
            $this->session->unset_userdata('begindatum');
        }

        if ($this->session->has_userdata('einddatum')) {
            $this->session->unset_userdata('einddatum');
        }

        if ($this->session->has_userdata('arrangementId')) {
            $this->session->unset_userdata('arrangementId');
        }

        if ($this->session->has_userdata('boeking')) {
            $this->session->unset_userdata('boeking');
        }

        if ($this->session->has_userdata('kamers')) {
            $this->session->unset_userdata('kamers');
        }

        if ($this->session->has_userdata('pensionId')) {
            $this->session->unset_userdata('pensionId');
        }
    }

    public function haalKlant() {
        /**
         * haal de gegevens van de klant
         * laadt de pagina waar je je gegevens als klant kunt aanpassen
         */
        $data['title'] = 'Gegevens beheren';
        $data['author'] = 'Van de Voorde Tim';

        $data['user'] = $this->authex->getUserInfo();
        $user = $this->authex->getUserInfo();

        $partials = array('navbar' => 'main_navbar', 'content' => 'klant/ajax_klant', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
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

        $wachtwoord = $this->input->post('wachtwoord');
        if ($wachtwoord != "" && $wachtwoord != null) {
            $object->wachtwoord = sha1($wachtwoord);
        }

        $this->load->model('persoon_model');
        if ($object->id == 0) {
            $this->persoon_model->insert($object);
        } else {
            $this->persoon_model->update($object);
        }
        redirect('klant/haalKlant');
    }

}
