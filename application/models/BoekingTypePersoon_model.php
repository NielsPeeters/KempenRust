<?php

class BoekingTypePersoon_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        /**
         *Geeft het boekingTypePersoon object terug dat bij het id hoort.
         *\param id het id van het te halen boekingTypePersoon object
         *\return een boekingTypePersoon object
         */
        $this->db->where('id', $id);
        $query = $this->db->get('boeking');
        return $query->row();                 // genereert een boekingTypePersoon object
    }

    function getAll() {
        /**
         *Geeft een array terug met alle boekingTypePersoon objecten.
         *\return een array met boekingTypePersoon objecten
         */
        $query = $this->db->get('boeking');  // genereert SELECT * FROM persoon
        return $query->result();             // een array met boekingTypePersoon-objecten
    }

    function insert($boekingTypePersoon) {
        /**
         *Insert een boekingTypePersoon object in de database.
         *\param boekingTypePersoon een boeking object
         *\return een boekingTypePersoon object
         */
        $this->db->insert('boekingTypePersoon', $boekingTypePersoon);
        return $this->db->insert_id();
    }

    function update($boekingTypePersoon) {
        /**
         *Update een boekingTypePersoon object in de database.
         *\param boekingTypePersoon een boekingTypePersoon object
         */

        $this->db->where('id', $boekingTypePersoon->id);
        $this->db->update('boekingTypePersoon', $boekingTypePersoon);
    }

    function delete($id) {
        /**
         * verwijderd het boekingTypePersoon object dat bij het id hoort uit de database
         * \param id het id van de geselecteerde boekingTypePersoon
         */
        $this->db->where('id', $id);
        $this->db->delete('boekingTypePersoon');
    }

    function getAllByTypePersoon($id) {
        /**
         *Geeft een array terug met een specifiek boekingTypePersoon object gefilterd op megekregen TypePersoonId.
         *\param id het TypePersoonId van het te halen TypePersoon object
         *\return een boekingTypePersoon object
         */
        $this->db->where('typePersoonId', $id);
        $query = $this->db->get('boekingTypePersoon');
        return $query->result();
    }

}

?>
