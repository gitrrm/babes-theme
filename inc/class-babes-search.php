<?php
/**
 * Class to handle the Search template.
 *
 * @package babes
 */

class Babes_Search {

	/**
	 * Render the search results header.
	 */
	public function render_search_header() {
		?>
		<header class="page-header">
			<h1 class="page-title">
				<?php
				/* translators: %s: search query. */
				printf( esc_html__( 'Search Results for: %s', 'babes' ), '<span>' . get_search_query() . '</span>' );
				?>
			</h1>
		</header><!-- .page-header -->
		<?php
	}

	/**
	 * Render the search results content.
	 */
	public function render_search_content() {
		if ( have_posts() ) :
			$this->render_search_header();

			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				// Include the Post-Type-specific template for the content.
				get_template_part( 'template-parts/content', 'search' );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
	}

	/**
	 * Render the search template.
	 */
	public function render_search() {
		?>
		<main id="primary" class="site-main">
			<?php
			$this->render_search_content();
			?>
		</main><!-- #main -->
		<?php
	}
}
