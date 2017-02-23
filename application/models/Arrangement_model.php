<?php

class Extra_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('arrangement');
        return $query->row();                 // genereert een arrangement object
    }

    function getAll() {
        $query = $this->db->get('arrangement');  // genereert SELECT * FROM persoon
        return $query->result();             // een array met arrangement-objecten
    }

    function insert($arrangement) {
        $this->db->insert('arrangement', $arrangement);
        return $this->db->insert_id();
    }

    function update($arrangement) {
        $this->db->where('id', $arrangement->id);
        $this->db->update('arrangement', $arrangement);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('arrangement');
    }

}

?>
