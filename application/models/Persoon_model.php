<?php

class Persoon_model extends CI_Model {

    function __construct()
    {
        /**
        * standaard model constructor
        */
        parent::__construct();
    }

    function get($id)
    {
        /**
        *Geeft het persoon object terug dat bij het id hoort.
        *\param id het id van het te halen persoon object
        *\return een persoon object
        */
        $this->db->where('id', $id);
        $query = $this->db->get('persoon');
        return $query->row();                 // genereert een persoon object
    }

    function getAll()
    {
        /**
        *Geeft een array terug met alle persoon objecten.
        *\return een array met persoon objecten
        */
        $this->db->order_by("naam", "asc");
        $query = $this->db->get('persoon');	 // genereert SELECT * FROM persoon
        return $query->result();             // een array met persoon-objecten
    }

    function insert($persoon)
    {
        /**
        *Insert een persoon object in de database.
        *\param persoon een persoon object
        *\return een persoon object
        */
        $this->db->insert('persoon', $persoon);
        return $this->db->insert_id();
    }

    function update($persoon)
    {
        /**
        *Update een persoon object in de database.
        *\param persoon een persoon object
        */
        $this->db->where('id', $persoon->id);
        $this->db->update('persoon', $persoon);
    }

    function delete($id)
    {
        /**
        *Verwijdert een persoon object uit de database.
        *\param id het id van het te verwijderen persoon object
        */
        $this->db->where('id', $id);
        $this->db->delete('persoon');
    }

      function emailVrij($email)
    {
        /**
        *Gaat na of het meegegeven email adres al in de database voorkomt.
        *\param email het te controleren email adres
        *\return true als de email vrij is, anders false
        */
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
        /**
        *Gaat na of er een persoon object bestaat met de meegegeven waarden.
        *\param email het ingegeven email adres
        *\param password het ingegeven wachtwoord.
        *\return een persoon object als deze bestaat, anders false.
        */
        $this->db->where('email', $email);
        $this->db->where('wachtwoord', $password);
        $query = $this->db->get('persoon');
        if($query->num_rows() == 1) {
            return $query->row();
        }else{
            return false;
        }                 // genereert een persoon object
    }

     function getWithNaam($naam, $voornaam)
    {
        /**
        *Geeft een persoon object met de naam
        *\param naam de familienaam van de persoon
        *\param voornaam de voornaam van de persoon
        *\return een persoon object
        */
        $this->db->where('naam', $naam);
        $this->db->where('voornaam', $voornaam);
        $query = $this->db->get('persoon');
        return $query->row();                // genereert een persoon object
    }

}

?>
