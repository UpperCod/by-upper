<?php

use Timber\Timber;

$context = Timber::get_context();
$context["page"] = Timber::get_post();


if(function_exists("ACF")){
    $context["options"] = get_fields( 'options' );
    $context["globals"] = $context["options"]["globals"];
}