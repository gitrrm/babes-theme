<?php
/**
 * Class to handle Archive page content.
 *
 * @package babes
 */

class Babes_Archive_Page {

	public function __construct() {
		// Constructor if needed.
	}

	/**
	 * Render the archive header.
	 */
	public function render_header() {
		if ( have_posts() ) : ?>
			<header class="page-header">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->
		<?php
		endif;
	}

	/**
	 * Render the archive content.
	 */
	public function render_content() {
		if ( have_posts() ) {
			/* Start the Loop */
			while ( have_posts() ) {
				the_post();
				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_type() );
			}

			// Display navigation to next/previous set of posts.
			the_posts_navigation();
		} else {
			get_template_part( 'template-parts/content', 'none' );
		}
	}

	/**
	 * Render the full archive page.
	 */
	public function render_archive_page() {
		?>
		<main id="primary" class="site-main">
			<?php if ( is_active_sidebar( 'left-sidebar' ) ) :  
				get_template_part( 'template-parts/sidebar', 'left' ); 
			endif; 

			$this->render_header();
			$this->render_content();

			if ( is_active_sidebar( 'right-sidebar' ) ) :  
				get_template_part( 'template-parts/sidebar', 'right' );
            endif; 
            ?>
		</main><!-- #main -->
		<?php 
		/*if ( is_active_sidebar( 'before-footer' ) ) :  
			get_template_part( 'template-parts/sidebar', 'before-footer' ); 
		endif;*/
	}
}
