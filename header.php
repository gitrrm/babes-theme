<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package babes
 */

// Include the Header class.
require get_template_directory() . '/inc/class-babes-header.php';

// Instantiate the Header class.
$babes_header = new Babes_Header();

// Render the Header section.
$babes_header->render_header();
