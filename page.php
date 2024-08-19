<?php
/**
 * The template for displaying all pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package babes
 */

// Include the Page class.
require get_template_directory() . '/inc/class-babes-page.php';

// Instantiate the Page class.
$babes_page = new Babes_Page();

// Render the header.
get_header();

// Render the page content.
$babes_page->render_page();

// Render the footer.
get_footer();
