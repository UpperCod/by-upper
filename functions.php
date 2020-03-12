<?php

const FORM_SECRET = "GnLTbZnqpG";
const FORM_METHOD = "AES-128-CBC";
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


add_filter('upload_mimes', function ($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
});


Routes::map('theme/:form', function($params){
    Routes::load('backend/router-form.php', $params,null, 200);
});

// 
add_action( 'wp_enqueue_scripts', function(){
    wp_dequeue_style( 'wp-block-library' );
}, 100);





add_action('init', function () {
	// Prevent Emoji from loading on the front-end
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );

	// Remove from admin area also
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );

	// Remove from RSS feeds also
	remove_filter( 'the_content_feed', 'wp_staticize_emoji');
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji');

	// Remove from Embeds
	remove_filter( 'embed_head', 'print_emoji_detection_script' );

	// Remove from emails
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

	// Disable from TinyMCE editor. Currently disabled in block editor by default
	add_filter( 'tiny_mce_plugins', function ( $plugins ) {
        if( is_array($plugins) ) {
            $plugins = array_diff( $plugins, array( 'wpemoji' ) );
        }
        return $plugins;
    } );

	/** Finally, prevent character conversion too
         ** without this, emojis still work 
         ** if it is available on the user's device
	 */

	add_filter( 'option_use_smilies', '__return_false' );

});