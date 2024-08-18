<?php
/**
 * The template for displaying the right sidebar
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package babes
 */

if ( is_active_sidebar( 'before-footer' ) ) : ?>
    <section id="before-footer" class="widget-area">
        <?php dynamic_sidebar( 'before-footer' ); ?>
    </section><!-- #before-footer -->
<?php endif; ?>
