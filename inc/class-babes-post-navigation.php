<?php
/**
 * Class to handle post navigation.
 *
 * @package babes
 */

class Babes_Post_Navigation {

	/**
	 * Render the post navigation.
	 */
	public function render_post_navigation() {
		?>
		<nav class="post-navigation">
			<div class="nav-links">
				<?php
				the_post_navigation(
					array(
						'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'babes' ) . '</span> <span class="nav-title">%title</span>',
						'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'babes' ) . '</span> <span class="nav-title">%title</span>',
					)
				);
				?>
			</div><!-- .nav-links -->
		</nav><!-- .post-navigation -->
		<?php
	}
}
