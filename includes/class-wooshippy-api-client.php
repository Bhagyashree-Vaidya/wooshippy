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
        $provider = $this->settings->get('provider', 'generic');
        $api_token = $this->settings->get('api_token');

        if (empty($api_token)) {
            return new WP_Error('wooshippy_missing_api_token', __('API token is not configured.', 'wooshippy'));
        }

        $request = $this->build_tracking_request($provider, $tracking_number, $carrier);

        if (is_wp_error($request)) {
            return $request;
        }

        $response = wp_remote_request($request['url'], $request['args']);

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

        $decoded['_wooshippy_provider'] = $provider;

        return $decoded;
    }

    private function build_tracking_request($provider, $tracking_number, $carrier)
    {
        switch ($provider) {
            case 'easypost':
                return $this->build_easypost_request($tracking_number, $carrier);
            case 'shippo':
                return $this->build_shippo_request($tracking_number, $carrier);
            case 'stallion_express':
                return $this->build_stallion_request($tracking_number);
            case 'generic':
            default:
                return $this->build_generic_request($tracking_number);
        }
    }

    private function build_generic_request($tracking_number)
    {
        $api_base_url = untrailingslashit($this->settings->get('api_base_url'));
        $pattern = $this->settings->get('generic_endpoint_pattern');

        if (empty($api_base_url)) {
            return new WP_Error('wooshippy_missing_api_url', __('API base URL is not configured.', 'wooshippy'));
        }

        if (empty($pattern)) {
            $pattern = '{api_base_url}/shipments/{tracking_number}/track';
        }

        return [
            'url' => $this->replace_endpoint_tokens($pattern, $tracking_number, $api_base_url),
            'args' => [
                'method' => 'GET',
                'timeout' => 15,
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->settings->get('api_token'),
                    'Accept' => 'application/json',
                ],
            ],
        ];
    }

    private function build_stallion_request($tracking_number)
    {
        $api_base_url = untrailingslashit($this->settings->get('api_base_url'));

        if (empty($api_base_url)) {
            return new WP_Error('wooshippy_missing_api_url', __('Stallion-compatible API base URL is not configured.', 'wooshippy'));
        }

        return [
            'url' => $api_base_url . '/shipments/' . rawurlencode($tracking_number) . '/track',
            'args' => [
                'method' => 'GET',
                'timeout' => 15,
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->settings->get('api_token'),
                    'Accept' => 'application/json',
                ],
            ],
        ];
    }

    private function build_easypost_request($tracking_number, $carrier)
    {
        $body = [
            'tracking_code' => $tracking_number,
        ];

        if (!empty($carrier)) {
            $body['carrier'] = $carrier;
        }

        return [
            'url' => 'https://api.easypost.com/v2/trackers',
            'args' => [
                'method' => 'POST',
                'timeout' => 15,
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode($this->settings->get('api_token') . ':'),
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'body' => wp_json_encode($body),
            ],
        ];
    }

    private function build_shippo_request($tracking_number, $carrier)
    {
        if (empty($carrier)) {
            return new WP_Error('wooshippy_missing_carrier', __('Shippo requires a carrier name for tracking lookups.', 'wooshippy'));
        }

        return [
            'url' => 'https://api.goshippo.com/tracks/' . rawurlencode($carrier) . '/' . rawurlencode($tracking_number),
            'args' => [
                'method' => 'GET',
                'timeout' => 15,
                'headers' => [
                    'Authorization' => 'ShippoToken ' . $this->settings->get('api_token'),
                    'Accept' => 'application/json',
                ],
            ],
        ];
    }

    private function replace_endpoint_tokens($pattern, $tracking_number, $api_base_url)
    {
        return strtr(
            $pattern,
            [
                '{api_base_url}' => $api_base_url,
                '{tracking_number}' => rawurlencode($tracking_number),
            ]
        );
    }
}
