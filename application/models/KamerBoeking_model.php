<?php
class KamerBoeking_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        /**
        *Geeft het kamerboeking object terug dat bij het id hoort.
        *\param id het id van het te halen kamerboeking object
        *\return een kamerboeking object
        */
        $this->db->where('id', $id);
        $query = $this->db->get('kamerboeking');
        return $query->row();                 // genereert een kamerboeking object
    }

    function getAll() {
        /**
        *Geeft een array terug met alle kamerboeking objecten.
        *\return een array met kamerboeking objecten
        */
        $query = $this->db->get('kamerboeking');  // genereert SELECT * FROM kamerboeking
        return $query->result();             // een array met kamerboeking-objecten
    }

    function insert($kamerboeking) {
        /**
        *Insert een kamerboeking object in de database.
        *\param kamerboeking een kamerboeking object
        *\return een kamerboeking object
        */
        $this->db->insert('kamerboeking', $kamerboeking);
        return $this->db->insert_id();
    }

    function update($kamerboeking) {
         /**
        *Update een kamerboeking object in de database.
        *\param kamerboeking een kamerboeking object
        */
        $this->db->where('id', $kamerboeking->id);
        $this->db->update('kamerboeking', $kamerboeking);
    }

    function delete($id) {
        /**
        * verwijderd het kamerboeking object dat bij het id hoort uit de database
        * \param id het id van de geselecteerde kamerboeking
        */
        $this->db->where('id', $id);
        $this->db->delete('kamerboeking');
    }

    function getAllByKamer($id) {
        $this->db->where('kamerId', $id);
        $query = $this->db->get('kamerboeking');
        return $query->result();
    }


}

