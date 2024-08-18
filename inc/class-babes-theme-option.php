<?php

class Babes_Theme_Options {

    public function __construct() {
        add_action('admin_menu', [$this, 'add_theme_options_page']);
    }

    public function add_theme_options_page() {
        add_menu_page(
            __('Babes Options', 'babes'),  // Page title
            __('Babes Options', 'babes'),  // Menu title
            'manage_options',              // Capability
            'babes-theme-options',         // Menu slug
            [$this, 'render_options_page'], // Callback function
            '',                             // Icon URL (optional)
            61                              // Position
        );
    }

    public function render_options_page() {
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Babes Theme Options', 'babes'); ?></h1>
            <h2 class="nav-tab-wrapper">
                <a href="#dashboard" class="nav-tab nav-tab-active"><?php esc_html_e('Dashboard', 'babes'); ?></a>
                <a href="#header" class="nav-tab"><?php esc_html_e('Header', 'babes'); ?></a>
                <a href="#footer" class="nav-tab"><?php esc_html_e('Footer', 'babes'); ?></a>
                <a href="#branding" class="nav-tab"><?php esc_html_e('Branding', 'babes'); ?></a>
                <a href="#seo" class="nav-tab"><?php esc_html_e('SEO', 'babes'); ?></a>
            </h2>

            <div id="dashboard" class="tab-content">
                <?php $this->dashboard_tab_content(); ?>
            </div>

            <div id="header" class="tab-content" style="display:none;">
                <?php $this->header_tab_content(); ?>
            </div>

            <div id="footer" class="tab-content" style="display:none;">
                <?php $this->footer_tab_content(); ?>
            </div>

            <div id="branding" class="tab-content" style="display:none;">
                <?php $this->branding_tab_content(); ?>
            </div>

            <div id="seo" class="tab-content" style="display:none;">
                <?php $this->seo_tab_content(); ?>
            </div>
        </div>
        <?php
    }

    private function dashboard_tab_content() {
        echo '<p>' . esc_html__('Welcome to the Babes Theme Options Dashboard.', 'babes') . '</p>';
    }

    private function header_tab_content() {
        echo '<p>' . esc_html__('Customize your site header.', 'babes') . '</p>';
    }

    private function footer_tab_content() {
        echo '<p>' . esc_html__('Customize your site footer.', 'babes') . '</p>';
    }

    private function branding_tab_content() {
        echo '<p>' . esc_html__('Manage your site branding.', 'babes') . '</p>';
    }

    private function seo_tab_content() {
        echo '<p>' . esc_html__('Configure your site SEO settings.', 'babes') . '</p>';
    }

}

new Babes_Theme_Options();
