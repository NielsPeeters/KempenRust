<?php

class soortPrijs_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        /**
        *Geeft het soortprijs object terug dat bij het id hoort.
        *\param id het id van het te halen soortprijs object
        *\return een soortprijs object
        */
        $this->db->where('id', $id);
        $query = $this->db->get('soortPrijs');
        return $query->row();                 // genereert een kamersoort object
    }

    function getAll() {
        /**
        *Geeft een array terug met alle soortprijs objecten.
        *\return een array met soortpijs objecten
        */
        $query = $this->db->get('soortPrijs');  // genereert SELECT * FROM persoon
        return $query->result();             // een array met kamersoort-objecten
    }

    function insert($soortPrijs) {
        /**
        *Insert een soortpijs object in de database.
        *\param soortprijs een soortprijs object
        *\return een soortprijs object
        */
        $this->db->insert('soortPrijs', $soortPrijs);
        return $this->db->insert_id();
    }

    function update($soortPrijs) {
         /**
        *Update een soortprijs object in de database.
        *\param soortprijs een soortprijs object
        */
        $this->db->where('id', $soortPrijs->id);
        $this->db->update('soortPrijs', $soortPrijs);
    }

    function delete($id) {
        /**
        * verwijderd het soortprijs object dat bij het id hoort uit de database
        * \param id het id van de geselecteerde soortprijs
        */
        $this->db->where('id', $id);
        $this->db->delete('soortPrijs');
    }

}

?>
