<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package babes
 */

// Include the Comments class.
require get_template_directory() . '/inc/class-babes-comments.php';

// Instantiate the Comments class.
$babes_comments = new Babes_Comments();

// Render the Comments section.
$babes_comments->render_comments_section();
