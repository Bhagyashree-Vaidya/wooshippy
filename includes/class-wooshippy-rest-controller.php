<?php
/**
 * REST API routes.
 *
 * @package Wooshippy
 */

if (!defined('ABSPATH')) {
    exit;
}

class Wooshippy_Rest_Controller
{
    const NAMESPACE = 'wooshippy/v1';

    private $tracking_service;

    public function __construct(Wooshippy_Tracking_Service $tracking_service)
    {
        $this->tracking_service = $tracking_service;
    }

    public function register()
    {
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    public function register_routes()
    {
        register_rest_route(
            self::NAMESPACE,
            '/track',
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'track'],
                'permission_callback' => [$this, 'can_track'],
                'args' => [
                    'tracking_number' => [
                        'required' => true,
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                    'carrier' => [
                        'required' => false,
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
            ]
        );
    }

    public function can_track(WP_REST_Request $request)
    {
        $nonce = $request->get_header('X-WP-Nonce');

        return (bool) wp_verify_nonce($nonce, 'wp_rest');
    }

    public function track(WP_REST_Request $request)
    {
        $result = $this->tracking_service->track(
            $request->get_param('tracking_number'),
            $request->get_param('carrier')
        );

        if (is_wp_error($result)) {
            return new WP_REST_Response(
                [
                    'success' => false,
                    'message' => $result->get_error_message(),
                    'code' => $result->get_error_code(),
                ],
                400
            );
        }

        return rest_ensure_response($result);
    }
}
