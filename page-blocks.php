<?php
/**
 * Template Name: Bloques
 */
require __DIR__."/load-context.php";

Timber::render('views/pages/blocks.twig', $context);
