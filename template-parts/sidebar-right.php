<?php
/**
 * The template for displaying the right sidebar
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package babes
 */

if ( is_active_sidebar( 'right-sidebar' ) ) : ?>
    <aside id="right-sidebar" class="widget-area">
        <?php dynamic_sidebar( 'right-sidebar' ); ?>
    </aside><!-- #right-sidebar -->
<?php endif; ?>
