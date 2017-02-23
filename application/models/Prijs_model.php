<?php

class Prijs_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('prijs');
        return $query->row();                 // genereert een prijs object
    }

    function getAll() {
        $query = $this->db->get('prijs');  // genereert SELECT * FROM persoon
        return $query->result();             // een array met prijs-objecten
    }

    function insert($prijs) {
        $this->db->insert('prijs', $prijs);
        return $this->db->insert_id();
    }

    function update($prijs) {
        $this->db->where('id', $prijs->id);
        $this->db->update('prijs', $prijs);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('prijs');
    }

}

?>
