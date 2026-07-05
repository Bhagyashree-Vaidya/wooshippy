# Executive Summary: WooCommerce Shipment Tracking Plugin

## Overview

This project is a commercial WordPress/WooCommerce plugin that helps ecommerce merchants reduce "Where is my order?" support tickets by giving customers branded shipment tracking, delivery updates, and exception alerts directly inside the merchant's store.

The initial codebase already contains a WordPress plugin foundation with API settings, shipping-rate lookup, tracking lookup, public shortcodes, and a Vue-based front-end. The recommended commercial direction is to evolve it from a generic shipping calculator into a focused WooCommerce shipment tracking and delivery intelligence product.

## Problem

Small and mid-sized WooCommerce merchants often rely on carrier portals, manual tracking links, or disconnected fulfillment tools. This creates several pain points:

- Customers leave the store to track orders on carrier websites.
- Merchants receive repetitive "Where is my order?" support requests.
- Delayed, stuck, failed, or exception shipments are often discovered too late.
- Tracking pages are not branded and do not support post-purchase engagement.
- Multi-carrier tracking data is fragmented and inconsistent.

## Proposed Product

Build a WooCommerce shipment tracking plugin that lets merchants:

- Add tracking numbers and carriers to WooCommerce orders.
- Display branded tracking pages to customers.
- Fetch live tracking events from a configured shipping API.
- Send delivery status emails for shipped, in transit, out for delivery, delivered, delayed, and exception states.
- Alert store owners when shipments appear stuck or need attention.
- Use shortcodes or blocks to add a public tracking form anywhere on the site.

The product can start with one carrier/API integration, such as Stallion Express, then expand to additional carriers and aggregators.

## Target Users

- WooCommerce store owners shipping physical products.
- Canadian ecommerce merchants using Stallion Express, Canada Post, UPS, FedEx, USPS, or similar carriers.
- Agencies that build WooCommerce stores and need shipment tracking features for clients.
- Small fulfillment teams that need better visibility without adopting a full enterprise shipping platform.

## Core Use Cases

1. Customer tracking page  
   A customer enters a tracking number or clicks an order link and sees live shipment progress on the merchant's website.

2. WooCommerce order integration  
   The merchant adds carrier and tracking number fields to WooCommerce orders, and the plugin displays tracking status in order emails and customer accounts.

3. Delivery notifications  
   The plugin sends automated emails when shipment status changes.

4. Exception monitoring  
   The plugin flags delayed, failed, returned, customs-held, or inactive shipments.

5. Branded post-purchase experience  
   Tracking pages include the merchant's branding, support links, return links, and optional product recommendations.

6. Rate calculator and lead generation  
   A shipping-rate calculator can remain as a secondary feature for stores that want to show shipping estimates or promote shipping services.

## MVP Scope

The first commercial MVP should focus on tracking, not rates.

Recommended MVP features:

- WordPress admin settings for API base URL, API token, and plugin behavior.
- WooCommerce order meta fields for carrier and tracking number.
- Public tracking shortcode: `[shipment_tracking]`.
- Customer-facing tracking page template.
- Secure AJAX or REST endpoint with nonce validation.
- Server-side API proxy so tokens are never exposed in the browser.
- Tracking result caching to reduce API usage.
- Basic shipment status normalization.
- Basic merchant alert for stuck or failed shipments.
- Clean README, setup instructions, and plugin packaging.

## Commercialization Strategy

### Free Plugin

Offer a free version on WordPress.org:

- Manual tracking form.
- One API integration.
- Basic shortcode.
- Basic tracking page.
- Admin settings.

This builds trust, distribution, and SEO.

### Pro Plugin

Sell a paid version from a website or marketplace:

- WooCommerce order integration.
- Automated status emails.
- Branded tracking page customization.
- Multiple carrier support.
- Shipment exception alerts.
- Tracking history.
- Advanced customer account display.

### SaaS Layer

Add a hosted service later when the product needs capabilities that are better handled outside WordPress:

- Webhook ingestion.
- Multi-carrier normalization.
- Tracking analytics.
- Delivery performance dashboards.
- API usage caching.
- Scheduled status polling.

### Services

Offer implementation and customization packages:

- Plugin setup for WooCommerce stores.
- Custom carrier integration.
- Branded tracking page design.
- Agency partner support.

## Pricing Ideas

- Free: basic tracking shortcode and manual lookup.
- Starter: $79/year for one store.
- Pro: $149/year for WooCommerce automation and branded tracking.
- Agency: $399/year for 10-25 client sites.
- SaaS add-on: monthly pricing based on shipment volume.

## Competitive Positioning

The plugin should avoid competing as a generic full shipping platform. The sharper position is:

"Branded shipment tracking and delivery alerts for WooCommerce merchants."

This is easier to explain, easier to build, and more directly tied to merchant pain.

## Differentiators

- WooCommerce-first workflow.
- Branded tracking experience hosted on the merchant's own site.
- Exception alerts for merchants, not just passive customer tracking.
- Lightweight setup compared with larger shipping platforms.
- API-agnostic architecture, beginning with Stallion Express.
- Clear free-to-pro path.

## Risks

- Carrier APIs vary widely and require normalization.
- Public tracking endpoints must be secured and rate-limited.
- WordPress.org has strict rules around SaaS, external calls, tracking, licensing, and upsells.
- Vue 2 and old dependencies in the existing codebase need modernization.
- A generic tracker may be too easy to copy unless it integrates deeply with WooCommerce workflows.

## Recommended Next Steps

1. Rename and reposition the plugin around WooCommerce shipment tracking.
2. Refactor the current codebase into a clean plugin structure.
3. Add nonce-protected AJAX or REST endpoints.
4. Add WooCommerce order tracking fields.
5. Build the branded tracking shortcode/page.
6. Add tracking result caching.
7. Prepare a local WordPress/WooCommerce test environment.
8. Package an MVP release.

## Success Metrics

- Reduction in customer tracking support requests.
- Number of tracking page views per order.
- Number of stores installed.
- Percentage of stores connecting an API token.
- Number of tracked shipments per store.
- Free-to-pro conversion rate.
- Merchant retention after first renewal.

