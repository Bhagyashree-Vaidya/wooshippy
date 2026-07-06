<?php
/**
 * Public shortcodes.
 *
 * @package Wooshippy
 */

if (!defined('ABSPATH')) {
    exit;
}

class Wooshippy_Shortcodes
{
    public function register()
    {
        add_action('wp_enqueue_scripts', [$this, 'register_assets']);
        add_shortcode('shipment_tracking', [$this, 'render_tracking_shortcode']);
    }

    public function register_assets()
    {
        wp_register_style(
            'wooshippy-tracking',
            WOOSHIPPY_URL . 'public/css/tracking.css',
            [],
            WOOSHIPPY_VERSION
        );

        wp_register_script(
            'wooshippy-tracking',
            WOOSHIPPY_URL . 'public/js/tracking.js',
            [],
            WOOSHIPPY_VERSION,
            true
        );
    }

    public function render_tracking_shortcode($atts)
    {
        $atts = shortcode_atts(
            [
                'title' => __('Track your shipment', 'wooshippy'),
            ],
            $atts,
            'shipment_tracking'
        );

        wp_enqueue_style('wooshippy-tracking');
        wp_enqueue_script('wooshippy-tracking');
        wp_localize_script(
            'wooshippy-tracking',
            'wooshippyTracking',
            [
                'endpoint' => esc_url_raw(rest_url(Wooshippy_Rest_Controller::NAMESPACE . '/track')),
                'nonce' => wp_create_nonce('wp_rest'),
                'messages' => [
                    'missingTrackingNumber' => __('Enter a tracking number.', 'wooshippy'),
                    'requestFailed' => __('Tracking lookup failed. Please try again.', 'wooshippy'),
                    'loading' => __('Loading tracking details...', 'wooshippy'),
                ],
            ]
        );

        ob_start();
        include WOOSHIPPY_PATH . 'public/views/tracking-form.php';

        return ob_get_clean();
    }
}

