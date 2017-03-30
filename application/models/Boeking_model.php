<?php

class Boeking_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        /**
        *Geeft het boeking object terug dat bij het id hoort.
        *\param id het id van het te halen boeking object
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
        *\param boeking een boeking object
        *\return een boeking object
        */
        $this->db->insert('boeking', $boeking);
        return $this->db->insert_id();
    }

    function update($boeking) {
         /**
        *Update een boeking object in de database.
        *\param boeking een boeking object
        */
        
        $this->db->where('id', $boeking->id);
        $this->db->update('boeking', $boeking);
    }

    function delete($id) {
        /**
        * verwijderd het boeking object dat bij het id hoort uit de database
        * \param id het id van de geselecteerde boeking
        */
        $this->db->where('id', $id);
        $this->db->delete('boeking');
    }

    function getBoekingenWith(){
        /**
        * geeft een array boeking object terug met alle geassocieerde eigenschappen
        * \return een array boeking objecten
        */
        $this->db->order_by('goedgekeurd', 'asc');
        $query = $this->db->get('boeking');
        $boekingen = $query->result();
        
        $this->load->model('persoon_model');
        $this->load->model('kamerType_model');
        $this->load->model('kamerBoeking_model');
        $this->load->model('kamer_model');

        foreach ($boekingen as $boeking) {
            $boeking->persoon = $this->persoon_model->get($boeking->persoonId);
            $boeking->kamerBoeking = $this->kamerBoeking_model->getWithBoeking($boeking->id);
        }


        $this->load->model('arrangement_model');
        foreach ($boekingen as $boeking) {
            if(!$boeking->arrangementId==NULL){
                $arrangement=$this->arrangement_model->get($boeking->arrangementId);
                if($arrangement->pensionId==NULL){
                    $boeking->arrangement = "Arrangement";}
                else{
                    $boeking->arrangement = "Pension";}
            }
            else{
                $boeking->arrangement="Menu";
            }
        }
        return $boekingen;

    }

    function getBoekingWithAll($id){
        /**
        * geeft een boeking object terug met alle geassocieerde eigenschappen
        * \param id het id van de geselecteerde boeking
        * \return een boeking object
        */
        $boeking = $this->get($id);
        $this->load->model('persoon_model');
        $boeking->persoon = $this->persoon_model->get($boeking->persoonId);
        return $boeking;

    }
    
        function getAllByPersoon($id) {
        /**
        * haalt de boeking uit de database die bij het gegeven id
        * \param persoonid het id van de geselecteerde boeking
        * \return of persoon bij boeking hoort
        */
        $this->db->where('persoonId', $id);
        $query = $this->db->get('boeking');
        return $query->result();
    }


}

?>
