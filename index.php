<?php

use Timber\Timber;

$context = Timber::get_context();
$context['page'] = Timber::get_post();

$dir = "views/pages/";
$view = [];

if( is_404() ) {
    $view[] = $dir."404.twig";
} elseif ( is_singular() ) {
    $view[] = $dir."single-{$context["page"]->type}.twig";
    $view[] = $dir."single.twig";
}elseif( is_home() ) {
    $context["page"] = Timber::get_post(get_option("page_for_posts"));
    $view[] = $dir."blog.twig";
}elseif( is_archive() ) {
    $query =  get_queried_object();
    if($query->taxonomy){
        $view[] = $dir."archive-".str_replace("_","-",$query->taxonomy).".twig";
        $view[] = $dir."archive.twig";
        $context['term'] = new \Timber\Term($query->taxonom);
    }
}

$view[] =$dir."index.twig";


Timber::render($view, $context);
