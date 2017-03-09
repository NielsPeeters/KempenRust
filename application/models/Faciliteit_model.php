<?php

class Faciliteit_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('faciliteit');
        return $query->row();                 /**< genereert een faciliteit object */
    }

    function getAll() {
        $query = $this->db->get('faciliteit');  /**< genereert SELECT * FROM persoon */
        return $query->result();             /**< een array met faciliteit-objecten */
    }

    function insert($faciliteit) {
        $this->db->insert('faciliteit', $faciliteit);
        return $this->db->insert_id();
    }

    function update($faciliteit) {
        $this->db->where('id', $faciliteit->id);
        $this->db->update('faciliteit', $faciliteit);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('faciliteit');
    }

}

?>
