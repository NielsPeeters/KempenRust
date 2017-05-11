<?php

class Boeking_model extends CI_Model {
    /**
     *Voorziet de communicatie tussen de webapplicatie en de SQL server voor alle gegevens uit de Boeking tabel te halen.
     */
    function __construct() {
        parent::__construct();
    }

    function get($id) {
        /**
        * Geeft het boeking object terug dat bij het id hoort.
        *\param $id het id van het te halen boeking object
        *\return een boeking object
        */
        $this->db->where('id', $id);
        $query = $this->db->get('boeking');
        return $query->row();                 // genereert een boeking object
    }

    function getAll() {
        /**
        *Geeft een array terug met alle boeking objecten.
        *\return een array met boeking objecten
        */
         $this->db->order_by('id', 'desc');
        $query = $this->db->get('boeking');  // genereert SELECT * FROM persoon
        return $query->result();             // een array met boeking-objecten
    }

    function insert($boeking) {
        /**
        *Insert een boeking object in de database.
        *\param $boeking een boeking object
        *\return een boeking object
        */
        $this->db->insert('boeking', $boeking);
        return $this->db->insert_id();
    }

    function update($boeking) {
         /**
        *Update een boeking object in de database.
        *\param $boeking een boeking object
        */
        
        $this->db->where('id', $boeking->id);
        $this->db->update('boeking', $boeking);
    }

    function delete($id) {
        /**
        * verwijdert het boeking object dat bij het id hoort uit de database
        * \param $id het id van de geselecteerde boeking
        */
        $this->db->where('id', $id);
        $this->db->delete('boeking');
    }

    function getBoekingenWith(){
        /**
        * geeft een array boeking object terug met alle geassocieerde eigenschappen
        * \return een array boeking objecten
        */
        $this->db->order_by('startDatum', 'asc');
        $query = $this->db->get('boeking');
        $boekingen = $query->result();
        
        $this->load->model('persoon_model');
        $this->load->model('kamerType_model');
        $this->load->model('kamerBoeking_model');
        $this->load->model('kamer_model');
        $this->load->model('boekingTypePersoon_model');

        foreach ($boekingen as $boeking) {
            $boeking->persoon = $this->persoon_model->get($boeking->persoonId);
            $boeking->kamerBoeking = $this->kamerBoeking_model->getWithBoeking($boeking->id);
            $totaalPersonen = 0;
            $boekingTypePersonen = $this->boekingTypePersoon_model->getByBoeking($boeking->id);
             foreach($boeking->kamerBoeking as $key => $kamerBoekingCurrent){
                $boeking->kamerBoeking[$key]->Kamer = $this->kamer_model->get($kamerBoekingCurrent->kamerId);
                $boeking->kamerBoeking[$key]->Boeking = $this->boeking_model->get($kamerBoekingCurrent->boekingId);
            }
            foreach($boekingTypePersonen as $boekingTypePersoon){
                $totaalPersonen += (int) $boekingTypePersoon->aantal;
            }
            $boeking->aantalPersonen = $totaalPersonen;
        }


        $this->load->model('arrangement_model');
        foreach ($boekingen as $boeking) {
            $arrangement = $this->arrangement_model->get($boeking->arrangementId);
            $boeking->arrangement = $arrangement->naam;
        }
        return $boekingen;
    }

    function getBoekingenWithG($goedgekeurd){
        /**
        * geeft een array boeking object terug met alle geassocieerde eigenschappen
        * \return een array boeking objecten
        */
        $this->db->where('goedgekeurd', $goedgekeurd);
        $this->db->order_by('startDatum', 'asc');
        $query = $this->db->get('boeking');
        $boekingen = $query->result();
        
        $this->load->model('persoon_model');
        $this->load->model('kamerType_model');
        $this->load->model('kamerBoeking_model');
        $this->load->model('kamer_model');
        $this->load->model('boekingTypePersoon_model');

        foreach ($boekingen as $boeking) {
            $boeking->persoon = $this->persoon_model->get($boeking->persoonId);
            $boeking->kamerBoeking = $this->kamerBoeking_model->getWithBoeking($boeking->id);
            $totaalPersonen = 0;
            $boekingTypePersonen = $this->boekingTypePersoon_model->getByBoeking($boeking->id);
             foreach($boeking->kamerBoeking as $key => $kamerBoekingCurrent){
                $boeking->kamerBoeking[$key]->Kamer = $this->kamer_model->get($kamerBoekingCurrent->kamerId);
                $boeking->kamerBoeking[$key]->Boeking = $this->boeking_model->get($kamerBoekingCurrent->boekingId);
            }
            foreach($boekingTypePersonen as $boekingTypePersoon){
                $totaalPersonen += (int) $boekingTypePersoon->aantal;
            }
            $boeking->aantalPersonen = $totaalPersonen;
        }


        $this->load->model('arrangement_model');
        foreach ($boekingen as $boeking) {
            $arrangement = $this->arrangement_model->get($boeking->arrangementId);
            $boeking->arrangement = $arrangement->naam;
        }
        return $boekingen;
    }

    function getBoekingWithAll($id){
        /**
        * geeft een boeking object terug met alle geassocieerde eigenschappen
        * \param $id het id van de geselecteerde boeking
        * \return een boeking object
        */
        
         $this->db->where('id', $id);
        $query = $this->db->get('boeking');
        $boeking = $query->row();
        $this->load->model('persoon_model');
        $this->load->model('arrangement_model');
        $boeking->persoon = $this->persoon_model->get($boeking->persoonId);
        $arrangement = $this->arrangement_model->get($boeking->arrangementId);
        $boeking->arrangement = $arrangement->naam;
        return $boeking;

    }
    
    function getAllByPersoon($id) {
        /**
        * haalt de boeking uit de database die bij het gegeven id hoort
        * \param $persoonid het id van de geselecteerde boeking
        * \return of persoon bij boeking hoort
        */
        $this->db->where('persoonId', $id);
        $query = $this->db->get('boeking');
        return $query->result();
    }
    
     function getAllByPersoonOrderByStartDatum($id) {
        /**
        * haalt de boeking uit de database die bij het gegeven id hoort
        * \param $persoonid het id van de geselecteerde boeking
        * \return of persoon bij boeking hoort
        */
        $this->db->where('persoonId', $id);
        $this->db->order_by('startDatum', 'asc');
        $query = $this->db->get('boeking');
        return $query->result();
    }


    function getAllByArrangement($arrangementId){
        /**
        * haalt de boeking uit de database die bij het gegeven arrangementId horen
        * \param $arrangementId het id van de geselecteerde boeking
        * \return of arrangement bij boeking hoort
        */
        $this->db->where('arrangementId', $arrangementId);
        $query = $this->db->get('boeking');
        return $query->result();
    }
}

?>
