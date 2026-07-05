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

    public function render_settings_page()
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        $options = $this->settings->all();
        include WOOSHIPPY_PATH . 'admin/views/settings-page.php';
    }
}

