<?php
/**
 * Template Name: home
 */
use Timber\Timber;

$context = Timber::get_context();
$context['page'] = Timber::get_post();

Timber::render('views/pages/home.twig', $context);
