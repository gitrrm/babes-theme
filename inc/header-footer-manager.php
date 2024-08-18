<?php

class Header_Footer_Manager {

    public function __construct() {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('init', [$this, 'register_post_types']);
        add_action('admin_post_create_header_footer', [$this, 'handle_create_template']);
        add_action('admin_post_save_header_footer_settings', [$this, 'handle_save_settings']);
        add_filter('template_include', [$this, 'apply_header_template'], 99);
    }

    public function add_admin_menu() {
        add_theme_page(
            __('Header & Footer Manager', 'babes'),
            __('Header & Footer Manager', 'babes'),
            'manage_options',
            'header-footer-manager',
            [$this, 'render_admin_page']
        );
    }

    public function render_admin_page() {
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Header & Footer Manager', 'babes'); ?></h1>

            <!-- Create Header Form -->
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <?php wp_nonce_field('create_header_footer', 'header_footer_nonce'); ?>
                <input type="hidden" name="action" value="create_header_footer">
                <input type="hidden" name="header_footer_type" value="header">
                <h2><?php esc_html_e('Create New Header', 'babes'); ?></h2>
                <p>
                    <label for="header_footer_title"><?php esc_html_e('Title', 'babes'); ?></label>
                    <input type="text" name="header_footer_title" id="header_footer_title" required>
                </p>
                <p>
                    <input type="submit" value="<?php esc_html_e('Create Header', 'babes'); ?>" class="button button-primary">
                </p>
            </form>

            <!-- Create Footer Form -->
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <?php wp_nonce_field('create_header_footer', 'header_footer_nonce'); ?>
                <input type="hidden" name="action" value="create_header_footer">
                <input type="hidden" name="header_footer_type" value="footer">
                <h2><?php esc_html_e('Create New Footer', 'babes'); ?></h2>
                <p>
                    <label for="header_footer_title"><?php esc_html_e('Title', 'babes'); ?></label>
                    <input type="text" name="header_footer_title" id="header_footer_title" required>
                </p>
                <p>
                    <input type="submit" value="<?php esc_html_e('Create Footer', 'babes'); ?>" class="button button-primary">
                </p>
            </form>

            <!-- Display Existing Templates -->
            <?php
            $this->display_template_list('header');
            $this->display_template_list('footer');
            ?>
        </div>
        <?php
    }

    private function display_template_list($type) {
        $args = [
            'post_type' => 'elementor_library',
            'post_status' => 'publish',
            'meta_query' => [
                [
                    'key' => '_elementor_template_type',
                    'value' => $type,
                ],
            ],
        ];
        $query = new WP_Query($args);

        ?>
        <h2><?php echo esc_html(ucfirst($type)) . ' Templates'; ?></h2>
        <table class="wp-list-table widefat fixed">
            <thead>
                <tr>
                    <th><?php esc_html_e('Title', 'babes'); ?></th>
                    <th><?php esc_html_e('Actions', 'babes'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
                    <tr>
                        <td><?php the_title(); ?></td>
                        <td>
                            <a href="<?php echo esc_url(get_edit_post_link()); ?>" class="button"><?php esc_html_e('Edit', 'babes'); ?></a>
                            <a href="<?php echo esc_url(get_permalink()); ?>" class="button" target="_blank"><?php esc_html_e('View', 'babes'); ?></a>
                            <a href="<?php echo esc_url(admin_url('post.php?post=' . get_the_ID() . '&action=elementor')); ?>" class="button"><?php esc_html_e('Edit with Elementor', 'babes'); ?></a>
                            <a href="<?php echo esc_url(admin_url('admin-post.php?action=edit_header_footer_settings&post_id=' . get_the_ID())); ?>" class="button"><?php esc_html_e('Edit Settings', 'babes'); ?></a>
                        </td>
                    </tr>
                <?php endwhile; else: ?>
                    <tr>
                        <td colspan="2"><?php esc_html_e('No templates found', 'babes'); ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <?php
        wp_reset_postdata();
    }

    public function enqueue_scripts($hook) {
        if ($hook !== 'appearance_page_header-footer-manager') {
            return;
        }

        wp_enqueue_style('header-footer-manager-styles', get_template_directory_uri() . '/inc/css/header-footer-manager.css');
        wp_enqueue_script('header-footer-manager-scripts', get_template_directory_uri() . '/inc/js/header-footer-manager.js', ['jquery'], '1.0', true);
    }

    public function register_post_types() {
        register_post_type('elementor_library', [
            'label' => __('Elementor Templates', 'babes'),
            'public' => true,
            'supports' => ['title'],
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 20,
            'menu_icon' => 'dashicons-portfolio',
            'has_archive' => false,
            'rewrite' => ['slug' => 'elementor-library'],
        ]);
    }

    public function handle_create_template() {
        if (!isset($_POST['header_footer_nonce']) || !wp_verify_nonce($_POST['header_footer_nonce'], 'create_header_footer')) {
            wp_die(__('Nonce verification failed', 'babes'));
        }

        if (empty($_POST['header_footer_title']) || empty($_POST['header_footer_type'])) {
            wp_die(__('Title and type are required', 'babes'));
        }

        $title = sanitize_text_field($_POST['header_footer_title']);
        $type = sanitize_text_field($_POST['header_footer_type']);

        // Check if the post type already exists
        $existing_post = get_page_by_title($title, OBJECT, 'elementor_library');
        if ($existing_post) {
            wp_die(__('A template with this title already exists', 'babes'));
        }

        $post_id = wp_insert_post([
            'post_title' => $title,
            'post_type' => 'elementor_library',
            'post_status' => 'publish',
            'meta_input' => [
                '_elementor_template_type' => $type,
            ],
        ]);

        if (is_wp_error($post_id)) {
            wp_die(__('Failed to create template', 'babes'));
        }

        wp_redirect(admin_url('themes.php?page=header-footer-manager'));
        exit;
    }

    public function handle_save_settings() {
        if (!isset($_POST['header_footer_nonce']) || !wp_verify_nonce($_POST['header_footer_nonce'], 'save_header_footer_settings')) {
            wp_die(__('Nonce verification failed', 'babes'));
        }

        $post_id = intval($_POST['post_id']);
        $assign_to = sanitize_text_field($_POST['assign_to']);
        $display_sidebar = sanitize_text_field($_POST['display_sidebar']);

        update_post_meta($post_id, '_header_footer_assignment', $assign_to);
        update_post_meta($post_id, '_header_footer_display_sidebar', $display_sidebar);

        wp_redirect(admin_url('themes.php?page=header-footer-manager'));
        exit;
    }

    public function apply_header_template($template) {
        if (is_page() || is_single()) {
            global $post;

            $header_id = get_post_meta($post->ID, '_header_id', true);
            if ($header_id) {
                // Load the header template
                $template = get_post_meta($header_id, '_header_footer_template', true);
            }
        }

        return $template;
    }
}

// Initialize the Header Footer Manager class
new Header_Footer_Manager();
