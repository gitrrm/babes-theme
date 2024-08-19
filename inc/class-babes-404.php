<?php
/**
 * Class to handle 404 page content.
 *
 * @package babes
 */

class Babes_404_Page {

	public function __construct() {
		// Constructor if needed.
	}

	/**
	 * Render the 404 page header.
	 */
	public function render_header() {
		?>
		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'babes' ); ?></h1>
		</header><!-- .page-header -->
		<?php
	}

	/**
	 * Render the 404 page content.
	 */
	public function render_content() {
		?>
		<div class="page-content">
			<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'babes' ); ?></p>

			<?php
			get_search_form();

			the_widget( 'WP_Widget_Recent_Posts' );
			?>

			<div class="widget widget_categories">
				<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'babes' ); ?></h2>
				<ul>
					<?php
					wp_list_categories(
						array(
							'orderby'    => 'count',
							'order'      => 'DESC',
							'show_count' => 1,
							'title_li'   => '',
							'number'     => 10,
						)
					);
					?>
				</ul>
			</div><!-- .widget -->

			<?php
			$babes_archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'babes' ), convert_smilies( ':)' ) ) . '</p>';
			the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$babes_archive_content" );

			the_widget( 'WP_Widget_Tag_Cloud' );
			?>

		</div><!-- .page-content -->
		<?php
	}

	/**
	 * Render the 404 page.
	 */
	public function render_404_page() {
		?>
		<section class="error-404 not-found">
			<?php
			$this->render_header();
			$this->render_content();
			?>
		</section><!-- .error-404 -->
		<?php
	}
}
