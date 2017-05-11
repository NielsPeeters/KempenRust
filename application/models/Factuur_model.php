<?php
class Factuur_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        /**
        *Geeft het factuur object terug dat bij het id hoort.
        *\param $id het id van het te halen factuur object
        *\return een factuur object
        */
        $this->db->where('id', $id);
        $query = $this->db->get('factuur');
        return $query->row();                 // genereert een factuur object
    }

    function getAll() {
        /**
        *Geeft een array terug met alle factuur objecten.
        *\return een array met factuur objecten
        */
        $query = $this->db->get('factuur');  // genereert SELECT * FROM persoon
        return $query->result();             // een array met factuur-objecten
    }

    function insert($factuur) {
        /**
        *Insert een factuur object in de database.
        *\param $factuur een factuur object
        *\return een factuur object
        */
        $this->db->insert('factuur', $factuur);
        return $this->db->insert_id();
    }

    function update($factuur) {
         /**
        *Update een factuur object in de database.
        *\param $factuur een factuur object
        */
        $this->db->where('id', $factuur->id);
        $this->db->update('factuur', $factuur);
    }

    function delete($id) {
        /**
        * verwijdert het factuur object dat bij het id hoort uit de database
        * \param $id het id van de geselecteerde factuur
        */
        $this->db->where('id', $id);
        $this->db->delete('factuur');
    }

}

