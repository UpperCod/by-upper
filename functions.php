<?php

require_once __DIR__."/script/custom-twig.php";
/*
 * Die and Dump method
 */
if (!function_exists("dd")) {
    function dd()
    {
        echo "<pre>";
        array_map(function ($data) {
            print_r($data);
        }, func_get_args());
        echo "</pre>";
        die;
    }
}

add_theme_support( 'post-formats' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'menus' );
/*
if( function_exists('acf_add_options_page') ){
    acf_add_options_page([
        'page_title'=>'Sitio',
        'menu_title'=>'Configuración<br> de sitio',
        'menu_slug' =>'index',
    ]);
}

if( function_exists('acf_update_setting')){
    acf_update_setting(
        'google_api_key', 
        'AIzaSyBpk1q5XL0wv5QhnOC-MU43Q4y_4C2J43w'
    );
}
*/