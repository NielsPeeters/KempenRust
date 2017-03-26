<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// +----------------------------------------------------------
// | xxx - notation_helper
// +----------------------------------------------------------
// | KHK - 2 ITF - 201x-201x
// +----------------------------------------------------------
// | Notation Helper
// |
// +----------------------------------------------------------
// | Thomas More Kempen
// +----------------------------------------------------------

// databasedatum in juiste formaat zetten (van yyyy-mm-dd naar dd/mm/jjjj)

function toDDMMYYYY($input) {
    if ($input == "") {
        return "";
    } else {
        $tijd = explode(" ", $input);
        $datum = explode("-", $tijd[0]);
        $answer = $datum[2] . "/" . $datum[1] . "/" . $datum[0];
        if (count($tijd) > 1){
            $answer .= " " . $tijd[1];
        }
        return $answer;
    }
}

// ingegeven datum in formaat van database plaatsen (van dd/mm/jjjj naar yyyy-mm-dd)

function toYYYYMMDD($input) {
    if ($input == "") {
        return "";
    } else {
        $tijd = explode(" ", $input);
        $datum = explode("/", $tijd[0]);
        return $datum[2] . "-" . $datum[1] . "-" . $datum[0];
        if (count($tijd) > 1){
            $answer .= " " . $tijd[1];
        }
    }
}

// database decimaal getal tonen met komma (van 999.99 naar 999,99)

function toKomma($input) {
    if ($input == "") {
        return "";
    } else {
        $getal = explode(".", $input);
        if (count($getal) == 2) {
            return $getal[0] . ',' . $getal[1];
        } else {
            return $getal[0];
        }
    }
}

// ingegeven decimaal getal omzetten in databaseformaat (van 999,99 naar 999.99)

function toPunt($input) {
    if ($input == "") {
        return "";
    } else {
        $getal = explode(",", $input);
        if (count($getal) == 2) {
            return $getal[0] . '.' . $getal[1];
        } else {
            return $getal[0];
        }
    }
}


/* End of file notation_helper.php */
/* Location: helpers/notation_helper.php */