<?php
/**
 * Class to handle Header template.
 *
 * @package babes
 */

class Babes_Header {

	/**
	 * Render the head section.
	 */
	public function render_head() {
		?>
		<!doctype html>
		<html <?php language_attributes(); ?>>
		<head>
			<meta charset="<?php bloginfo( 'charset' ); ?>">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<link rel="profile" href="https://gmpg.org/xfn/11">

			<?php wp_head(); ?>
		</head>

		<body <?php body_class(); ?>>
		<?php wp_body_open(); ?>
		<div id="page" class="site">
			<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'babes' ); ?></a>
			<?php
	}

	/**
	 * Render the site branding section.
	 */
	public function render_site_branding() {
		?>
		<header id="masthead" class="site-header">
			<div class="site-branding">
				<?php
				the_custom_logo();
				if ( is_front_page() && is_home() ) :
					?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php
				else :
					?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php
				endif;
				$babes_description = get_bloginfo( 'description', 'display' );
				if ( $babes_description || is_customize_preview() ) :
					?>
					<p class="site-description"><?php echo $babes_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
				<?php endif; ?>
			</div><!-- .site-branding -->
		<?php
	}

	/**
	 * Render the main navigation.
	 */
	public function render_navigation() {
		?>
		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'babes' ); ?></button>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary_menu',
					'menu_id'        => 'primary_menu',
				)
			);
			?>
		</nav><!-- #site-navigation -->
		<?php
	}

	/**
	 * Render the entire header section.
	 */
	public function render_header() {
		$this->render_head();
		$this->render_site_branding();
		$this->render_navigation();
		?>
		</header><!-- #masthead -->
		<?php
	}
}
