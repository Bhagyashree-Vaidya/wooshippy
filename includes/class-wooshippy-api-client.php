<?php
/**
 * Shipping API client.
 *
 * @package Wooshippy
 */

if (!defined('ABSPATH')) {
    exit;
}

class Wooshippy_Api_Client
{
    private $settings;

    public function __construct(Wooshippy_Settings $settings)
    {
        $this->settings = $settings;
    }

    public function get_tracking($tracking_number, $carrier = '')
    {
        $api_base_url = untrailingslashit($this->settings->get('api_base_url'));
        $api_token = $this->settings->get('api_token');

        if (empty($api_base_url)) {
            return new WP_Error('wooshippy_missing_api_url', __('API base URL is not configured.', 'wooshippy'));
        }

        if (empty($api_token)) {
            return new WP_Error('wooshippy_missing_api_token', __('API token is not configured.', 'wooshippy'));
        }

        $path = '/shipments/' . rawurlencode($tracking_number) . '/track';
        $url = $api_base_url . $path;

        $response = wp_remote_get(
            $url,
            [
                'timeout' => 15,
                'headers' => [
                    'Authorization' => 'Bearer ' . $api_token,
                    'Accept' => 'application/json',
                ],
            ]
        );

        if (is_wp_error($response)) {
            return $response;
        }

        $status_code = wp_remote_retrieve_response_code($response);
        $body = wp_remote_retrieve_body($response);
        $decoded = json_decode($body, true);

        if ($status_code < 200 || $status_code >= 300) {
            return new WP_Error(
                'wooshippy_api_error',
                __('Tracking API returned an error.', 'wooshippy'),
                [
                    'status' => $status_code,
                    'body' => $decoded ?: $body,
                ]
            );
        }

        if (!is_array($decoded)) {
            return new WP_Error('wooshippy_invalid_json', __('Tracking API returned invalid JSON.', 'wooshippy'));
        }

        return $decoded;
    }
}

