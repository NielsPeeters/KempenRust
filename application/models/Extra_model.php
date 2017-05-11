<?php

class Extra_model extends CI_Model {
    /**
     *Voorziet de communicatie tussen de webapplicatie en de SQL server voor alle gegevens uit de Extra tabel te halen.
     */
    function __construct() {
        parent::__construct();
    }

    function get($id) {
        /**
        *Geeft het extra object terug dat bij het id hoort.
        *\param $id het id van het te halen extra object
        *\return een extra object
        */
        $this->db->where('id', $id);
        $query = $this->db->get('extra');
        return $query->row();                 // genereert een extra object
    }

    function getAll() {
        /**
        *Geeft een array terug met alle extra objecten.
        *\return een array met extra objecten
        */
        $query = $this->db->get('extra');  // genereert SELECT * FROM persoon
        return $query->result();             // een array met extra-objecten
    }

    function insert($extra) {
        /**
        *Insert een extra object in de database.
        *\param $extra een extra object
        *\return een extra object
        */
        $this->db->insert('extra', $extra);
        return $this->db->insert_id();
    }

    function update($extra) {
         /**
        *Update een extra object in de database.
        *\param $extra een extra object
        */
        $this->db->where('id', $extra->id);
        $this->db->update('extra', $extra);
    }

    function delete($id) {
        /**
        * verwijdert het extra object dat bij het id hoort uit de database
        * \param $id het id van de geselecteerde extra
        */
        $this->db->where('id', $id);
        $this->db->delete('extra');
    }
    
    function getAllByFaciliteit($faciliteitId) {
        /**
        *Geeft het extra object terug dat bij het id hoort.
        *\param $faciliteitId het id van de geselecteerde faciliteit
        *\return een extra object
        */
        $this->db->where('faciliteitId', $faciliteitId);
        $query = $this->db->get('extra');
        return $query->result();
    }

}

?>
