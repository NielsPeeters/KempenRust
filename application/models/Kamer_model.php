<?php

class Kamer_model extends CI_Model {

    function __construct() {
         /**
        * standaard model constructor
        */
        parent::__construct();
    }

    function get($id) {
        /**
        * haalt de kamer uit de database die bij het gegeven id hoort.
        * \param id het id van de geselecteerde kamer
        * \return een kamer object
        */
        $this->db->where('id', $id);
        $query = $this->db->get('kamer');
        return $query->row();
    }

    function getAll() {
         /**
        * haalt alle kamer uit de database
        * \return een array met kamer objecten
        */
        $this->db->order_by('naam', 'asc');
        $query = $this->db->get('kamer');
        return $query->result();
    }

    function insert($kamer) {
        /**
        * voegt een nieuw kamer object toe aan de database
        * \param kamer het kamer object
        * \return het id van het nieuwe kamer object
        */
        $this->db->insert('kamer', $kamer);
        return $this->db->insert_id();
    }

    function update($kamer) {
        /**
        * update de kamer uit de database die bij het gegeven id hoort.
        * \param kamer het kamer object
        */
        $this->db->where('id', $kamer->id);
        $this->db->update('kamer', $kamer);
    }

    function delete($id) {
        /**
        * verwijderd het kamer object dat bij het id hoort uit de database
        * \param id het id van de geselecteerde kamer
        */
        $this->db->where('id', $id);
        $this->db->delete('kamer');
    }

    function getWithKamerType($id){
        /**
        * haalt de kamer uit de database die bij het gegeven id hoort met het bijbehorende kamertype
        * \param id het id van de geselecteerde kamer
        * \return een kamer object
        */
        $kamer = $this->get($id);
        $this->load->model('kamerType_model');
        $kamer->type = $this->kamerType_model->get($kamer->kamerTypeId);
        return $kamer;
    }
    
     function getAllByType($id) {
        /**
        * haalt de kamer uit de database die bij het gegeven id
        * \param kamertypeid het id van de geselecteerde kamer
        * \return of kamertype bij kamer hoort
        */
        $this->db->where('kamerTypeId', $id);
        $query = $this->db->get('kamer');
        return $query->result();
    }

}

?>
