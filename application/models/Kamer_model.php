<?php

class Kamer_model extends CI_Model {

    function __construct() {
         /**
        * standaard model constructor
        */
        parent::__construct();
    }

    function get($id) {
        /**
        * haalt de kamer uit de database die bij het gegeven id hoort.
        * \param id het id van de geselecteerde kamer
        * \return een kamer object
        */
        $this->db->where('id', $id);
        $query = $this->db->get('kamer');
        return $query->row();
    }

    function getAll() {
         /**
        * haalt alle kamer uit de database
        * \return een array met kamer objecten
        */
        $this->db->order_by('naam', 'asc');
        $query = $this->db->get('kamer');
        return $query->result();
    }

    function insert($kamer) {
        /**
        * voegt een nieuw kamer object toe aan de database
        * \param kamer het kamer object
        * \return het id van het nieuwe kamer object
        */
        $this->db->insert('kamer', $kamer);
        return $this->db->insert_id();
    }

    function update($kamer) {
        /**
        * update de kamer uit de database die bij het gegeven id hoort.
        * \param kamer het kamer object
        */
        $this->db->where('id', $kamer->id);
        $this->db->update('kamer', $kamer);
    }

    function delete($id) {
        /**
        * verwijderd het kamer object dat bij het id hoort uit de database
        * \param id het id van de geselecteerde kamer
        */
        $this->db->where('id', $id);
        $this->db->delete('kamer');
    }

    function getWithKamerType($id){
        /**
        * haalt de kamer uit de database die bij het gegeven id hoort met het bijbehorende kamertype
        * \param id het id van de geselecteerde kamer
        * \return een kamer object
        */
        $kamer = $this->get($id);
        $this->load->model('kamerType_model');
        $kamer->type = $this->kamerType_model->get($kamer->kamerTypeId);
        return $kamer;
    }
    
     function getAllByType($id) {
        /**
        * haalt de kamer uit de database die bij het gegeven id
        * \param kamertypeid het id van de geselecteerde kamer
        * \return of kamertype bij kamer hoort
        */
        $this->db->where('kamerTypeId', $id);
        $query = $this->db->get('kamer');
        return $query->result();
    }

    function getAllWithKamerType(){
        /**
        * haalt de kamer uit de database die bij het gegeven id hoort met het bijbehorende kamertype
        * \param id het id van de geselecteerde kamer
        * \return een kamer object
        */
         $query = $this->db->get('kamer');
        $kamers = $query->result();
        
      
        $this->load->model('kamerType_model');
  

        foreach ($kamers as $kamer) {
           $kamer->type = $this->kamerType_model->get($kamer->kamerTypeId);
        }

        return $kamers;
    }

    function getAllBeschikbaar($begindatum, $einddatum) {
         /**
        * haalt alle kamers uit de database die beschikbaar zijn voor die periode
        * \return een array met kamer objecten
        */
        $kamers = array();
        $this->load->model('kamer_model');
        $alleKamers = $this->kamer_model->getAll();
        
        foreach($alleKamers as $kamer){
            $check = true;
            $this->load->model('kamerboeking_model');
            $boekingenMetKamer = $this->kamerboeking_model->getAllByKamer($kamer->id);
        
            foreach($boekingenMetKamer as $kamerBoeking) {
                $this->load->model('boeking_model');
                $boeking = $this->boeking_model->get($kamerBoeking->boekingId);
            
                if(!($this->kamer_model->checkData($begindatum, $boeking->startDatum, $einddatum, $boeking->eindDatum))){
                    $check = false;
                }
            }
            
            if($check){
                $kamers[$kamer->id] = $kamer->kamerTypeId . "." . $kamer->naam;
            }
        }
        
        return $kamers;
    }
    
    function checkData($beginDatumGevraagd, $beginDatumBoeking, $eindDatumGevraagd, $eindDatumBoeking) {
        $check = false;
        
        if (toDDMMYYYY($beginDatumBoeking) > $beginDatumGevraagd) {
            if ($eindDatumGevraagd < toDDMMYYYY($beginDatumBoeking)) {
                $check = true;
            }
        } else {
            if ($beginDatumGevraagd > toDDMMYYYY($eindDatumBoeking)) {
                $check = true;
            }
        }
        
        return $check;
    }
    
    
    function getAllTypesByKamers(){
        $types = array();
        
        $this->load->model('kamer_model');
        $kamers = $this->kamer_model->getAllBeschikbaar($this->session->userdata('begindatum'), $this->session->userdata('einddatum'));
            
        foreach($kamers as $id => $naam){
            $kamer = $this->kamer_model->get($id);
            $this->load->model('kamertype_model');
            $type = $this->kamertype_model->get($kamer->kamerTypeId);
            $types[$kamer->kamerTypeId] = $type->omschrijving;
        }
            
        return $types;
    }
}

?>
