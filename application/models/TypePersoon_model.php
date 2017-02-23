<?php

class typepersoon_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function get($id)
    {
      $this->db->where('id', $id);
      $query = $this->db->get('typepersoon');
      return $query->row();                         // genereert een typepersoon object
    }

    function getAll()
    {
        $query = $this->db->get('typepersoon');	    // genereert SELECT * FROM typepersoon
        return $query->result();                    // een array met typepersoon-objecten
    }

    function insert($typepersoon)
    {
        $this->db->insert('typepersoon', $typepersoon);
        return $this->db->insert_id();
    }

    function update($typepersoon)
    {
        $this->db->where('id', $typepersoon->id);
        $this->db->update('typepersoon', $typepersoon);
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('typepersoon');
    }


}

?>
