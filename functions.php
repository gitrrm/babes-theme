<?php
/**
 * babes functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package babes
 */

if ( ! defined( 'BABES_VERSION' ) ) {
	define( 'BABES_VERSION', '1.0.0' );
}

function babes_setup() {
	
	load_theme_textdomain( 'babes', get_template_directory() . '/languages' );
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );

	register_nav_menus(
		array(
			'main-menu' => esc_html__( 'Primary Menu - Header', 'babes' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'babes_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'babes_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function babes_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'babes_content_width', 640 );
}
add_action( 'after_setup_theme', 'babes_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function babes_widgets_init() {
	// Register Right Sidebar
	register_sidebar(
		array(
			'name'          => esc_html__( 'Right Sidebar', 'babes' ),
			'id'            => 'right-sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'babes' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	// Register Left Sidebar
	register_sidebar(
		array(
			'name'          => esc_html__( 'Left Sidebar', 'babes' ),
			'id'            => 'left-sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'babes' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'babes_widgets_init' );


/**
 * Enqueue scripts and styles.
 */
function babes_scripts() {
	wp_enqueue_style( 'bootstrap-style',get_template_directory_uri() . '/assets/css/bootstrap.min.css', [], false, 'all');
	wp_enqueue_style( 'babes-style', get_stylesheet_uri(), array(), BABES_VERSION );
	wp_style_add_data( 'babes-style', 'rtl', 'replace' );

	wp_enqueue_script( 'babes-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), BABES_VERSION, true );
	wp_enqueue_script( 'bootstrap-script', get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js', array(), false, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'babes_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}
