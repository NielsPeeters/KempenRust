<?php

class Prijs_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        /**
        *Geeft het prijs object terug dat bij het id hoort.
        *\param $id het id van het te halen prijs object
        *\return een prijs object
        */
        $this->db->where('id', $id);
        $query = $this->db->get('prijs');
        return $query->row();                 // genereert een prijs object
    }

    function getAll() {
        /**
        *Geeft een array terug met alle prijs objecten.
        *\return een array met prijs objecten
        */
        $query = $this->db->get('prijs');  // genereert SELECT * FROM persoon
        return $query->result();             // een array met prijs-objecten
    }

    function insert($prijs) {
        /**
        *Insert een prijs object in de database.
        *\param $prijs een prijs object
        *\return een prijs object
        */
        $this->db->insert('prijs', $prijs);
        return $this->db->insert_id();
    }

    function update($prijs) {
         /**
        *Update een prijs object in de database.
        *\param $prijs een prijs object
        */
        $this->db->where('id', $prijs->id);
        $this->db->update('prijs', $prijs);
    }

    function delete($id) {
        /**
        * verwijdert het prijs object dat bij het id hoort uit de database
        * \param $id het id van de geselecteerde prijs
        */
        $this->db->where('id', $id);
        $this->db->delete('prijs');
    }

    function getPrijs($arrangementId, $kamerTypeId, $aantal){
        /**
        * haalt het prijs object op dat hoort bij de bijhorende ids uit de database
        *\param $arrangementId
        *\param $kamerTypeId
        *\param $aantal 
        */
        $meerdere = 0;
         
        /*
        * check if aantal is meer dan 1
        */
        if($aantal > 1)
        {
            $meerdere = 1;
        }
        
        $this->db->where('arrangementId', $arrangementId);
        $query = $this->db->get('prijs');
        $prijzenPerArrangement = $query->result();
        
        foreach($prijzenPerArrangement as $prijs) {
            if($prijs->kamertypeId == $kamerTypeId) {
                if($prijs->meerderePersonen == $meerdere){
                    $this->db->where('id', $prijs->id);
                    $query = $this->db->get('prijs');
                    return $query->row();
                }
            }
        }
    }

     function getPrijsTotaal($arrangementId, $kamerTypeId, $meerdere) {
        /**
        * haalt het prijs object op dat hoort bij de bijhorende ids uit de database
        *\param $arrangementId
        *\param $kamerTypeId
        *\param $meerdere 
        */

         
        /*
        * check if aantal is meer dan 1
        */
        if($meerdere > 1)
        {
            $meerdere = 1;
        }else{
            $meerdere = 0;
        }
         
        $this->db->where('arrangementId', $arrangementId);
        $this->db->where('kamerTypeId', $kamerTypeId);
        $this->db->where('meerderePersonen', $meerdere);
        $query = $this->db->get('prijs');
        return $query->row();
    }


    function getPrijsByArrangementAndKamerType($arrangementId, $kamerTypeId) {
        /**
         * haalt het prijs object op dat hoort bij de bijhorende ids uit de database
         *\param $id het id van de geselecteerde prijs
         *\param arrangementId
         */
        $this->db->where('arrangementId', $arrangementId);
        $this->db->where('kamerTypeId', $kamerTypeId);
        $query = $this->db->get('prijs');
        return $query->result();
}

    function getEmptyPrijs() {
        /**
         * Creërt een leeg arrangement object
         * \return arrangement een leeg arrangement object
         */
        $prijs = new stdClass();

        $prijs->id = '0';
        $prijs->arrangementId = '';
        $prijs->kamerTypeId = '';
        $prijs->meerderePersonen = '';
        $prijs->actuelePrijs = '0.00';


        return $prijs;
    }

    public function insertPrijsByArrangemantId($id){
        /**
         * Voegt dynamisch prijzen toe als er een Arrangement is toegevoegd.
         */
        $prijs = $this->getEmptyPrijs();

        $prijs->arrangementId = $id;
        $this->load->model('prijs_model');
        $this->load->model('kamerType_model');
        $kamerTypes = $this->kamerType_model->getAll();

        foreach($kamerTypes as $kamerType){
            $prijs->kamerTypeId = $kamerType->id;
            for($i = 0 ; $i < 2 ; $i++){
                $prijs->meerderePersonen = $i;
                $this->prijs_model->insert($prijs);
            }
        }
    }

    function deleteByArrangementId($id) {
        /**
         * verwijdert het prijs object dat bij het id hoort uit de database
         * \param $id het id van de geselecteerde prijs
         */
        $this->db->where('arrangementId', $id);
        $this->db->delete('prijs');
    }

    public function insertPrijsByKamerTypeId($id){
        /**
         * Voegt dynamisch prijzen toe als er een Kamertype is toegevoegd.
         */
        $prijs = $this->getEmptyPrijs();

        $prijs->kamerTypeId = $id;
        $this->load->model('prijs_model');
        $this->load->model('arrangement_model');
        $arrangementen = $this->arrangement_model->getAll();

        foreach($arrangementen as $arangement){
            $prijs->arrangementId = $arangement->id;
            for($i = 0 ; $i < 2 ; $i++){
                $prijs->meerderePersonen = $i;
                $this->prijs_model->insert($prijs);
            }
        }
    }

    function deleteByKamerTypeId($id) {
        /**
         * verwijdert het prijs object dat bij het id hoort uit de database
         * \param $id het id van de geselecteerde prijs
         */
        $this->db->where('kamerTypeId', $id);
        $this->db->delete('prijs');
    }
}

?>
