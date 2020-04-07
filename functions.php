<?php

const FORM_SECRET = "GnLTbZnqpG";
const FORM_METHOD = "AES-128-CBC";
const TIMBER_CACHE = 600;
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

if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
		echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
	});
	add_filter('template_include', function( $template ) {
		return get_stylesheet_directory() . '/views/no-timber.html';
	});
	return;
}

require_once __DIR__."/backend/custom-twig.php";
require_once __DIR__."/backend/optimization.php";

add_theme_support( 'post-formats' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'menus' );

if( function_exists('acf_add_options_page') ){
    acf_add_options_page([
        'page_title'=>'Sitio',
        'menu_title'=>'Campos Globales',
        'menu_slug' =>'index',
    ]);
}
/*

if( function_exists('acf_update_setting')){
    acf_update_setting(
        'google_api_key', 
        'AIzaSyBpk1q5XL0wv5QhnOC-MU43Q4y_4C2J43w'
    );
}
*/


Routes::map('theme/:form', function($params){
    Routes::load('backend/router-form.php', $params,null, 200);
});
