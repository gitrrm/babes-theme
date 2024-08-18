<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package babes
 */

get_header();

// Include the 404 class.
require get_template_directory() . '/inc/class-babes-404.php';

// Instantiate the 404 page class.
$babes_404_page = new Babes_404_Page();

?>

<!-- Render the 404 page content. -->

<main id="primary" class="site-main">
	<?php $babes_404_page->render_404_page(); ?>
</main><!-- #main -->

<?php
get_footer();
