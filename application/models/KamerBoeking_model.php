<?php
class KamerBoeking_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('kamerboeking');
        return $query->row();                 // genereert een kamerboeking object
    }

    function getAll() {
        $query = $this->db->get('kamerboeking');  // genereert SELECT * FROM kamerboeking
        return $query->result();             // een array met kamerboeking-objecten
    }

    function insert($kamerboeking) {
        $this->db->insert('kamerboeking', $kamerboeking);
        return $this->db->insert_id();
    }

    function update($kamerboeking) {
        $this->db->where('id', $kamerboeking->id);
        $this->db->update('kamerboeking', $kamerboeking);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('kamerboeking');
    }

    function getAllByKamer($id) {
        $this->db->where('kamerId', $id);
        $query = $this->db->get('kamerboeking');
        return $query->result();
    }


}

