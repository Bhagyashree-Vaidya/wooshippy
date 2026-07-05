# Wooshippy

A WordPress/WooCommerce plugin for branded shipment tracking, delivery visibility, and shipment exception alerts.

##Problem
Small and mid-sized WooCommerce merchants often rely on carrier portals, manual tracking links, or disconnected fulfillment tools.

##Proposed Product
Build a WooCommerce shipment tracking plugin that lets merchants:
Add tracking numbers and carriers to WooCommerce orders.
Display branded tracking pages to customers.
Fetch live tracking events from a configured shipping API.
Send delivery status emails for shipped, in transit, out for delivery, delivered, delayed, and exception states.
Alert store owners when shipments appear stuck or need attention.
Use shortcodes or blocks to add a public tracking form anywhere on the site.

## Overview

Wooshippy helps ecommerce merchants give customers a better post-purchase experience. Instead of sending customers to carrier websites, stores can show shipment status directly on their own branded tracking page.

The plugin is designed to reduce "Where is my order?" support requests by connecting WooCommerce orders with carrier tracking data.

## Current MVP

- WordPress admin settings for API base URL, API token, default carrier, tracking page URL, and cache duration.
- Public `[shipment_tracking]` shortcode.
- REST endpoint at `/wp-json/wooshippy/v1/track`.
- Nonce-protected browser requests.
- Server-side API proxy so the API token is never exposed in the browser.
- Basic tracking result normalization.
- Basic transient caching for tracking lookups.
- WooCommerce order tracking number and carrier meta box.
- Tracking summary on WooCommerce customer order pages.
- Vanilla JavaScript and CSS, with no build step required.

## Planned Features

- Customer delivery status emails.
- Merchant alerts for stuck or failed shipments.
- Tracking link injection into WooCommerce emails.
- Multiple carrier/API integrations.
- Branded tracking page customization.
- Optional shipping-rate calculator.
- Shipment analytics.

## Repository Structure

```text
wooshippy/
├── wooshippy.php
├── includes/
│   ├── class-wooshippy-plugin.php
│   ├── class-wooshippy-settings.php
│   ├── class-wooshippy-api-client.php
│   ├── class-wooshippy-tracking-service.php
│   ├── class-wooshippy-rest-controller.php
│   ├── class-wooshippy-shortcodes.php
│   └── class-wooshippy-woocommerce-orders.php
├── admin/
│   ├── class-wooshippy-admin.php
│   └── views/
├── public/
│   ├── css/
│   ├── js/
│   └── views/
├── languages/
└── README.md
```

## Installation

1. Copy the `wooshippy` folder to `wp-content/plugins/`.
2. Activate **Wooshippy** in WordPress.
3. Go to **Settings > Wooshippy**.
4. Add your shipping API base URL and API token.
5. Create a tracking page and add:

```text
[shipment_tracking]
```

## Shortcodes

Current shortcode:

```text
[shipment_tracking]
```

Optional future shortcodes:

```text
[shipment_tracking order_id="123"]
[shipping_rate_calculator]
```

## Admin Settings

Current settings:

- API base URL.
- API token.
- Default carrier.
- Tracking page URL.
- Cache duration.
- Enable customer order tracking display.

## API Contract

The first API client expects a tracking endpoint that looks like:

```text
GET {API_BASE_URL}/shipments/{tracking_number}/track
```

The request includes:

```text
Authorization: Bearer {API_TOKEN}
Accept: application/json
```

The response is normalized from a shape similar to:

```json
{
  "success": true,
  "status": "In Transit",
  "details": {
    "tracking": "ABC123",
    "destination": "Toronto, ON",
    "service": "Tracked Packet"
  },
  "events": [
    {
      "status": "Accepted",
      "datetime": "2026-07-05T10:00:00Z",
      "location": "Toronto, ON",
      "carrier": "Stallion Express"
    }
  ]
}
```

## WooCommerce Integration

Current order features:

- Tracking number field.
- Carrier field.
- Tracking section in My Account order details.

## Security Notes

The current MVP already:

- Validate nonces for public AJAX or REST requests.
- Sanitize all user input.
- Escape all output.
- Keep API tokens server-side only.
- Cache tracking API responses.
- Use WordPress HTTP APIs for remote requests.

Before production release, add:

- Public lookup rate limiting.
- Stronger API response validation.
- WooCommerce HPOS compatibility testing.
- Automated tests.
- Provide clear disclosure for external API calls.

## Development Requirements

Recommended local tools:

- PHP 8.2 or newer.
- WordPress local environment.
- WooCommerce.
- WP-CLI.
- Node.js only if a build step is added.

Useful checks:

```bash
php -l path/to/file.php
```

Run PHP lint across plugin files:

```bash
find . -path './vendor' -prune -o -path './node_modules' -prune -o -name '*.php' -print0 | xargs -0 -n1 php -l
```

## Commercial Model

Suggested model:

- Free version: basic tracking form and one API integration.
- Pro version: WooCommerce order integration, branded tracking, customer emails, and merchant alerts.
- Agency license: multi-site usage for WooCommerce agencies.
- SaaS add-on: webhook processing, analytics, and multi-carrier normalization.

## Roadmap

### Phase 1: Foundation

- Rename/restructure plugin.
- Add secure settings.
- Add API client.
- Add tracking shortcode.
- Add nonce-protected endpoint.
- Add tracking result caching.

### Phase 2: WooCommerce MVP

- Add order tracking fields.
- Add tracking status to order admin.
- Add customer tracking page.
- Add tracking links to emails.
- Add basic status normalization.

### Phase 3: Commercial Features

- Branded tracking page customization.
- Delivery status emails.
- Stuck shipment alerts.
- Multiple carrier support.
- Shipment analytics.

### Phase 4: SaaS Layer

- Webhook ingestion.
- Multi-carrier event normalization.
- Delivery performance dashboard.
- Store-level shipment analytics.

## Product Positioning

Recommended positioning:

> Branded shipment tracking and delivery alerts for WooCommerce stores.

The goal is to help merchants reduce support tickets, keep customers informed, and own the post-purchase tracking experience.

## License

GPL-2.0-or-later is recommended for WordPress ecosystem compatibility.
