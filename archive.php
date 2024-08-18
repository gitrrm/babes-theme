<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package babes
 */

get_header();

// Include the Archive class.
require get_template_directory() . '/inc/class-babes-archive.php';

// Instantiate the Archive Page class.
$babes_archive_page = new Babes_Archive_Page();

// Render the Archive page content.
$babes_archive_page->render_archive_page();

// get_sidebar();
get_footer();
