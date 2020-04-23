<?php

use Timber\Timber;

$context = Timber::get_context();
$context["page"] = Timber::get_post(is_home() ? get_option("page_for_posts"): null);


if(function_exists("ACF")){
    $context["options"] = get_fields( 'options' );
    $context["globals"] = $context["options"]["globals"];
}

function render($template) {
    global $context;
    if(defined ("TIMBER_CACHE")){
        if(TIMBER_CACHE > 0){
            Timber::$cache = true;
            $args[] = TIMBER_CACHE;
        }
    }
    Timber::render($template,$context);
}