<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package babes
 */

// Include the necessary classes.
require get_template_directory() . '/inc/class-babes-post-navigation.php';
require get_template_directory() . '/inc/class-babes-single.php';

// Instantiate the Single class.
$babes_single = new Babes_Single();

// Render the header.
get_header();

// Render the single post content.
$babes_single->render_single();

// Render the footer.

get_footer();
