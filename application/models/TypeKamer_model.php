<?php

class Persoon_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('typekamer');
        return $query->row();                 // genereert een kamertype object
    }

    function getAll() {
        $query = $this->db->get('typekamer');  // genereert SELECT * FROM persoon
        return $query->result();             // een array met kamertype-objecten
    }

    function insert($typekamer) {
        $this->db->insert('typekamer', $typekamer);
        return $this->db->insert_id();
    }

    function update($typekamer) {
        $this->db->where('id', $typekamer->id);
        $this->db->update('typekamer', $typekamer);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('typekamer');
    }

}

?>
