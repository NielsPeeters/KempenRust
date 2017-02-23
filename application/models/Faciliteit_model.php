<?php

class Faciliteit_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('faciliteit');
        return $query->row();                 // genereert een faciliteit object
    }

    function getAll() {
        $query = $this->db->get('faciliteit');  // genereert SELECT * FROM persoon
        return $query->result();             // een array met faciliteit-objecten
    }

    function insert($faciliteiten) {
        $this->db->insert('faciliteit', $faciliteiten);
        return $this->db->insert_id();
    }

    function update($extra) {
        $this->db->where('id', $faciliteiten->id);
        $this->db->update('faciliteit', $faciliteiten);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('faciliteit');
    }

}

?>
