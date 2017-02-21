<?php

function image($image, $attributes = '')
{
    $CI =& get_instance();
    $CI->load->helper('url');
    
    return "<img src=\"" . 
                base_url("assets/images/" . $image) . 
            "\"" . _stringify_attributes($attributes) . " />";
}

function imagebier($image, $attributes = '')
{
    $CI =& get_instance();
    $CI->load->helper('url');
    
    return "<img src=\"" . 
                base_url("assets/images/fotos/" . $image) . 
            "\"" . _stringify_attributes($attributes) . " />";
}

function javascript($js)
{
    $CI =& get_instance();
    $CI->load->helper('url');
    
    return "<script src=\"" . 
                base_url("assets/js/" . $js) . 
            "\"></script>";
}

function stylesheet($css)
{
    $CI =& get_instance();
    $CI->load->helper('url');
    
    return "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . 
                base_url("assets/css/" . $css) . 
            "\" />";
}
