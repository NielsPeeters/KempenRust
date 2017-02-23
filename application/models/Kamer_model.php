<?php

class Kamer_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('kamer');
        return $query->row();                 // genereert een kamer object
    }

    function getAll() {
        $query = $this->db->get('kamer');  // genereert SELECT * FROM persoon
        return $query->result();             // een array met kamer-objecten
    }

    function insert($kamer) {
        $this->db->insert('kamer', $kamer);
        return $this->db->insert_id();
    }

    function update($kamer) {
        $this->db->where('id', $kamer->id);
        $this->db->update('kamer', $kamer);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('kamer');
    }

}

?>
