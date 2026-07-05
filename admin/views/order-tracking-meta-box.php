<?php
/**
 * Order tracking meta box.
 *
 * @package Wooshippy
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<p>
    <label for="wooshippy_tracking_number"><?php esc_html_e('Tracking Number', 'wooshippy'); ?></label>
    <input
        type="text"
        class="widefat"
        id="wooshippy_tracking_number"
        name="wooshippy_tracking_number"
        value="<?php echo esc_attr($tracking_number); ?>"
    />
</p>

<p>
    <label for="wooshippy_carrier"><?php esc_html_e('Carrier', 'wooshippy'); ?></label>
    <input
        type="text"
        class="widefat"
        id="wooshippy_carrier"
        name="wooshippy_carrier"
        value="<?php echo esc_attr($carrier); ?>"
        placeholder="<?php esc_attr_e('Stallion Express', 'wooshippy'); ?>"
    />
</p>

