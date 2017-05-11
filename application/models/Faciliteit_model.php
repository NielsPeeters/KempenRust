<?php

class Faciliteit_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        /**
        *Geeft het faciliteit object terug dat bij het id hoort.
        *\param $id het id van het te halen faciliteit object
        *\return een faciliteit object
        */
        $this->db->where('id', $id);
        $query = $this->db->get('faciliteit');
        return $query->row();                 /**< genereert een faciliteit object */
    }

    function getAll() {
        /**
        *Geeft een array terug met alle faciliteit objecten.
        *\return een array met faciliteit objecten
        */
        $this->db->order_by('naam', 'asc');
        $query = $this->db->get('faciliteit');  /**< genereert SELECT * FROM persoon */
        return $query->result();             /**< een array met faciliteit-objecten */
    }

    function insert($faciliteit) {
        /**
        *Insert een faciliteit object in de database.
        *\param $faciliteit een faciliteit object
        *\return een faciliteit object
        */
        $this->db->insert('faciliteit', $faciliteit);
        return $this->db->insert_id();
    }

    function update($faciliteit) {
         /**
        *Update een faciliteit object in de database.
        *\param $faciliteit een faciliteit object
        */
        $this->db->where('id', $faciliteit->id);
        $this->db->update('faciliteit', $faciliteit);
    }

    function delete($id) {
        /**
        * verwijdert het faciliteit object dat bij het id hoort uit de database
        * \param $id het id van de geselecteerde faciliteit
        */
        $this->db->where('id', $id);
        $this->db->delete('faciliteit');
    }

}

?>
