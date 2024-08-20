<?php

class Plugin_Dependencies {

    private $plugins;

    public function __construct() {
        $this->plugins = [
            'elementor' => [
                'name' => 'Elementor',
                'slug' => 'elementor',
                'file' => 'elementor/elementor.php',
                'source' => get_template_directory() . '/inc/plugins/elementor.zip'
            ],
            'revslider' => [
                'name' => 'Revolution Slider',
                'slug' => 'revslider',
                'file' => 'revslider/revslider.php',
                'source' => get_template_directory() . '/inc/plugins/revslider.zip'
            ],
            // Add more plugins here
        ];

        add_action('after_setup_theme', [$this, 'check_dependencies']);
        add_action('admin_menu', [$this, 'add_admin_page']);
    }

    public function check_dependencies() {
        if (!function_exists('is_plugin_active')) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        foreach ($this->plugins as $plugin) {
            if (!is_plugin_active($plugin['file'])) {
                add_action('admin_notices', function() use ($plugin) {
                    $this->dependency_notice($plugin['name'], $plugin['slug']);
                });
            }
        }
    }

    public function dependency_notice($plugin_name, $plugin_slug) {
        ?>
        <div class="notice notice-error">
            <p><?php echo esc_html("This theme requires the {$plugin_name} plugin to be installed and activated.", 'babes'); ?></p>
            <p><a href="<?php echo esc_url(admin_url("admin.php?page=install-plugin&plugin={$plugin_slug}")); ?>" class="button button-primary"><?php esc_html_e("Install {$plugin_name}", 'babes'); ?></a></p>
        </div>
        <?php
    }

    public function add_admin_page() {
        add_submenu_page(
            'themes.php',
            __('Install Plugin', 'babes'),
            __('Install Plugin', 'babes'),
            'manage_options',
            'install-plugin',
            [$this, 'render_admin_page']
        );
    }

    public function render_admin_page() {
        $plugin_slug = isset($_GET['plugin']) ? sanitize_key($_GET['plugin']) : '';

        if (!current_user_can('install_plugins')) {
            echo '<div class="error"><p>' . esc_html__('You do not have permission to install plugins.', 'babes') . '</p></div>';
            return;
        }

        if ($plugin_slug && isset($this->plugins[$plugin_slug])) {
            $this->install_plugin($this->plugins[$plugin_slug]);
        }

        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Install Plugin', 'babes'); ?></h1>
            <?php if ($plugin_slug && isset($this->plugins[$plugin_slug])): ?>
                <p><?php esc_html_e('Installing plugin...', 'babes'); ?></p>
            <?php else: ?>
                <p><?php esc_html_e('No plugin specified or plugin not found.', 'babes'); ?></p>
            <?php endif; ?>
        </div>
        <?php
    }

    public function install_plugin($plugin) {
        if (!isset($plugin['slug'], $plugin['source'])) {
            return;
        }

        if (!function_exists('request_filesystem_credentials')) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
        }
        if (!class_exists('Plugin_Upgrader')) {
            require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        }

        $creds = request_filesystem_credentials(admin_url('admin.php?page=install-plugin'), '', false, false, array());

        if (!WP_Filesystem($creds)) {
            return false;
        }

        $upgrader = new Plugin_Upgrader();
        $upgrader->install($plugin['source']);

        $plugin_file = $plugin['file'];
        activate_plugin($plugin_file);

        wp_redirect(admin_url('plugins.php?plugin_status=all&paged=1&s='));
        exit;
    }
}

// Initialize the plugin dependencies class
new Plugin_Dependencies();
