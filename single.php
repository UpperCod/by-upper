<?php

use Timber\Timber;

$context = Timber::get_context();
$context["page"] = Timber::get_post();

Timber::render([
    "views/pages/single-{$context["page"]->type}.twig",
    "views/pages/single.twig",
    "views/pages/404.twig"
], $context);
