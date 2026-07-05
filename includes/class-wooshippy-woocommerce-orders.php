<?php
/**
 * WooCommerce order integration.
 *
 * @package Wooshippy
 */

if (!defined('ABSPATH')) {
    exit;
}

class Wooshippy_WooCommerce_Orders
{
    const META_TRACKING_NUMBER = '_wooshippy_tracking_number';
    const META_CARRIER = '_wooshippy_carrier';

    private $tracking_service;
    private $settings;

    public function __construct(Wooshippy_Tracking_Service $tracking_service, Wooshippy_Settings $settings)
    {
        $this->tracking_service = $tracking_service;
        $this->settings = $settings;
    }

    public function register()
    {
        add_action('add_meta_boxes', [$this, 'add_meta_box']);
        add_action('save_post_shop_order', [$this, 'save_meta_box']);
        add_action('woocommerce_order_details_after_order_table', [$this, 'render_customer_tracking'], 20);
    }

    public function add_meta_box()
    {
        add_meta_box(
            'wooshippy_order_tracking',
            __('Wooshippy Tracking', 'wooshippy'),
            [$this, 'render_meta_box'],
            'shop_order',
            'side',
            'default'
        );
    }

    public function render_meta_box($post)
    {
        wp_nonce_field('wooshippy_save_order_tracking', 'wooshippy_order_tracking_nonce');

        $tracking_number = get_post_meta($post->ID, self::META_TRACKING_NUMBER, true);
        $carrier = get_post_meta($post->ID, self::META_CARRIER, true);

        include WOOSHIPPY_PATH . 'admin/views/order-tracking-meta-box.php';
    }

    public function save_meta_box($post_id)
    {
        if (!isset($_POST['wooshippy_order_tracking_nonce'])) {
            return;
        }

        if (!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['wooshippy_order_tracking_nonce'])), 'wooshippy_save_order_tracking')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_shop_order', $post_id) && !current_user_can('edit_post', $post_id)) {
            return;
        }

        $tracking_number = isset($_POST['wooshippy_tracking_number'])
            ? sanitize_text_field(wp_unslash($_POST['wooshippy_tracking_number']))
            : '';
        $carrier = isset($_POST['wooshippy_carrier'])
            ? sanitize_text_field(wp_unslash($_POST['wooshippy_carrier']))
            : '';

        update_post_meta($post_id, self::META_TRACKING_NUMBER, $tracking_number);
        update_post_meta($post_id, self::META_CARRIER, $carrier);
    }

    public function render_customer_tracking($order)
    {
        if ('1' !== $this->settings->get('enable_customer_display', '1')) {
            return;
        }

        if (!is_a($order, 'WC_Order')) {
            return;
        }

        $tracking_number = $order->get_meta(self::META_TRACKING_NUMBER);
        $carrier = $order->get_meta(self::META_CARRIER);

        if (empty($tracking_number)) {
            return;
        }

        include WOOSHIPPY_PATH . 'public/views/order-tracking-summary.php';
    }
}
