<?php
/**
 * Template Name: Welcome
 */
use Timber\Timber;

$context = Timber::get_context();
$context['page'] = Timber::get_post();

Timber::render('views/pages/welcome.twig', $context);
