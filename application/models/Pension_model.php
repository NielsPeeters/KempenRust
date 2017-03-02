<?php

class Pension_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        /**
        *Geeft het pension object terug dat bij het id hoort.
        *\param id het id van het te halen pension object
        *\return een pension object
        */
        $this->db->where('id', $id);
        $query = $this->db->get('pension');
        return $query->row();                 // genereert een pension object
    }

    function getAll() {
        /**
        *Geeft een array terug met alle pension objecten.
        *\return een array met pension objecten
        */
        $query = $this->db->get('pension');  // genereert SELECT * FROM persoon
        return $query->result();             // een array met pension-objecten
    }

    function insert($pension) {
        /**
        *Insert een pension object in de database.
        *\param factuur een pension object
        *\return een pension object
        */
        $this->db->insert('pension', $pension);
        return $this->db->insert_id();
    }

    function update($pension) {
         /**
        *Update een pension object in de database.
        *\param pension een pension object
        */
        $this->db->where('id', $pension->id);
        $this->db->update('pension', $pension);
    }

    function delete($id) {
        /**
        * verwijderd het pension object dat bij het id hoort uit de database
        * \param id het id van de geselecteerde pension
        */
        $this->db->where('id', $id);
        $this->db->delete('pension');
    }

}

?>
