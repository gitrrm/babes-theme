<?php
/**
 * Class to handle Comments template.
 *
 * @package babes
 */

class Babes_Comments {

	/**
	 * Render the comments title.
	 */
	public function render_comments_title() {
		$babes_comment_count = get_comments_number();

		if ( '1' === $babes_comment_count ) {
			printf(
				esc_html__( 'One thought on &ldquo;%1$s&rdquo;', 'babes' ),
				'<span>' . wp_kses_post( get_the_title() ) . '</span>'
			);
		} else {
			printf(
				esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $babes_comment_count, 'comments title', 'babes' ) ),
				number_format_i18n( $babes_comment_count ),
				'<span>' . wp_kses_post( get_the_title() ) . '</span>'
			);
		}
	}

	/**
	 * Render the list of comments.
	 */
	public function render_comments_list() {
		if ( have_comments() ) {
			?>
			<h2 class="comments-title"><?php $this->render_comments_title(); ?></h2><!-- .comments-title -->
			<?php
			the_comments_navigation();
			?>
			<ol class="comment-list">
				<?php
				wp_list_comments(
					array(
						'style'      => 'ol',
						'short_ping' => true,
					)
				);
				?>
			</ol><!-- .comment-list -->
			<?php
			the_comments_navigation();
		}
	}

	/**
	 * Render the no comments message.
	 */
	public function render_no_comments_message() {
		if ( ! comments_open() && have_comments() ) {
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'babes' ); ?></p>
			<?php
		}
	}

	/**
	 * Render the comment form.
	 */
	public function render_comment_form() {
		comment_form();
	}

	/**
	 * Render the entire comments section.
	 */
	public function render_comments_section() {
		// If the current post is protected by a password and the visitor has not yet entered the password, return early.
		if ( post_password_required() ) {
			return;
		}
		?>
		<div id="comments" class="comments-area">
			<?php
			$this->render_comments_list();
			$this->render_no_comments_message();
			$this->render_comment_form();
			?>
		</div><!-- #comments -->
		<?php
	}
}
