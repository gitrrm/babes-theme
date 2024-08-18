<?php
/**
 * Class to handle single post template.
 *
 * @package babes
 */

class Babes_Single {

	/**
	 * Render the single post content.
	 */
	public function render_single_post() {
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

			// Instantiate and render the post navigation.
			$navigation = new Babes_Post_Navigation();
			$navigation->render_post_navigation();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
	}

	/**
	 * Render the single post template.
	 */
	public function render_single() {
		?>
		<main id="primary" class="site-main">
			<?php if ( is_active_sidebar( 'left-sidebar' ) ) :  
				get_template_part( 'template-parts/sidebar', 'left' ); 
			endif; 

			$this->render_single_post();

			if ( is_active_sidebar( 'right-sidebar' ) ) :  
				get_template_part( 'template-parts/sidebar', 'right' );
            endif; 
            ?>
		</main><!-- #main -->
		<?php
	}
}
