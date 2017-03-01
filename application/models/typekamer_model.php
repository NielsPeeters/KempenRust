<?php

class typeKamer_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('typeKamer');
        return $query->row();                 // genereert een kamertype object
    }

    function getAll() {
        $query = $this->db->get('typeKamer');  // genereert SELECT * FROM persoon
        return $query->result();             // een array met kamertype-objecten
    }

    function insert($typeKamer) {
        $this->db->insert('typeKamer', $prijs);
        return $this->db->insert_id();
    }

    function update($typeKamer) {
        $this->db->where('id', $prijs->id);
        $this->db->update('typeKamer', $typeKamer);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('typeKamer');
    }

}

?>
