<?php
/**
 * Main plugin coordinator.
 *
 * @package Wooshippy
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once WOOSHIPPY_PATH . 'includes/class-wooshippy-settings.php';
require_once WOOSHIPPY_PATH . 'includes/class-wooshippy-api-client.php';
require_once WOOSHIPPY_PATH . 'includes/class-wooshippy-tracking-service.php';
require_once WOOSHIPPY_PATH . 'includes/class-wooshippy-rest-controller.php';
require_once WOOSHIPPY_PATH . 'includes/class-wooshippy-shortcodes.php';
require_once WOOSHIPPY_PATH . 'includes/class-wooshippy-woocommerce-orders.php';
require_once WOOSHIPPY_PATH . 'admin/class-wooshippy-admin.php';

final class Wooshippy_Plugin
{
    private static $instance = null;

    private $settings;
    private $api_client;
    private $tracking_service;

    public static function instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
        $this->settings = new Wooshippy_Settings();
        $this->api_client = new Wooshippy_Api_Client($this->settings);
        $this->tracking_service = new Wooshippy_Tracking_Service($this->api_client, $this->settings);
    }

    public function run()
    {
        add_action('plugins_loaded', [$this, 'load_textdomain']);

        $this->settings->register();
        (new Wooshippy_Admin($this->settings))->register();
        (new Wooshippy_Rest_Controller($this->tracking_service))->register();
        (new Wooshippy_Shortcodes())->register();
        (new Wooshippy_WooCommerce_Orders($this->tracking_service, $this->settings))->register();
    }

    public function load_textdomain()
    {
        load_plugin_textdomain('wooshippy', false, dirname(plugin_basename(WOOSHIPPY_FILE)) . '/languages/');
    }
}
