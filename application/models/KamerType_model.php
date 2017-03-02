<?php

class kamerType_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('kamerType');
        return $query->row();                 // genereert een kamertype object
    }

    function getAll() {
        $query = $this->db->get('kamerType');  // genereert SELECT * FROM persoon
        return $query->result();             // een array met kamertype-objecten
    }

    function insert($kamerType) {
        $this->db->insert('kamerType', $prijs);
        return $this->db->insert_id();
    }

    function update($kamerType) {
        $this->db->where('id', $prijs->id);
        $this->db->update('kamerType', $kamerType);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('kamerType');
    }
    


}

?>
