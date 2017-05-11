<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Authex {

    /**
     * Authex Library
     */
    public function __construct() {
        /**
         * Constructor
         */
        $CI = & get_instance();

        $CI->load->model('persoon_model');
    }

    function loggedIn() {
        /**
         * inloggen
         */
        // gebruiker is aangemeld als sessievariabele user_id bestaat
        $CI = & get_instance();
        if ($CI->session->has_userdata('user_id')) {
            return true;
        } else {
            return false;
        }
    }

    function getUserInfo() {
        /**
         * info over gebruiker halen
         */
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
        /**
         * inloggen
         * \param $email e-mailadres gebruikt voor in te loggen
         * \param $password paswoord gebruikt om in te loggen
         */
        // gebruiker aanmelden met opgegeven email en wachtwoord
        $CI = & get_instance();
        $user = $CI->persoon_model->getAccount($email, $password);
        if ($user == null) {
            return false;
        } else {
            $CI->session->set_userdata('user_id', $user->id);
            return true;
        }
    }

    function logout() {
        /**
         * uitloggen
         */
        // uitloggen, dus sessievariabele wegdoen
        $CI = & get_instance();
        $CI->session->unset_userdata('user_id');
    }

    function register($email, $persoon) {
        /**
         * registreren van een persoon
         * \peram $email e-mailaddres gebruikt voor registreren
         * \param $persoon persoon met alle bijgevoegde informatie
         */
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
        /**
         * account activeren
         */
        // nieuwe gebruiker activeren
        $CI = & get_instance();
        $CI->persoon_model->activeer($id);
    }

}
