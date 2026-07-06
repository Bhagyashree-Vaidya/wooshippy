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
<<<<<<< HEAD
    <div class="wooshippy-app-card">
        <div class="wooshippy-app-card__hero">
            <div class="wooshippy-app-card__topbar">
                <div>
                    <span class="wooshippy-tracking__kicker"><?php esc_html_e('Wooshippy tracking', 'wooshippy'); ?></span>
                    <h2 class="wooshippy-tracking__title" id="wooshippy-tracking-title"><?php echo esc_html($atts['title']); ?></h2>
                    <p class="wooshippy-tracking__intro"><?php esc_html_e('Branded shipment tracking for your store, powered by the courier APIs merchants already use.', 'wooshippy'); ?></p>
                </div>
                <span class="wooshippy-app-card__bell" aria-hidden="true">↗</span>
            </div>

            <div class="wooshippy-map-preview" aria-label="<?php esc_attr_e('Google Maps route preview placeholder', 'wooshippy'); ?>">
                <div class="wooshippy-map-preview__grid" aria-hidden="true"></div>
                <div class="wooshippy-map-preview__road wooshippy-map-preview__road--one" aria-hidden="true"></div>
                <div class="wooshippy-map-preview__road wooshippy-map-preview__road--two" aria-hidden="true"></div>
                <div class="wooshippy-map-preview__route" aria-hidden="true"></div>
                <span class="wooshippy-map-preview__pin wooshippy-map-preview__pin--start" aria-hidden="true"></span>
                <span class="wooshippy-map-preview__pin wooshippy-map-preview__pin--mid" aria-hidden="true"></span>
                <span class="wooshippy-map-preview__pin wooshippy-map-preview__pin--end" aria-hidden="true"></span>
                <span class="wooshippy-map-preview__label wooshippy-map-preview__label--start"><?php esc_html_e('Warehouse', 'wooshippy'); ?></span>
                <span class="wooshippy-map-preview__label wooshippy-map-preview__label--end"><?php esc_html_e('Customer', 'wooshippy'); ?></span>
                <span class="wooshippy-map-preview__badge"><?php esc_html_e('Google Maps placeholder', 'wooshippy'); ?></span>
            </div>

            <div class="wooshippy-package-strip" aria-hidden="true">
                <span class="wooshippy-package-strip__box">📦</span>
                <div>
                    <strong><?php esc_html_e('Out for delivery', 'wooshippy'); ?></strong>
                    <span><?php esc_html_e('ETA, route, and live courier details are planned MVP features.', 'wooshippy'); ?></span>
                </div>
            </div>
        </div>

        <div class="wooshippy-app-card__body">
            <div class="wooshippy-feature-row" aria-label="<?php esc_attr_e('Planned tracking features', 'wooshippy'); ?>">
                <span><strong>📮</strong><?php esc_html_e('Send parcel', 'wooshippy'); ?></span>
                <span><strong>🔎</strong><?php esc_html_e('Track item', 'wooshippy'); ?></span>
                <span><strong>📍</strong><?php esc_html_e('Location', 'wooshippy'); ?></span>
                <span><strong>💳</strong><?php esc_html_e('Services', 'wooshippy'); ?></span>
            </div>

            <form class="wooshippy-tracking__form" data-wooshippy-tracking-form>
                <div class="wooshippy-tracking__field wooshippy-tracking__field--full">
                    <label class="wooshippy-tracking__label" for="wooshippy-tracking-number">
                        <?php esc_html_e('Tracking ID', 'wooshippy'); ?>
                    </label>
                    <input
                        class="wooshippy-tracking__input"
                        type="text"
                        id="wooshippy-tracking-number"
                        name="tracking_number"
                        autocomplete="off"
                        inputmode="text"
                        required
                        placeholder="<?php esc_attr_e('34AP123456789', 'wooshippy'); ?>"
                    />
                </div>

                <div class="wooshippy-tracking__field">
                    <label class="wooshippy-tracking__label" for="wooshippy-carrier">
                        <?php esc_html_e('Carrier', 'wooshippy'); ?>
                        <span><?php esc_html_e('optional unless your provider requires it', 'wooshippy'); ?></span>
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
                    <?php esc_html_e('Track now', 'wooshippy'); ?>
                    <span aria-hidden="true">→</span>
                </button>
            </form>

            <div class="wooshippy-tracking__state wooshippy-tracking__state--empty" data-wooshippy-empty>
                <strong><?php esc_html_e('Recent tracking will appear here.', 'wooshippy'); ?></strong>
                <span><?php esc_html_e('Use this MVP to validate API lookups, delivery milestones, route placeholders, and customer-facing order status.', 'wooshippy'); ?></span>
            </div>
            <div class="wooshippy-tracking__message" data-wooshippy-tracking-message role="status" aria-live="polite" hidden></div>
        </div>

        <div class="wooshippy-tracking__result" data-wooshippy-tracking-result hidden></div>
    </div>
=======
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
>>>>>>> origin/main
</section>
