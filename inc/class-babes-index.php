<?php
/**
 * Class to handle the Index template.
 *
 * @package babes
 */

class Babes_Index {

	/**
	 * Render the main content loop.
	 */
	public function render_content_loop() {
		if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) :
				?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
				<?php
			endif;

			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				// Include the Post-Type-specific template for the content.
				get_template_part( 'template-parts/content', get_post_type() );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
	}

	/**
	 * Render the index page.
	 */
	public function render_index() {
		?>
		<main id="primary" class="site-main">
			<?php if ( is_active_sidebar( 'left-sidebar' ) ) :  
				get_template_part( 'template-parts/sidebar', 'left' ); 
			endif; 

			$this->render_content_loop();

			if ( is_active_sidebar( 'right-sidebar' ) ) :  
				get_template_part( 'template-parts/sidebar', 'right' );
            endif; 
            ?>
		</main><!-- #main -->
		<?php
	}
}
