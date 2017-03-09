<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {
    public function __construct() {
         /**
        * standaard controller constructor
        * laadt helpers
        */
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('notation');
    }
}