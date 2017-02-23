<?php

class Menu_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('menu');
        return $query->row();                 // genereert een menu object
    }

    function getAll() {
        $query = $this->db->get('menu');  // genereert SELECT * FROM persoon
        return $query->result();             // een array met menu-objecten
    }

    function insert($menu) {
        $this->db->insert('menu', $menu);
        return $this->db->insert_id();
    }

    function update($menu) {
        $this->db->where('id', $menu->id);
        $this->db->update('menu', $menu);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('menu');
    }

}

?>
