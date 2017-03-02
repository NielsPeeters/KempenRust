<?php

class Prijs_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        /**
        *Geeft het prijs object terug dat bij het id hoort.
        *\param id het id van het te halen prijs object
        *\return een prijs object
        */
        $this->db->where('id', $id);
        $query = $this->db->get('prijs');
        return $query->row();                 // genereert een prijs object
    }

    function getAll() {
        /**
        *Geeft een array terug met alle prijs objecten.
        *\return een array met prijs objecten
        */
        $query = $this->db->get('prijs');  // genereert SELECT * FROM persoon
        return $query->result();             // een array met prijs-objecten
    }

    function insert($prijs) {
        /**
        *Insert een prijs object in de database.
        *\param prijs een prijs object
        *\return een prijs object
        */
        $this->db->insert('prijs', $prijs);
        return $this->db->insert_id();
    }

    function update($prijs) {
         /**
        *Update een prijs object in de database.
        *\param prijs een prijs object
        */
        $this->db->where('id', $prijs->id);
        $this->db->update('prijs', $prijs);
    }

    function delete($id) {
        /**
        * verwijderd het prijs object dat bij het id hoort uit de database
        * \param id het id van de geselecteerde prijs
        */
        $this->db->where('id', $id);
        $this->db->delete('prijs');
    }

}

?>
