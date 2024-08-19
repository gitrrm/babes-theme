<?php

class Babe_Header_Footer_Manager {

    public function __construct() {
        add_action('init', [$this, 'register_post_types_and_taxonomies']);
        add_action('add_meta_boxes', [$this, 'add_meta_boxes']);
        add_action('save_post', [$this, 'save_meta_box_data']);
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('elementor/init', [$this, 'register_elementor_support']);
    }

    // Register Custom Post Type and Taxonomies
    public function register_post_types_and_taxonomies() {
        // Register Custom Post Type for Header and Footer
        register_post_type('babes_header_footer', [
            'labels' => [
                'name' => __('Header & Footer Templates', 'babes'),
                'singular_name' => __('Header & Footer Template', 'babes'),
            ],
            'public' => true,
            'supports' => ['title', 'editor'],
            'has_archive' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 20,
            'menu_icon' => 'dashicons-portfolio',
            'rewrite' => ['slug' => 'header-footer-templates'],
            'show_in_rest' => true, // Enable Gutenberg editor and REST API
            'template' => ['full-width'], // Full-width template
        ]);

        // Register Custom Taxonomy for Header and Footer Categories
        register_taxonomy('header_footer_category', 'babes_header_footer', [
            'labels' => [
                'name' => __('Categories', 'babes'),
                'singular_name' => __('Category', 'babes'),
            ],
            'hierarchical' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => ['slug' => 'header-footer-category'],
        ]);

        // Add custom categories
        wp_insert_term('Header', 'header_footer_category');
        wp_insert_term('Footer', 'header_footer_category');
    }

    // Register Elementor Support
    public function register_elementor_support() {
        if (defined('ELEMENTOR_VERSION')) {
            add_post_type_support('babes_header_footer', 'elementor');
        }
    }

    // Add Meta Boxes
    public function add_meta_boxes() {
        add_meta_box('header_footer_options', __('Header & Footer Options', 'babes'), [$this, 'render_meta_box'], 'babes_header_footer', 'side', 'default');
    }

    // Render Meta Box Content
    public function render_meta_box($post) {
        $assign_to = get_post_meta($post->ID, '_assign_to', true);
        ?>
        <p>
            <label for="assign_to"><?php _e('Assign To:', 'babes'); ?></label>
            <select name="assign_to" id="assign_to" class="postbox">
                <option value="entire_site" <?php selected($assign_to, 'entire_site'); ?>><?php _e('Entire Site', 'babes'); ?></option>
                <option value="specific_page" <?php selected($assign_to, 'specific_page'); ?>><?php _e('Specific Page', 'babes'); ?></option>
                <option value="specific_post" <?php selected($assign_to, 'specific_post'); ?>><?php _e('Specific Post', 'babes'); ?></option>
            </select>
        </p>
        <?php
    }

    // Save Meta Box Data
    public function save_meta_box_data($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!isset($_POST['post_type']) || $_POST['post_type'] !== 'babes_header_footer') {
            return;
        }

        if (!isset($_POST['assign_to'])) {
            return;
        }

        $assign_to = sanitize_text_field($_POST['assign_to']);
        update_post_meta($post_id, '_assign_to', $assign_to);
    }

    // Add Admin Menu Page
    public function add_admin_menu() {
        add_theme_page(
            __('Header & Footer Manager', 'babes'),
            __('Header & Footer Manager', 'babes'),
            'manage_options',
            'header-footer-manager',
            [$this, 'render_admin_page']
        );
    }

    // Render Admin Page
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

    // Display Template List
    private function display_template_list($type) {
        $args = [
            'post_type' => 'babes_header_footer',
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
}

// Initialize the Header Footer Manager
new Babe_Header_Footer_Manager();
