<?php

class Persoon_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('extra');
        return $query->row();                 // genereert een extras object
    }

    function getAll() {
        $query = $this->db->get('extra');  // genereert SELECT * FROM persoon
        return $query->result();             // een array met extras-objecten
    }

    function insert($extra) {
        $this->db->insert('extra', $extra);
        return $this->db->insert_id();
    }

    function update($extra) {
        $this->db->where('id', $extra->id);
        $this->db->update('extra', $extra);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('extra');
    }

}

?>
