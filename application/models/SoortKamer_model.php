<?php

class SoortKamer_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('soortkamer');
        return $query->row();                 // genereert een kamersoort object
    }

    function getAll() {
        $query = $this->db->get('soortkamer');  // genereert SELECT * FROM persoon
        return $query->result();             // een array met kamersoort-objecten
    }

    function insert($soortkamer) {
        $this->db->insert('soortkamer', $soortkamer);
        return $this->db->insert_id();
    }

    function update($soortkamer) {
        $this->db->where('id', $soortkamer->id);
        $this->db->update('soortkamer', $soortkamer);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('soortkamer');
    }

}

?>
