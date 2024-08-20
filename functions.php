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

class Babes_Theme {

	public function __construct() {
	    add_action( 'after_setup_theme', [ $this, 'setup' ] );
	    add_action( 'after_setup_theme', [ $this, 'set_content_width' ], 0 );
	    add_action( 'widgets_init', [ $this, 'widgets_init' ] );
	    add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

	    // add_action( 'after_setup_theme', [ $this, 'check_elementor_dependency' ] );

	    $this->load_dependencies();
	}



	public function setup() {
		load_theme_textdomain( 'babes', get_template_directory() . '/languages' );

		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );

		register_nav_menus(
			array(
				'primary_menu' => esc_html__( 'Primary Menu - Header', 'babes' ),
				'footer_site_info_menu' => esc_html__( 'Footer Site Info Menu', 'babes' ),
			)
		);

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

		add_theme_support( 'customize-selective-refresh-widgets' );

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

	public function set_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'babes_content_width', 640 );
	}

	public function widgets_init() {
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
		register_sidebar(
			array(
				'name'          => esc_html__( 'Before Footer', 'babes' ),
				'id'            => 'before-footer',
				'description'   => esc_html__( 'Add before footer widgets here.', 'babes' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);
	}

	public function enqueue_scripts() {
		wp_enqueue_style( 'bootstrap-style', get_template_directory_uri() . '/assets/css/bootstrap.min.css', [], false, 'all');
		wp_enqueue_style( 'babes-style', get_stylesheet_uri(), array(), BABES_VERSION );
		wp_style_add_data( 'babes-style', 'rtl', 'replace' );

		wp_enqueue_script( 'babes-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), BABES_VERSION, true );
		wp_enqueue_script( 'bootstrap-script', get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js', array(), false, true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	private function load_dependencies() {
		require get_template_directory() . '/inc/template-tags.php';
		require get_template_directory() . '/inc/template-functions.php';
		require get_template_directory() . '/inc/customizer.php';

		if ( defined( 'JETPACK__VERSION' ) ) {
			require get_template_directory() . '/inc/jetpack.php';
		}

		if ( class_exists( 'WooCommerce' ) ) {
			require get_template_directory() . '/inc/woocommerce.php';
		}
		// Include the Plugin_Dependencies class
		require_once get_template_directory() . '/inc/class-plugin-dependencies.php';
		// require_once get_template_directory() . '/inc/header-footer-manager.php';
		// require_once get_template_directory() . '/inc/class-babes-header-footer-manager.php';
		require_once get_template_directory() . '/inc/class-babes-theme-option.php';

	}
	
	/*public function check_elementor_dependency() {
        if ( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', [ $this, 'elementor_dependency_notice' ] );
            add_action( 'admin_init', [ $this, 'install_elementor_plugin' ] );
        }
    }
    public function elementor_dependency_notice() {
        ?>
        <div class="notice notice-error">
            <p><?php esc_html_e( 'This theme requires the Elementor plugin to be installed and activated.', 'babes' ); ?></p>
            <p><a href="<?php echo esc_url( admin_url( 'themes.php?page=install-elementor' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Install Elementor', 'babes' ); ?></a></p>
        </div>
        <?php
    }
    public function install_elementor_plugin() {
        if ( isset( $_GET['page'] ) && $_GET['page'] === 'install-elementor' ) {
            $this->install_plugin_from_theme();
        }
    }
    private function install_plugin_from_theme() {
        // Load necessary WordPress files
        if ( ! function_exists( 'request_filesystem_credentials' ) ) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
        }
        if ( ! function_exists( 'download_url' ) ) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
        }
        if ( ! class_exists( 'Plugin_Upgrader' ) ) {
            require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        }

        // Set up the filesystem
        $url = wp_nonce_url( admin_url( 'themes.php?page=install-elementor' ), 'install-plugin_elementor' );
        $creds = request_filesystem_credentials( $url, '', false, false, array() );

        // If we don't have credentials, stop
        if ( ! WP_Filesystem( $creds ) ) {
            return false;
        }

        // Set up the plugin installer
        $upgrader = new Plugin_Upgrader();
        $zip_file = get_template_directory() . '/inc/plugins/elementor.zip';

        // Install the plugin from the theme folder
        $upgrader->install( $zip_file );

        // Activate the plugin
        activate_plugin( 'elementor/elementor.php' );

        // Redirect to the plugins page
        wp_redirect( admin_url( 'plugins.php?plugin_status=all&paged=1&s=' ) );
        exit;
    }*/

}

new Babes_Theme();
