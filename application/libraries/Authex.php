<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Authex {

    // +----------------------------------------------------------
    // | TV Shop
    // +----------------------------------------------------------
    // | 2ITF - 201x-201x
    // +----------------------------------------------------------
    // | Authex library
    // |
    // +----------------------------------------------------------
    // | Nelson Wells
    // | 
    // | aangepast door Thomas More
    // +----------------------------------------------------------

    public function __construct() {
        $CI = & get_instance();

        $CI->load->model('persoon_model');
    }

    function loggedIn() {
        // gebruiker is aangemeld als sessievariabele user_id bestaat
        $CI = & get_instance();
        if ($CI->session->has_userdata('user_id')) {
            return true;
        } else {
            return false;
        }
    }

    function getUserInfo() {
        // geef user-object als gebruiker aangemeld is
        $CI = & get_instance();
        if (!$this->loggedIn()) {
            return null;
        } else {
            $id = $CI->session->userdata('user_id');
            return $CI->persoon_model->get($id);
        }
    }

    function login($email, $password) {
        // gebruiker aanmelden met opgegeven email en wachtwoord
        $CI = & get_instance();
        $user = $CI->persoon_model->getAccount($email, $password);
        if ($user == null) {
            return false;
        } else {
            $CI->persoon_model->updateLaatstAangemeld($user->id);
            $CI->session->set_userdata('user_id', $user->id);
            return true;
        }
    }

    function logout() {
        // uitloggen, dus sessievariabele wegdoen
        $CI = & get_instance();
        $CI->session->unset_userdata('user_id');
    }

    function register( $email, $persoon) {
        // nieuwe gebruiker registreren als email nog niet bestaat
        $CI = & get_instance();
        if ($CI->persoon_model->emailVrij($email)) {
            $id = $CI->persoon_model->insert($persoon);
            return $id;
        } else {
            return 0;
        }
    }

    function activate($id) {
        // nieuwe gebruiker activeren
        $CI = & get_instance();
        $CI->persoon_model->activeer($id);
    }



}
