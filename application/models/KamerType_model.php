<?php

class kamerType_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        /**
        *Geeft het kamertype object terug dat bij het id hoort.
        *\param $id het id van het te halen kamertype object
        *\return een kamertype object
        */
        $this->db->where('id', $id);
        $query = $this->db->get('kamerType');
        return $query->row();                 // genereert een kamertype object
    }

    function getAll() {
        /**
        *Geeft een array terug met alle kamertype objecten.
        *\return een array met kamertype objecten
        */
        $this->db->order_by("omschrijving", "asc");
        $query = $this->db->get('kamerType');  // genereert SELECT * FROM persoon
        return $query->result();             // een array met kamertype-objecten
    }

    function insert($kamerType) {
        /**
        *Insert een kamertype object in de database.
        *\param $kamertype een kamertype object
        *\return een kamertype object
        */
        $this->db->insert('kamerType', $kamerType);
        return $this->db->insert_id();
    }

    function update($kamerType) {
        /**
        *Update een kamertype object in de database.
        *\param $kamertype een kamertype object
        */
        $this->db->where('id', $kamerType->id);
        $this->db->update('kamerType', $kamerType);
    }

    function delete($id) {
        /**
        *Verwijdert een kamertype object uit de database.
        *\param $id het id van het te verwijderen kamertype object
        */
        $this->db->where('id', $id);
        $this->db->delete('kamerType');
    }
    


}

?>
