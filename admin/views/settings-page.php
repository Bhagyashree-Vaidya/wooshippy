<?php
/**
 * Settings page view.
 *
 * @package Wooshippy
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="wrap">
    <h1><?php esc_html_e('Wooshippy Settings', 'wooshippy'); ?></h1>
    <p><?php esc_html_e('Connect Wooshippy to your shipping API and configure the customer tracking experience.', 'wooshippy'); ?></p>

    <form method="post" action="options.php">
        <?php settings_fields(Wooshippy_Settings::OPTION_GROUP); ?>

        <table class="form-table" role="presentation">
            <tr>
                <th scope="row">
                    <label for="wooshippy_provider"><?php esc_html_e('Tracking Provider', 'wooshippy'); ?></label>
                </th>
                <td>
                    <select
                        id="wooshippy_provider"
                        name="<?php echo esc_attr(Wooshippy_Settings::OPTION_NAME); ?>[provider]"
                    >
                        <?php foreach ($this->settings->providers() as $provider_key => $provider_label) : ?>
                            <option value="<?php echo esc_attr($provider_key); ?>" <?php selected($options['provider'], $provider_key); ?>>
                                <?php echo esc_html($provider_label); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <p class="description">
                        <?php esc_html_e('Use Generic for any vendor with a JSON tracking endpoint. EasyPost and Shippo have built-in request adapters.', 'wooshippy'); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="wooshippy_api_base_url"><?php esc_html_e('API Base URL', 'wooshippy'); ?></label>
                </th>
                <td>
                    <input
                        type="url"
                        class="regular-text"
                        id="wooshippy_api_base_url"
                        name="<?php echo esc_attr(Wooshippy_Settings::OPTION_NAME); ?>[api_base_url]"
                        value="<?php echo esc_attr($options['api_base_url']); ?>"
                        placeholder="https://shipping.example.com/api/v3"
                    />
                    <p class="description">
                        <?php esc_html_e('Required for Generic and Stallion-compatible APIs. EasyPost and Shippo use their official API hosts.', 'wooshippy'); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="wooshippy_generic_endpoint_pattern"><?php esc_html_e('Generic Endpoint Pattern', 'wooshippy'); ?></label>
                </th>
                <td>
                    <input
                        type="text"
                        class="regular-text"
                        id="wooshippy_generic_endpoint_pattern"
                        name="<?php echo esc_attr(Wooshippy_Settings::OPTION_NAME); ?>[generic_endpoint_pattern]"
                        value="<?php echo esc_attr($options['generic_endpoint_pattern']); ?>"
                        placeholder="{api_base_url}/shipments/{tracking_number}/track"
                    />
                    <p class="description">
                        <?php esc_html_e('Used by Generic API mode. Supported tokens: {api_base_url}, {tracking_number}.', 'wooshippy'); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="wooshippy_api_token"><?php esc_html_e('API Key / Token', 'wooshippy'); ?></label>
                </th>
                <td>
                    <input
                        type="password"
                        class="regular-text"
                        id="wooshippy_api_token"
                        name="<?php echo esc_attr(Wooshippy_Settings::OPTION_NAME); ?>[api_token]"
                        value="<?php echo esc_attr($options['api_token']); ?>"
                        autocomplete="off"
                    />
                    <p class="description">
                        <?php esc_html_e('Generic and Stallion-compatible use Bearer auth. EasyPost uses Basic auth. Shippo uses ShippoToken auth.', 'wooshippy'); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="wooshippy_default_carrier"><?php esc_html_e('Default Carrier', 'wooshippy'); ?></label>
                </th>
                <td>
                    <input
                        type="text"
                        class="regular-text"
                        id="wooshippy_default_carrier"
                        name="<?php echo esc_attr(Wooshippy_Settings::OPTION_NAME); ?>[default_carrier]"
                        value="<?php echo esc_attr($options['default_carrier']); ?>"
                        placeholder="Stallion Express"
                    />
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="wooshippy_tracking_page_url"><?php esc_html_e('Tracking Page URL', 'wooshippy'); ?></label>
                </th>
                <td>
                    <input
                        type="url"
                        class="regular-text"
                        id="wooshippy_tracking_page_url"
                        name="<?php echo esc_attr(Wooshippy_Settings::OPTION_NAME); ?>[tracking_page_url]"
                        value="<?php echo esc_attr($options['tracking_page_url']); ?>"
                        placeholder="https://store.example.com/track"
                    />
                    <p class="description"><?php esc_html_e('Add the [shipment_tracking] shortcode to this page.', 'wooshippy'); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="wooshippy_cache_minutes"><?php esc_html_e('Cache Duration', 'wooshippy'); ?></label>
                </th>
                <td>
                    <input
                        type="number"
                        min="0"
                        class="small-text"
                        id="wooshippy_cache_minutes"
                        name="<?php echo esc_attr(Wooshippy_Settings::OPTION_NAME); ?>[cache_minutes]"
                        value="<?php echo esc_attr($options['cache_minutes']); ?>"
                    />
                    <?php esc_html_e('minutes', 'wooshippy'); ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Customer Order Display', 'wooshippy'); ?></th>
                <td>
                    <label>
                        <input
                            type="checkbox"
                            name="<?php echo esc_attr(Wooshippy_Settings::OPTION_NAME); ?>[enable_customer_display]"
                            value="1"
                            <?php checked($options['enable_customer_display'], '1'); ?>
                        />
                        <?php esc_html_e('Show tracking details on WooCommerce order pages.', 'wooshippy'); ?>
                    </label>
                </td>
            </tr>
        </table>

        <?php submit_button(); ?>
    </form>
</div>
