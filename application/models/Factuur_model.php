<?php
class Factuur_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('factuur');
        return $query->row();                 // genereert een factuur object
    }

    function getAll() {
        $query = $this->db->get('factuur');  // genereert SELECT * FROM persoon
        return $query->result();             // een array met factuur-objecten
    }

    function insert($factuur) {
        $this->db->insert('factuur', $factuur);
        return $this->db->insert_id();
    }

    function update($factuur) {
        $this->db->where('id', $factuur->id);
        $this->db->update('factuur', $factuur);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('factuur');
    }

}

