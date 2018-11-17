<?php
/**
 * Template Name: clear canvas
 */
use Timber\Timber;

$context = Timber::get_context();
$context['page'] = Timber::get_post();

Timber::render('views/pages/canvas.twig', $context);

