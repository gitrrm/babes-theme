<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package babes
 */

// Include the Search class.
require get_template_directory() . '/inc/class-babes-search.php';

// Instantiate the Search class.
$babes_search = new Babes_Search();

// Render the header.
get_header();

// Render the search content.
$babes_search->render_search();

// Render the sidebar and footer.
get_sidebar();
get_footer();
