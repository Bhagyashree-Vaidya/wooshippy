<?php
/**
 * Admin UI.
 *
 * @package Wooshippy
 */

if (!defined('ABSPATH')) {
    exit;
}

class Wooshippy_Admin
{
    private $settings;

    public function __construct(Wooshippy_Settings $settings)
    {
        $this->settings = $settings;
    }

    public function register()
    {
        add_action('admin_menu', [$this, 'add_settings_page']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_settings_assets']);
        add_action('admin_notices', [$this, 'maybe_show_woocommerce_notice']);
    }

    public function maybe_show_woocommerce_notice()
    {
        if (!current_user_can('activate_plugins') || class_exists('WooCommerce')) {
            return;
        }

        echo '<div class="notice notice-warning"><p>' . esc_html__('Wooshippy is active. Install and activate WooCommerce to use order tracking fields; the public tracking shortcode can still be used without WooCommerce.', 'wooshippy') . '</p></div>';
    }

    public function add_settings_page()
    {
        add_options_page(
            __('Wooshippy', 'wooshippy'),
            __('Wooshippy', 'wooshippy'),
            'manage_options',
            'wooshippy',
            [$this, 'render_settings_page']
        );
    }

    public function enqueue_settings_assets($hook)
    {
        if ('settings_page_wooshippy' !== $hook) {
            return;
        }

        wp_enqueue_script('wp-api-fetch');
        wp_add_inline_script(
            'wp-api-fetch',
            "window.wooshippyAdmin = { endpoint: '" . esc_js(rest_url(Wooshippy_Rest_Controller::NAMESPACE . '/test-lookup')) . "', nonce: '" . esc_js(wp_create_nonce('wp_rest')) . "' };"
        );
    }

    public function render_settings_page()
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        $options = $this->settings->all();
        include WOOSHIPPY_PATH . 'admin/views/settings-page.php';
    }
}

