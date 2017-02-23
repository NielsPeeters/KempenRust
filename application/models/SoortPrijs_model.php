<?php

class soortPrijs_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('soortPrijs');
        return $query->row();                 // genereert een kamersoort object
    }

    function getAll() {
        $query = $this->db->get('soortPrijs');  // genereert SELECT * FROM persoon
        return $query->result();             // een array met kamersoort-objecten
    }

    function insert($soortPrijs) {
        $this->db->insert('soortPrijs', $soortPrijs);
        return $this->db->insert_id();
    }

    function update($soortPrijs) {
        $this->db->where('id', $soortPrijs->id);
        $this->db->update('soortPrijs', $soortPrijs);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('soortPrijs');
    }

}

?>
