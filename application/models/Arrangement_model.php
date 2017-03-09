<?php

class Arrangement_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        /**
        *Geeft het arrangement object terug dat bij het id hoort.
        *\param id het id van het te halen arrangement object
        *\return een arrangement object
        */
        $this->db->where('id', $id);
        $query = $this->db->get('arrangement');
        return $query->row();                 // genereert een arrangement object
    }

    function getAll() {
        /**
        *Geeft een array terug met alle arrangement objecten.
        *\return een array met arrangement objecten
        */
        $query = $this->db->get('arrangement');  // genereert SELECT * FROM persoon
        return $query->result();             // een array met arrangement-objecten
    }

    function insert($arrangement) {
        /**
        *Insert een arrangement object in de database.
        *\param arrangement een arrangement object
        *\return een arrangement object
        */
        $this->db->insert('arrangement', $arrangement);
        return $this->db->insert_id();
    }

    function update($arrangement) {
         /**
        *Update een arrangement object in de database.
        *\param arrangement een arrangement object
        */
        $this->db->where('id', $arrangement->id);
        $this->db->update('arrangement', $arrangement);
    }

    function delete($id) {
        /**
        * verwijderd het arrangement object dat bij het id hoort uit de database
        * \param id het id van de geselecteerde arrangement
        */
        $this->db->where('id', $id);
        $this->db->delete('arrangement');
    }

    function getAllByPension($id) {
        /**
        * gaat na of er een arrangement is met het geselecteerde pension
        *\param id het id van het geselecteerde pension
        *\return een array arrangement objecten
        */
        $this->db->where('pensionId', $id);
        $query = $this->db->get('arrangement');
        return $query->result();
    }

}

?>
