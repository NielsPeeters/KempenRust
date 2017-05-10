<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {


    
    	public function __construct()
	{
            parent::__construct();
            $this->load->helper('form');
            $this->load->helper('notation');
    }
//
//	public function index()
//	{
//	        //Laadt de thuis pagina
//            $data['title']  = 'Dit is de $data[\'title\'] = "xxx"';
//            $data['nobox'] = true;      // geen extra rand rond hoofdmenu
//            $data['author'] = 'Peeters Niels';
//            $data['user'] = $this->authex->getUserInfo();
//
//            //main_content moet vervangen worden naar gebruiker/arangementen bij finale afwerking!
//            $partials = array('navbar' => 'main_navbar', 'content' => 'main_content', 'footer' => 'main_footer');
//            $this->template->load('main_master', $partials, $data);
//	}

	function aanmelden()
    {
        //Haalt post gegevens op en gebruikt deze om de gebruiker aan te melden en in de sessie variabelen te zetten.
        $email = $this->input->post('email');
        $wachtwoord = sha1($this->input->post('wachtwoord'));
        $this->authex->login($email, $wachtwoord);
        if ($this->authex->loggedIn())
        {
            redirect("home/index");
        } else{
            redirect("home/login");
        }

    }

    function getAjaxLogin()
    {
        //Beantwoordt de het ajax aanmeld venster van de navigatiebalk.
        $email = $this->input->post('email');
        $wachtwoord = sha1($this->input->post('wachtwoord'));

        $this->load->model('Persoon_model');

        if($this->Persoon_model->getAccount($email, $wachtwoord) != null){
            echo true;
        } else{
            echo false;
        }
    }

    function afmelden()
    {
        //Meldt een reeds aangemelde gebruiker uit en stuurt de gebruiker terug naar de begin pagina.
        $this->authex->logout();
        redirect("home/index");

    }
    
     function index()
    {
        
        $data['title']  = 'Overzicht';
        $data['nobox'] = true;      // geen extra rand rond hoofdmenu
        $data['author'] = 'Van de Voorde Tim';
        $data['user'] = $this->authex->getUserInfo();
            
        $this->load->model('arrangement_model');
        $data['arrangementen'] = $this->arrangement_model->getArrangementen(1);
        
        $this->load->model('boeking_model');
        $data['boekingen'] = $this->boeking_model->getBoekingenWith();
        
        
        $partials = array('navbar' => 'main_navbar', 'content' => 'gebruiker/dashboard/dashboard', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

}
