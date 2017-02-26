<?php

class Persoon_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function get($id)
    {
      $this->db->where('id', $id);
      $query = $this->db->get('persoon');
      return $query->row();                 // genereert een persoon object
    }

    function getAll()
    {
        $query = $this->db->get('persoon');	 // genereert SELECT * FROM persoon
        return $query->result();             // een array met persoon-objecten
    }

    function insert($persoon)
    {
        $this->db->insert('persoon', $persoon);
        return $this->db->insert_id();
    }

    function update($persoon)
    {
        $this->db->where('id', $persoon->id);
        $this->db->update('persoon', $persoon);
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('persoon');
    }

      function emailVrij($email)
    {
        // is email al dan niet aanwezig
        $this->db->where('email', $email);
        $query = $this->db->get('persoon');
        if ($query->num_rows() == 0) {
            return true;
        } else {
            return false;
        }
    }

    function getAccount($email, $password)
    {
        $this->db->where('email', $email);
        $this->db->where('wachtwoord', $password);
        $query = $this->db->get('persoon');
        if($query->num_rows() == 1) {
            return $query->row();
        }else{
            return false;
        }                 // genereert een persoon object
    }

}

?>
