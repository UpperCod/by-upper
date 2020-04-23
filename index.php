<?php

require __DIR__."/load-context.php";

$dir = "views/pages/";
$view = [];

if( is_404() ) {
    $view[] = $dir."404.twig";
} elseif( is_singular("product") ){
    //$product            = wc_get_product( $context["page"]->ID );
    //$context["product"] = $product;

    //$related_limit               = wc_get_loop_prop( "columns" );
    //$related_ids                 = wc_get_related_products( $context["page"]->id, $related_limit );
    //$context["related_products"] =  Timber::get_posts( $related_ids );

    //wp_reset_postdata();

    //render( "views/woo/single-product.twig");
} elseif ( is_singular() ) {
    $view[] = $dir."single-{$context["page"]->type}.twig";
    $view[] = $dir."single.twig";
}elseif( is_home() ) {
    $context["page"] = Timber::get_post(get_option("page_for_posts"));
    $view[] = $dir."blog.twig";
}elseif( is_archive() ) {
    $query =  get_queried_object();
    $view[] = $dir."archive-".  $context["page"]->type->name .".twig";
    $view[] = $dir."archive.twig";
}

$view[] =$dir."index.twig";



render($view);