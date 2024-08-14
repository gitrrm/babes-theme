<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package babes
 */

 if ( is_active_sidebar( 'right-sidebar' ) ) : ?>
    <aside id="right-sidebar" class="widget-area">
        <?php dynamic_sidebar( 'right-sidebar' ); ?>
    </aside>
<?php endif; ?>

<?php if ( is_active_sidebar( 'left-sidebar' ) ) : ?>
    <aside id="left-sidebar" class="widget-area">
        <?php dynamic_sidebar( 'left-sidebar' ); ?>
    </aside>
<?php endif; ?>

