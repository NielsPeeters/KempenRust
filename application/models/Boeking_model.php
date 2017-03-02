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

}

?>
