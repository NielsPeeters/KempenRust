<?php

class TypePersoon_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function get($id)
    {
      $this->db->where('id', $id);
      $query = $this->db->get('typePersoon');
      return $query->row();                         // genereert een typepersoon object
    }

    function getAll()
    {
        $query = $this->db->get('typePersoon');	    // genereert SELECT * FROM typepersoon
        return $query->result();                    // een array met typepersoon-objecten
    }

    function insert($typepersoon)
    {
        $this->db->insert('typePersoon', $typepersoon);
        return $this->db->insert_id();
    }

    function update($typepersoon)
    {
        $this->db->where('id', $typepersoon->id);
        $this->db->update('typePersoon', $typepersoon);
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('typePersoon');
    }


}

?>
