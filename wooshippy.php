<?php
/**
 * Plugin Name: Wooshippy
 * Plugin URI: https://github.com/Bhagyashree-Vaidya/wooshippy
 * Description: Branded shipment tracking and delivery visibility for WooCommerce stores.
 * Version: 0.1.0
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

require_once WOOSHIPPY_PATH . 'includes/class-wooshippy-plugin.php';

function wooshippy()
{
    return Wooshippy_Plugin::instance();
}

wooshippy()->run();

