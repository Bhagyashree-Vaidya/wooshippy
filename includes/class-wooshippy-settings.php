<?php
/**
 * Plugin settings.
 *
 * @package Wooshippy
 */

if (!defined('ABSPATH')) {
    exit;
}

class Wooshippy_Settings
{
    const OPTION_GROUP = 'wooshippy_options_group';
    const OPTION_NAME = 'wooshippy_options';

    private $defaults = [
        'api_base_url' => '',
        'api_token' => '',
        'default_carrier' => '',
        'tracking_page_url' => '',
        'cache_minutes' => 15,
        'enable_customer_display' => '1',
    ];

    public function register()
    {
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function register_settings()
    {
        register_setting(
            self::OPTION_GROUP,
            self::OPTION_NAME,
            [
                'type' => 'array',
                'sanitize_callback' => [$this, 'sanitize_options'],
                'default' => $this->defaults,
            ]
        );
    }

    public function sanitize_options($input)
    {
        $input = is_array($input) ? $input : [];

        return [
            'api_base_url' => isset($input['api_base_url']) ? esc_url_raw(trim($input['api_base_url'])) : '',
            'api_token' => isset($input['api_token']) ? sanitize_text_field($input['api_token']) : '',
            'default_carrier' => isset($input['default_carrier']) ? sanitize_text_field($input['default_carrier']) : '',
            'tracking_page_url' => isset($input['tracking_page_url']) ? esc_url_raw(trim($input['tracking_page_url'])) : '',
            'cache_minutes' => isset($input['cache_minutes']) ? max(0, absint($input['cache_minutes'])) : 15,
            'enable_customer_display' => !empty($input['enable_customer_display']) ? '1' : '0',
        ];
    }

    public function all()
    {
        $options = get_option(self::OPTION_NAME, []);

        return wp_parse_args(is_array($options) ? $options : [], $this->defaults);
    }

    public function get($key, $fallback = '')
    {
        $options = $this->all();

        return array_key_exists($key, $options) ? $options[$key] : $fallback;
    }
}

