<?php
/**
 * Class to handle the Page template.
 *
 * @package babes
 */

class Babes_Page {

	/**
	 * Render the page content.
	 */
	public function render_page_content() {
		while ( have_posts() ) :
			the_post();

			// Include the content template for the page.
			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
	}

	/**
	 * Render the page template.
	 */
	public function render_page() {
		?>
		<main id="primary" class="site-main">
			<?php if ( is_active_sidebar( 'left-sidebar' ) ) :  
				get_template_part( 'template-parts/sidebar', 'left' ); 
			endif; 

			$this->render_page_content();

			if ( is_active_sidebar( 'right-sidebar' ) ) :  
				get_template_part( 'template-parts/sidebar', 'right' );
            endif; 
            ?>
		</main><!-- #main -->
		<?php
	}
}
