<?php
class kamerBoeking_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        /**
        *Geeft het kamerBoeking object terug dat bij het id hoort.
        *\param id het id van het te halen kamerBoeking object
        *\return een kamerBoeking object
        */
        $this->db->where('id', $id);
        $query = $this->db->get('kamerBoeking');
        return $query->row();                 // genereert een kamerBoeking object
    }

    function getAll() {
        /**
        *Geeft een array terug met alle kamerBoeking objecten.
        *\return een array met kamerBoeking objecten
        */
        $query = $this->db->get('kamerBoeking');  // genereert SELECT * FROM kamerBoeking
        return $query->result();             // een array met kamerBoeking-objecten
    }

    function insert($kamerBoeking) {
        /**
        *Insert een kamerBoeking object in de database.
        *\param kamerBoeking een kamerBoeking object
        *\return een kamerBoeking object
        */
        $this->db->insert('kamerBoeking', $kamerBoeking);
        return $this->db->insert_id();
    }

    function update($kamerBoeking) {
         /**
        *Update een kamerBoeking object in de database.
        *\param kamerBoeking een kamerBoeking object
        */
        $this->db->where('id', $kamerBoeking->id);
        $this->db->update('kamerBoeking', $kamerBoeking);
    }

    function delete($id) {
        /**
        * verwijdert het kamerBoeking object dat bij het id hoort uit de database
        * \param id het id van de geselecteerde kamerBoeking
        */
        $this->db->where('id', $id);
        $this->db->delete('kamerBoeking');
    }

    function getAllByKamer($id) {
        /**
        * gaat na of er een kamerboeking is met de geselecteerde kamer
        *\param id het id van de geselecteerde kamer
        *\return een array kamerboeking objecten
        */
        $this->db->where('kamerId', $id);
        $query = $this->db->get('kamerBoeking');
        return $query->result();
    }
    
    function getAllByBoeking($id) {
        /**
        * gaat na of er een kamerboeking is met de geselecteerde boeking
        *\param id het id van de geselecteerde boeking
        *\return een array kamerboeking objecten
        */
        $this->db->where('boekingId', $id);
        $query = $this->db->get('kamerBoeking');
        return $query->result();
    }

    function getWithBoeking($id){
        /**
        *
        *\param id
        *\return een array kamerboeking objecten
        */
        $this->db->where('boekingId', $id);
        $query = $this->db->get('kamerBoeking');
        return $query->result();
    }

      function getWithBoekingAndInfo($id){
        /**
        *
        *\param id
        *\return een array kamerboeking objecten
        */
        $this->db->where('boekingId', $id);
        $kamerboekingen = $this->db->get('kamerBoeking');
        $this->load->model('kamer_model');
        $this->load->model('kamerType_model');
        foreach($kamerboekingen as $kamerboeking){
            $kamer = $this->kamer_model->get($kamerboeking->kamerId);
            $kamerboeking->kamer = $kamer->naam;
            $type = $this->kamerType_model->get($kamer->kamerTypeId);
            $kamerboeking->type = $kamer->kamerTypeId;
            
        }
        

        return $kamerboekingen->result();
    }


}

