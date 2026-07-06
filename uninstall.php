<?php
/**
 * Plugin uninstall cleanup.
 *
 * @package Wooshippy
 */

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

delete_option('wooshippy_options');

global $wpdb;
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_wooshippy_tracking_%' OR option_name LIKE '_transient_timeout_wooshippy_tracking_%' OR option_name LIKE '_transient_wooshippy_rate_%' OR option_name LIKE '_transient_timeout_wooshippy_rate_%'");
