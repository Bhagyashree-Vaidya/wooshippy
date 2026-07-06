=== Wooshippy ===
Contributors: bhagyashree-vaidya
Tags: woocommerce, shipment tracking, order tracking, easypost, shippo
Requires at least: 6.3
Tested up to: 6.6
Requires PHP: 7.4
Stable tag: 0.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Branded shipment tracking for WooCommerce stores that connects to merchant-owned courier and shipping API accounts.

== Description ==

Wooshippy helps small shops offer a polished post-purchase tracking page without building their own shipping system. Merchants connect the shipping provider they already use, save tracking numbers on WooCommerce orders, and customers track delivery from the store website.

Current alpha features:

* Public `[shipment_tracking]` shortcode with status cards, progress steps, shipment details, and event timeline.
* Provider settings for Generic JSON, Stallion-compatible APIs, EasyPost, and Shippo.
* Server-side API calls so API keys are not exposed to frontend JavaScript.
* WooCommerce order tracking number and carrier fields.
* Optional customer order details tracking summary.
* REST endpoint at `/wp-json/wooshippy/v1/track`.
* Response caching and basic public lookup rate limiting.
* HPOS compatibility declaration.

This plugin is alpha software until tested against real production WordPress/WooCommerce sites and real provider accounts.

== Installation ==

1. Upload the plugin folder to `/wp-content/plugins/wooshippy` or install a packaged zip.
2. Activate Wooshippy from Plugins.
3. Install and activate WooCommerce if you want order-level tracking fields.
4. Go to Settings > Wooshippy.
5. Choose a provider and save your API credentials.
6. Create a page containing `[shipment_tracking]` and paste that page URL into settings.

== Provider Setup ==

= EasyPost =
Create or copy an API key from the EasyPost dashboard and paste it into Wooshippy. Carrier can be optional depending on the tracking lookup.

= Shippo =
Copy a Shippo API token from the Shippo dashboard. Shippo commonly requires a carrier code such as `usps`, `ups`, or `fedex`.

= Generic JSON API =
Use this for any courier, 3PL, or custom shipping system that exposes a JSON tracking endpoint. Enter an API base URL and endpoint pattern such as:

`{api_base_url}/shipments/{tracking_number}/track`

= Stallion-compatible API =
Enter the compatible API base URL and bearer token supplied by your shipping platform.

= AfterShip =
AfterShip is planned for a future first-class adapter. For now, use Generic JSON if you have a compatible proxy endpoint.

== Privacy and External Services ==

Wooshippy sends tracking numbers and optional carrier values to the selected shipping API provider when a lookup is requested. API keys are stored in WordPress options and used only in server-side WordPress HTTP API requests. Customers do not receive API tokens in frontend JavaScript.

== Frequently Asked Questions ==

= Is Wooshippy a courier? =
No. Wooshippy is a tracking layer. Merchants bring their own shipping/tracking provider account.

= Does it require WooCommerce? =
The shortcode and provider lookup can run without WooCommerce. WooCommerce is required for order admin fields and customer order details display.

= Is this production ready? =
Not yet. This is an alpha MVP that still needs real cloud WordPress/WooCommerce testing, real provider-key testing, WordPress Coding Standards review, screenshots, and marketplace packaging.
