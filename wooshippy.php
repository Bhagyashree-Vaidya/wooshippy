<?php
/**
 * Plugin Name: Wooshippy
 * Plugin URI: https://github.com/Bhagyashree-Vaidya/wooshippy
 * Description: Branded shipment tracking and delivery visibility for WooCommerce stores.
 * Version: 0.1.0
 * Requires at least: 6.3
 * Tested up to: 6.6
 * Requires PHP: 7.4
 * Author: Bhagyashree Vaidya
 * Author URI: https://github.com/Bhagyashree-Vaidya
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wooshippy
 * Domain Path: /languages
 *
 * @package Wooshippy
 */

if (!defined('ABSPATH')) {
    exit;
}

define('WOOSHIPPY_VERSION', '0.1.0');
define('WOOSHIPPY_FILE', __FILE__);
define('WOOSHIPPY_PATH', plugin_dir_path(__FILE__));
define('WOOSHIPPY_URL', plugin_dir_url(__FILE__));

add_action('before_woocommerce_init', function () {
    if (class_exists('\Automattic\WooCommerce\Utilities\FeaturesUtil')) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('custom_order_tables', __FILE__, true);
    }
});

require_once WOOSHIPPY_PATH . 'includes/class-wooshippy-plugin.php';

function wooshippy()
{
    return Wooshippy_Plugin::instance();
}

wooshippy()->run();

