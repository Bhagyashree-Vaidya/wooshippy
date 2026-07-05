# WooCommerce Shipment Tracking

A WordPress/WooCommerce plugin for branded shipment tracking, delivery updates, and shipment exception alerts.

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

WooCommerce Shipment Tracking helps ecommerce merchants give customers a better post-purchase experience. Instead of sending customers to carrier websites, stores can show shipment status directly on their own branded tracking page.

The plugin is designed to reduce "Where is my order?" support requests by connecting WooCommerce orders with carrier tracking data.

## Planned Features

- WooCommerce order tracking fields.
- Public tracking form shortcode.
- Branded customer tracking page.
- Secure server-side shipping API proxy.
- Shipment status normalization.
- Delivery status emails.
- Merchant alerts for stuck or failed shipments.
- Tracking result caching.
- Carrier/API configuration from WordPress admin.
- Optional shipping-rate calculator.

## MVP Features

The first version will focus on a narrow, useful workflow:

- Admin settings for API base URL and token.
- Tracking number and carrier fields on WooCommerce orders.
- `[shipment_tracking]` shortcode for a public tracking form.
- Customer-facing tracking results.
- Secure AJAX or REST endpoint with nonce validation.
- API token stored server-side only.
- Basic cache for tracking lookups.

## Existing Starting Point

This project is based on an existing WordPress plugin prototype that includes:

- API token and base URL settings.
- Shipping rates shortcode.
- Shipment tracking shortcode.
- Static comparison table shortcodes.
- Vue-based public tracking and rate calculator UI.
- PHP syntax-valid WordPress plugin structure.

The current prototype should be treated as a starting point, not production-ready software.

## Recommended Architecture

```text
woocommerce-shipment-tracking/
├── woocommerce-shipment-tracking.php
├── includes/
│   ├── class-plugin.php
│   ├── class-settings.php
│   ├── class-api-client.php
│   ├── class-tracking-service.php
│   ├── class-woocommerce-orders.php
│   └── class-shortcodes.php
├── admin/
│   ├── class-admin.php
│   └── views/
├── public/
│   ├── class-public.php
│   ├── css/
│   ├── js/
│   └── views/
├── assets/
├── languages/
├── tests/
└── README.md
```

## Shortcodes

Planned shortcode:

```text
[shipment_tracking]
```

Optional future shortcodes:

```text
[shipment_tracking order_id="123"]
[shipping_rate_calculator]
```

## Admin Settings

Initial settings:

- API base URL.
- API token.
- Default carrier.
- Tracking page URL.
- Cache duration.
- Enable customer emails.
- Enable merchant alerts.

## WooCommerce Integration

Planned order features:

- Tracking number field.
- Carrier field.
- Shipment status field.
- Last synced timestamp.
- Tracking events stored or cached.
- Tracking link in customer emails.
- Tracking section in My Account order details.

## Security Requirements

Before production release, the plugin must:

- Validate nonces for public AJAX or REST requests.
- Sanitize all user input.
- Escape all output.
- Keep API tokens server-side only.
- Rate-limit public tracking lookups.
- Cache tracking API responses.
- Use WordPress HTTP APIs for remote requests.
- Avoid loading unnecessary external scripts.
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

