<?php
/**
 * Settings page view.
 *
 * @package Wooshippy
 */

if (!defined('ABSPATH')) {
    exit;
}

$provider_help = [
    'generic' => __('Use this for any courier, 3PL, or shipping platform that exposes a JSON tracking endpoint. Enter the base URL and an endpoint pattern with {tracking_number}.', 'wooshippy'),
    'stallion_express' => __('Use a Stallion-compatible tracking endpoint. Enter the API base URL and bearer token supplied by your shipping platform.', 'wooshippy'),
    'easypost' => __('Paste an EasyPost API key from your EasyPost dashboard. Wooshippy calls EasyPost server-side and never exposes the key to customers.', 'wooshippy'),
    'shippo' => __('Paste a Shippo API token from your Shippo dashboard. Shippo tracking lookups usually require a carrier code such as usps, ups, or fedex.', 'wooshippy'),
];
?>

<div class="wrap wooshippy-admin">
    <h1><?php esc_html_e('Wooshippy Settings', 'wooshippy'); ?></h1>
    <p class="description"><?php esc_html_e('Build a branded tracking page for your store while keeping shipping API keys safely on the WordPress server.', 'wooshippy'); ?></p>

    <form method="post" action="options.php">
        <?php settings_fields(Wooshippy_Settings::OPTION_GROUP); ?>

        <h2><?php esc_html_e('1. Choose your tracking provider', 'wooshippy'); ?></h2>
        <table class="form-table" role="presentation">
            <tr>
                <th scope="row"><label for="wooshippy_provider"><?php esc_html_e('Provider', 'wooshippy'); ?></label></th>
                <td>
                    <select id="wooshippy_provider" name="<?php echo esc_attr(Wooshippy_Settings::OPTION_NAME); ?>[provider]">
                        <?php foreach ($this->settings->providers() as $provider_key => $provider_label) : ?>
                            <option value="<?php echo esc_attr($provider_key); ?>" <?php selected($options['provider'], $provider_key); ?>><?php echo esc_html($provider_label); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php foreach ($provider_help as $provider_key => $help) : ?>
                        <p class="description wooshippy-provider-help" data-provider-help="<?php echo esc_attr($provider_key); ?>"><?php echo esc_html($help); ?></p>
                    <?php endforeach; ?>
                    <p class="description"><?php esc_html_e('AfterShip is planned for a future adapter; use Generic JSON if you already have an AfterShip-compatible proxy endpoint.', 'wooshippy'); ?></p>
                </td>
            </tr>
            <tr data-provider-field="generic stallion_express">
                <th scope="row"><label for="wooshippy_api_base_url"><?php esc_html_e('API base URL', 'wooshippy'); ?></label></th>
                <td><input type="url" class="regular-text" id="wooshippy_api_base_url" name="<?php echo esc_attr(Wooshippy_Settings::OPTION_NAME); ?>[api_base_url]" value="<?php echo esc_attr($options['api_base_url']); ?>" placeholder="https://shipping.example.com/api/v3" /></td>
            </tr>
            <tr data-provider-field="generic">
                <th scope="row"><label for="wooshippy_generic_endpoint_pattern"><?php esc_html_e('Generic endpoint pattern', 'wooshippy'); ?></label></th>
                <td><input type="text" class="large-text" id="wooshippy_generic_endpoint_pattern" name="<?php echo esc_attr(Wooshippy_Settings::OPTION_NAME); ?>[generic_endpoint_pattern]" value="<?php echo esc_attr($options['generic_endpoint_pattern']); ?>" placeholder="{api_base_url}/shipments/{tracking_number}/track" />
                <p class="description"><?php esc_html_e('Supported tokens: {api_base_url} and {tracking_number}.', 'wooshippy'); ?></p></td>
            </tr>
            <tr>
                <th scope="row"><label for="wooshippy_api_token"><?php esc_html_e('API key / token', 'wooshippy'); ?></label></th>
                <td><input type="password" class="regular-text" id="wooshippy_api_token" name="<?php echo esc_attr(Wooshippy_Settings::OPTION_NAME); ?>[api_token]" value="<?php echo esc_attr($options['api_token']); ?>" autocomplete="new-password" />
                <p class="description"><?php esc_html_e('Stored in WordPress options and used only by server-side HTTP requests.', 'wooshippy'); ?></p></td>
            </tr>
        </table>

        <h2><?php esc_html_e('2. Configure the customer tracking experience', 'wooshippy'); ?></h2>
        <table class="form-table" role="presentation">
            <tr><th scope="row"><label for="wooshippy_default_carrier"><?php esc_html_e('Default carrier', 'wooshippy'); ?></label></th><td><input type="text" class="regular-text" id="wooshippy_default_carrier" name="<?php echo esc_attr(Wooshippy_Settings::OPTION_NAME); ?>[default_carrier]" value="<?php echo esc_attr($options['default_carrier']); ?>" placeholder="Stallion Express" /></td></tr>
            <tr><th scope="row"><label for="wooshippy_tracking_page_url"><?php esc_html_e('Tracking page URL', 'wooshippy'); ?></label></th><td><input type="url" class="regular-text" id="wooshippy_tracking_page_url" name="<?php echo esc_attr(Wooshippy_Settings::OPTION_NAME); ?>[tracking_page_url]" value="<?php echo esc_attr($options['tracking_page_url']); ?>" placeholder="https://store.example.com/track" /><p class="description"><?php esc_html_e('Create a page with the [shipment_tracking] shortcode and paste its URL here.', 'wooshippy'); ?></p></td></tr>
            <tr><th scope="row"><label for="wooshippy_cache_minutes"><?php esc_html_e('Cache duration', 'wooshippy'); ?></label></th><td><input type="number" min="0" max="1440" class="small-text" id="wooshippy_cache_minutes" name="<?php echo esc_attr(Wooshippy_Settings::OPTION_NAME); ?>[cache_minutes]" value="<?php echo esc_attr($options['cache_minutes']); ?>" /> <?php esc_html_e('minutes', 'wooshippy'); ?></td></tr>
            <tr><th scope="row"><?php esc_html_e('Customer order display', 'wooshippy'); ?></th><td><label><input type="checkbox" name="<?php echo esc_attr(Wooshippy_Settings::OPTION_NAME); ?>[enable_customer_display]" value="1" <?php checked($options['enable_customer_display'], '1'); ?> /> <?php esc_html_e('Show tracking summary on WooCommerce customer order pages.', 'wooshippy'); ?></label></td></tr>
        </table>

        <h2><?php esc_html_e('3. Test a tracking lookup', 'wooshippy'); ?></h2>
        <p><?php esc_html_e('Save settings first, then run a server-side test lookup. API keys are never sent to the browser.', 'wooshippy'); ?></p>
        <p><input type="text" id="wooshippy_test_tracking" class="regular-text" placeholder="<?php esc_attr_e('Tracking number', 'wooshippy'); ?>" /> <input type="text" id="wooshippy_test_carrier" class="regular-text" placeholder="<?php esc_attr_e('Carrier if required', 'wooshippy'); ?>" /> <button type="button" class="button" id="wooshippy_test_lookup"><?php esc_html_e('Test tracking lookup', 'wooshippy'); ?></button></p>
        <pre id="wooshippy_test_result" style="background:#fff;border:1px solid #c3c4c7;max-width:760px;padding:12px;white-space:pre-wrap;" hidden></pre>

        <?php submit_button(); ?>
    </form>
</div>
<script>
(function(){
  var provider = document.getElementById('wooshippy_provider');
  function sync(){
    var value = provider.value;
    document.querySelectorAll('[data-provider-help]').forEach(function(el){el.hidden = el.getAttribute('data-provider-help') !== value;});
    document.querySelectorAll('[data-provider-field]').forEach(function(row){row.hidden = row.getAttribute('data-provider-field').split(' ').indexOf(value) === -1;});
  }
  provider.addEventListener('change', sync); sync();
  document.getElementById('wooshippy_test_lookup').addEventListener('click', function(){
    var output = document.getElementById('wooshippy_test_result');
    output.hidden = false; output.textContent = 'Running lookup...';
    fetch(window.wooshippyAdmin.endpoint, {method:'POST', headers:{'Content-Type':'application/json','X-WP-Nonce':window.wooshippyAdmin.nonce}, body:JSON.stringify({tracking_number:document.getElementById('wooshippy_test_tracking').value, carrier:document.getElementById('wooshippy_test_carrier').value})})
      .then(function(r){return r.json().then(function(b){if(!r.ok){throw new Error(b.message || 'Lookup failed');} return b;});})
      .then(function(body){output.textContent = JSON.stringify(body, null, 2);})
      .catch(function(error){output.textContent = error.message;});
  });
})();
</script>
