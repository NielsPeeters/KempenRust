<?php

class Menu_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        /**
        *Geeft het menu object terug dat bij het id hoort.
        *\param id het id van het te halen menu object
        *\return een menu object
        */
        $this->db->where('id', $id);
        $query = $this->db->get('menu');
        return $query->row();                 // genereert een menu object
    }

    function getAll() {
        /**
        *Geeft een array terug met alle menu objecten.
        *\return een array met menu objecten
        */
        $query = $this->db->get('menu');  // genereert SELECT * FROM persoon
        return $query->result();             // een array met menu-objecten
    }

    function insert($menu) {
        /**
        *Insert een menu object in de database.
        *\param menu een menu object
        *\return een menu object
        */
        $this->db->insert('menu', $menu);
        return $this->db->insert_id();
    }

    function update($menu) {
         /**
        *Update een menu object in de database.
        *\param menu een menu object
        */
        $this->db->where('id', $menu->id);
        $this->db->update('menu', $menu);
    }

    function delete($id) {
        /**
        * verwijderd het menu object dat bij het id hoort uit de database
        * \param id het id van de geselecteerde menu
        */
        $this->db->where('id', $id);
        $this->db->delete('menu');
    }

}

?>
