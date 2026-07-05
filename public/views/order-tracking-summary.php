<?php
/**
 * Customer order tracking summary.
 *
 * @package Wooshippy
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<section class="woocommerce-order-details wooshippy-order-tracking">
    <h2 class="woocommerce-order-details__title"><?php esc_html_e('Shipment Tracking', 'wooshippy'); ?></h2>
    <p>
        <strong><?php esc_html_e('Tracking Number:', 'wooshippy'); ?></strong>
        <?php echo esc_html($tracking_number); ?>
    </p>
    <?php if (!empty($carrier)) : ?>
        <p>
            <strong><?php esc_html_e('Carrier:', 'wooshippy'); ?></strong>
            <?php echo esc_html($carrier); ?>
        </p>
    <?php endif; ?>
</section>

