<?php

class TypePersoon_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function get($id)
    {
        /**
        *Geeft het typepersoon object terug dat bij het id hoort.
        *\param $id het id van het te halen typepersoon object
        *\return een typepersoon object
        */
      $this->db->where('id', $id);
      $query = $this->db->get('typePersoon');
      return $query->row();                         // genereert een typepersoon object
    }

    function getAll()
    {
        /**
        *Geeft een array terug met alle typepersoon objecten.
        *\return een array met typepersoon objecten
        */
        $query = $this->db->get('typePersoon');	    // genereert SELECT * FROM typepersoon
        return $query->result();                    // een array met typepersoon-objecten
    }

    function insert($typepersoon)
    {
        /**
        *Insert een typepersoon object in de database.
        *\param $typepersoon een typepersoon object
        *\return een typepersoon object
        */
        $this->db->insert('typePersoon', $typepersoon);
        return $this->db->insert_id();
    }

    function update($typepersoon)
    {
         /**
        *Update een typepersoon object in de database.
        *\param $typepersoon een typepersoon object
        */
        $this->db->where('id', $typepersoon->id);
        $this->db->update('typePersoon', $typepersoon);
    }

    function delete($id)
    {
        /**
        * verwijdert het typepersoon object dat bij het id hoort uit de database
        * \param $id het id van de geselecteerde typepersoon
        */
        $this->db->where('id', $id);
        $this->db->delete('typePersoon');
    }

    function getWithTypePersoon($id)
    {
        /**
         * haalt het typepersoon object op dat bij het id hoort uit de database
         * \param $id het id van de geselecteerde typepersoon
         *\return een typepersoon object
         */
        $this->db->where('id', $id);
        $query = $this->db->get('typePersoon');
        return $query->row();
    }

       function getWithBoeking($id)
    {
        /**
         * haalt het typepersoon object op dat bij het id hoort uit de database
         * \param $id het id van de geselecteerde boeking
         *\return een typepersoon object
         */
        $this->db->where('boekingId', $id);
        $query = $this->db->get('typePersoon');
        return $query->result();
    }

}

?>
