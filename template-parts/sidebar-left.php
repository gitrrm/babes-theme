<?php
/**
 * The template for displaying the left sidebar
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package babes
 */

if ( is_active_sidebar( 'left-sidebar' ) ) : ?>
    <aside id="left-sidebar" class="widget-area">
        <?php dynamic_sidebar( 'left-sidebar' ); ?>
    </aside><!-- #left-sidebar -->
<?php endif; ?>
