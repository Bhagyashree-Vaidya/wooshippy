<?php
/**
 * Tracking shortcode view.
 *
 * @package Wooshippy
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<section class="wooshippy-tracking" data-wooshippy-tracking aria-labelledby="wooshippy-tracking-title">
    <div class="wooshippy-tracking__hero">
        <span class="wooshippy-tracking__kicker"><?php esc_html_e('Store shipment tracking', 'wooshippy'); ?></span>
        <h2 class="wooshippy-tracking__title" id="wooshippy-tracking-title"><?php echo esc_html($atts['title']); ?></h2>
        <p class="wooshippy-tracking__intro">
            <?php esc_html_e('Enter your tracking number to see the latest delivery status, carrier details, and shipment history from this store.', 'wooshippy'); ?>
        </p>
    </div>

    <form class="wooshippy-tracking__form" data-wooshippy-tracking-form>
        <div class="wooshippy-tracking__field wooshippy-tracking__field--grow">
            <label class="wooshippy-tracking__label" for="wooshippy-tracking-number">
                <?php esc_html_e('Tracking number', 'wooshippy'); ?>
            </label>
            <input
                class="wooshippy-tracking__input"
                type="text"
                id="wooshippy-tracking-number"
                name="tracking_number"
                autocomplete="off"
                inputmode="text"
                required
                placeholder="<?php esc_attr_e('Example: 1Z999AA10123456784', 'wooshippy'); ?>"
            />
        </div>
        <div class="wooshippy-tracking__field">
            <label class="wooshippy-tracking__label" for="wooshippy-carrier">
                <?php esc_html_e('Carrier', 'wooshippy'); ?>
                <span><?php esc_html_e('if requested by the store', 'wooshippy'); ?></span>
            </label>
            <input
                class="wooshippy-tracking__input"
                type="text"
                id="wooshippy-carrier"
                name="carrier"
                autocomplete="off"
                placeholder="<?php esc_attr_e('UPS, FedEx, USPS...', 'wooshippy'); ?>"
            />
        </div>
        <button class="wooshippy-tracking__button" type="submit" data-wooshippy-submit>
            <?php esc_html_e('Track package', 'wooshippy'); ?>
        </button>
    </form>

    <div class="wooshippy-tracking__state wooshippy-tracking__state--empty" data-wooshippy-empty>
        <strong><?php esc_html_e('Ready when you are.', 'wooshippy'); ?></strong>
        <span><?php esc_html_e('Shipment updates will appear here with a delivery progress bar and event timeline.', 'wooshippy'); ?></span>
    </div>
    <div class="wooshippy-tracking__message" data-wooshippy-tracking-message role="status" aria-live="polite" hidden></div>
    <div class="wooshippy-tracking__result" data-wooshippy-tracking-result hidden></div>
</section>
