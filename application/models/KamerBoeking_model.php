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
        * verwijderd het kamerBoeking object dat bij het id hoort uit de database
        * \param id het id van de geselecteerde kamerBoeking
        */
        $this->db->where('id', $id);
        $this->db->delete('kamerBoeking');
    }

    function getAllByKamer($id) {
        $this->db->where('kamerId', $id);
        $query = $this->db->get('kamerBoeking');
        return $query->result();
    }

    function getWithBoeking($id){
        $this->db->where('boekingId', $id);
        $query = $this->db->get('kamerBoeking');
        return $query->result();
    }


}

