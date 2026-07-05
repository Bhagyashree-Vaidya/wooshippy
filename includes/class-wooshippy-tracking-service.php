<?php
/**
 * Tracking service.
 *
 * @package Wooshippy
 */

if (!defined('ABSPATH')) {
    exit;
}

class Wooshippy_Tracking_Service
{
    private $api_client;
    private $settings;

    public function __construct(Wooshippy_Api_Client $api_client, Wooshippy_Settings $settings)
    {
        $this->api_client = $api_client;
        $this->settings = $settings;
    }

    public function track($tracking_number, $carrier = '')
    {
        $tracking_number = sanitize_text_field($tracking_number);
        $carrier = sanitize_text_field($carrier);

        if (empty($tracking_number)) {
            return new WP_Error('wooshippy_missing_tracking_number', __('Tracking number is required.', 'wooshippy'));
        }

        $cache_key = $this->get_cache_key($tracking_number, $carrier);
        $cached = get_transient($cache_key);

        if (false !== $cached) {
            return $cached;
        }

        $response = $this->api_client->get_tracking($tracking_number, $carrier);

        if (is_wp_error($response)) {
            return $response;
        }

        $normalized = $this->normalize_response($response, $tracking_number, $carrier);
        $cache_minutes = absint($this->settings->get('cache_minutes', 15));

        if ($cache_minutes > 0) {
            set_transient($cache_key, $normalized, $cache_minutes * MINUTE_IN_SECONDS);
        }

        return $normalized;
    }

    private function get_cache_key($tracking_number, $carrier)
    {
        return 'wooshippy_tracking_' . md5(strtolower($carrier . '|' . $tracking_number));
    }

    private function normalize_response(array $response, $tracking_number, $carrier)
    {
        $details = isset($response['details']) && is_array($response['details']) ? $response['details'] : [];
        $events = isset($response['events']) && is_array($response['events']) ? $response['events'] : [];

        return [
            'success' => isset($response['success']) ? (bool) $response['success'] : true,
            'tracking_number' => $details['tracking'] ?? $tracking_number,
            'carrier' => $carrier ?: ($events[0]['carrier'] ?? ($details['carrier'] ?? '')),
            'status' => $response['status'] ?? ($events[0]['status'] ?? ''),
            'destination' => $details['destination'] ?? '',
            'service' => $details['service'] ?? '',
            'events' => array_values(array_map([$this, 'normalize_event'], $events)),
            'raw' => $response,
        ];
    }

    private function normalize_event($event)
    {
        $event = is_array($event) ? $event : [];

        return [
            'status' => isset($event['status']) ? sanitize_text_field($event['status']) : '',
            'datetime' => isset($event['datetime']) ? sanitize_text_field($event['datetime']) : '',
            'location' => isset($event['location']) ? sanitize_text_field($event['location']) : '',
            'carrier' => isset($event['carrier']) ? sanitize_text_field($event['carrier']) : '',
        ];
    }
}

