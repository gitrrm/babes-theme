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
		<div class="site-info container">
			<div class="col-3">
				<?php echo esc_html__( '&copy; Copyright ', 'babes' ) . date("Y"); ?>
			</div>
			<div class="col-6">
				<nav id="site-info-navigation" class="site-info-navigation">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer_site_info_menu',
							'menu_id'        => 'footer_site_info_menu',
						)
					);
					?>
				</nav><!-- #site-info-navigation -->
			</div>
			<div class="col-3">
				<h2>Social media icons</h2>
			</div>
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
