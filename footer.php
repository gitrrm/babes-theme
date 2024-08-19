<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package babes
 */

// Include the Footer class.
require get_template_directory() . '/inc/class-babes-footer.php';

// Instantiate the Footer class.
$babes_footer = new Babes_Footer();

// Render the Footer section.
$babes_footer->render_footer();
