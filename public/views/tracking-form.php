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

<div class="wooshippy-tracking" data-wooshippy-tracking>
    <form class="wooshippy-tracking__form" data-wooshippy-tracking-form>
        <h2 class="wooshippy-tracking__title"><?php echo esc_html($atts['title']); ?></h2>

        <label class="wooshippy-tracking__label" for="wooshippy-tracking-number">
            <?php esc_html_e('Tracking number', 'wooshippy'); ?>
        </label>
        <div class="wooshippy-tracking__controls">
            <input
                class="wooshippy-tracking__input"
                type="text"
                id="wooshippy-tracking-number"
                name="tracking_number"
                autocomplete="off"
                required
            />
            <button class="wooshippy-tracking__button" type="submit">
                <?php esc_html_e('Track', 'wooshippy'); ?>
            </button>
        </div>
    </form>

    <div class="wooshippy-tracking__message" data-wooshippy-tracking-message hidden></div>
    <div class="wooshippy-tracking__result" data-wooshippy-tracking-result hidden></div>
</div>

