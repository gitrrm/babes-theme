<?php
/**
 * The main template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package babes
 */

// Include the Index class.
require get_template_directory() . '/inc/class-babes-index.php';

// Instantiate the Index class.
$babes_index = new Babes_Index();

// Render the header.
get_header();

// Render the index page.
$babes_index->render_index();

// Render the sidebar and footer.
// get_sidebar();
get_footer();
