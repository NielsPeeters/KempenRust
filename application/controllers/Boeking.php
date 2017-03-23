<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Boeking extends CI_Controller {

    public function __construct() {
         /**
        * standaard controller constructor
        * laadt helpers
        */
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('notation');
    }

    public function index() {
        /**
        * Laadt de pagina waarop je boekingen kan beheren
        * geeft een array van boeking objecten mee
        */
        $data['title'] = 'boekingen beheren';
        $data['author'] = 'Laenen Nathalie';
        $data['user'] = $this->authex->getUserInfo();
        $user = $this->authex->getUserInfo();
        if($user->soort>1) {
            $this->load->model('boeking_model');
            $data['boekingen'] = $this->boeking_model->getBoekingenWith();

            $partials = array('navbar' => 'main_navbar', 'content' => 'werknemer/boeking/boeking_beheren', 'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        } else {
            redirect("/home/index");
        }       
    }

    public function haalboeking() {
        /**
        * Haalt een boeking object op
        */
        $boekingId = $this->input->get('boekingId');
        if($boekingId<0){
            $this->newBoeking();
        }
        else{
            $this->load->model('boeking_model');
            $data['boeking']= $this->boeking_model->getBoekingWithAll($boekingId);
            $this->load->model('boekingTypePersoon_model');
            $data['boekingTypePersonen'] = $this->boekingTypePersoon_model->getByBoeking($boekingId);
            $this->load->model('arrangement_model');
            $data['arrangementen'] = $this->arrangement_model->getAll();
            $this->load->model('typePersoon_model');
            $data['typePersonen'] = $this->typePersoon_model->getAll();
            $this->load->model('pension_model');
            $data['pensions'] = $this->pension_model->getAll();
            $this->load->model('kamerBoeking_model');
            $data['kamerBoekingen'] = $this->kamerBoeking_model->getWithBoeking($boekingId);
            $this->load->model('kamer_model');
            $data['kamers'] = $this->kamer_model->getAllWithKamerType();
            

            $this->load->view("werknemer/boeking/ajax_boeking", $data);
          
            }
    }

    public function verwijderboeking(){
        /**
        * Verwijderdt een boeking object als hieraan geen boekingen verbonden zijn
        */
        $id = $this->input->get('id');
        $this->load->model('boekingboeking_model');
        $result = $this->boekingboeking_model->getAllByboeking($id);
        $size = count($result);
        if ($size==0){
            $this->load->model('boeking_model');
            $this->boeking_model->delete($id);
            echo 0;
        }
        else {echo 1;}
        
        
    }

    function newBoeking() {
        /**
        * Creërt een leeg boeking object
        * \return boeking een leeg boeking object
        */
        
        $data['boeking']=$this->getEmptyBoeking();

        $this->load->model('kamerType_model');
        $data['kamerTypes'] = $this->kamerType_model->getAll();

        $this->load->model('arrangement_model');
        $data['arrangementen'] = $this->arrangement_model->getAll();

        $this->load->model('typePersoon_model');
        $data['typePersonen'] = $this->typePersoon_model->getAll();
      
        $this->load->model('pension_model');
        $data['pensions'] = $this->pension_model->getAll();

        foreach($data['typePersonen']as $typepersoon){
            $data['boekingTypePersonen'] = $this->getEmptyBoekingTypePersoon($typepersoon->id);
        }
    
        $this->load->view("werknemer/boeking/ajax_boeking", $data);
    }

    public function getEmptyBoekingTypePersoon($id){
        $boekingTypePersoon = new stdClass();

        $boekingTypePersoon->typePersoonId = $id ;
        $boekingTypePersoon->aantal = '0';
        $boekingTypePersoon->boekingId ='0';
        $boekingTypePersoon->id = '0';

        return $boekingTypePersoon;
    }

    public function getEmptyBoeking(){
        $boeking = new stdClass();

        $boeking->id = '0';
        $boeking->persoonId='0';
        $boeking->naam = '';
        $boeking->arrangementId='0';
        $boeking->opmerking='';
        $boeking->startDatum='';
        $boeking->eindDatum='';
        $boeking->tijdstip='';

        return $boeking;
    }

    public function schrijfboeking(){
        /**
        * Haalt de waarden van het boeking object op en update of insert deze in de database
        */
        $object = new stdClass();
        $object->id = $this->input->post('id');
        $object->naam = $this->input->post('naam');

        $this->load->model('boeking_model');
        if ($object->id == 0) {
            $this->boeking_model->insert($object);
        } else {
            $this->boeking_model->update($object);
        }
        echo 0;
    }







}
