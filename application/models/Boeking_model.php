<?php

class Extra_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('boeking');
        return $query->row();                 // genereert een boeking object
    }

    function getAll() {
        $query = $this->db->get('boeking');  // genereert SELECT * FROM persoon
        return $query->result();             // een array met boeking-objecten
    }

    function insert($boeking) {
        $this->db->insert('boeking', $boeking);
        return $this->db->insert_id();
    }

    function update($boeking) {
        $this->db->where('id', $boeking->id);
        $this->db->update('boeking', $boeking);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('boeking');
    }

}

?>
