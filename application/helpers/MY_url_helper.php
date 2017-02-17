<?php

    // +----------------------------------------------------------
    // | TV Shop
    // +----------------------------------------------------------
    // | KHK - 2 ITF - 201x-201x
    // +----------------------------------------------------------
    // | MY url helper
    // |
    // +----------------------------------------------------------
    // | Thomas More Kempen
    // +----------------------------------------------------------

    function divAnchor($uri = '', $title = '', $attributes = '') 
    {
        return '<div>' . anchor($uri, $title, $attributes) . '</div>';
    }

    function smallDivAnchor($uri = '', $title = '', $attributes = '') 
    {
        return '<div style="margin-top: 4px">' . anchor($uri, $title, $attributes) . '</div>';
    }
?>
