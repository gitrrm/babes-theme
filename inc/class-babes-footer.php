<?php
/**
 * Class to handle Footer template.
 *
 * @package babes
 */

class Babes_Footer {

	/**
	 * Render the footer site info.
	 */
	public function render_site_info() {
		?>
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'babes' ) ); ?>">
				<?php
				/* translators: %s: CMS name, i.e. WordPress. */
				printf( esc_html__( 'Proudly powered by %s', 'babes' ), 'WordPress' );
				?>
			</a>
			<span class="sep"> | </span>
				<?php
				/* translators: 1: Theme name, 2: Theme author. */
				printf( esc_html__( 'Theme: %1$s by %2$s.', 'babes' ), 'babes', '<a href="https://triloke.com/">triloke</a>' );
				?>
		</div><!-- .site-info -->
		<?php
	}

	/**
	 * Render the entire footer section.
	 */
	public function render_footer() {
		if ( is_active_sidebar( 'before-footer' ) ) :  
			get_template_part( 'template-parts/sidebar', 'before-footer' ); 
		endif;
		?>
		<footer id="colophon" class="site-footer">
			<?php $this->render_site_info(); ?>
		</footer><!-- #colophon -->
		</div><!-- #page -->

		<?php wp_footer(); ?>

		</body>
		</html>
		<?php
	}
}
