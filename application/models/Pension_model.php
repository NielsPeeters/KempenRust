<?php

class Pension_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('pension');
        return $query->row();                 // genereert een pension object
    }

    function getAll() {
        $query = $this->db->get('pension');  // genereert SELECT * FROM persoon
        return $query->result();             // een array met pension-objecten
    }

    function insert($pension) {
        $this->db->insert('pension', $pension);
        return $this->db->insert_id();
    }

    function update($pension) {
        $this->db->where('id', $pension->id);
        $this->db->update('pension', $pension);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('pension');
    }

}

?>
