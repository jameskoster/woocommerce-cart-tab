=== WooCommerce Cart Tab ===
Contributors: jameskoster
Tags: woocommerce, ecommerce, cart
Requires at least: 4.4
Tested up to: 4.9.6
Stable tag: 1.1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds an offscreen cart to all pages on your site and a fixed tab that displays the number of products in the cart. Adding a product to the cart or clicking the tab reveals the cart.

== Description ==

A big UX mistake on many eCommerce web sites is hiding access to the cart. After adding a product to the cart the visitors next logical step is to complete the purchase. Don't frustrate your customers by making them search for the cart button!

This plugin adds a sitewide tab that displays the number of products in the cart. Clicking the tab or adding a product to the cart from a shop page will reveal the cart contents with a link to the checkout.

There are options in the Customizer to control the display.

Please feel free to contribute on <a href="https://github.com/jameskoster/woocommerce-cart-tab">github</a>.

== Installation ==

1. Upload `woocommerce-cart-tab` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Choose your display settings on the catalog tab of the WooCommerce settings screen
3. Done!

== Frequently Asked Questions ==

= It doesn't look like the screenshots on my site, what gives? =

This plugin uses CSS3 for things like animation, rounded corners and box shadows. If you're not using a modern browser then it might not look the same as the screenshots.

There is also the possibility that your theme is overwriting styles although that will be unlikely.

= I found and fixed a bug how can I help? =

Thanks! Please fork the repo on <a href="https://github.com/jameskoster/woocommerce-cart-tab">github</a>, push your fix then send a pull request.

== Screenshots ==

1. The cart tab.

== Changelog ==

= 1.1.2 - 05/07/2018 =
* Fix - Cart panel will now close automatically when the cart is emptied.

= 1.1.1 - 10/03/2017 =
* Tweak - WooCommerce 2.7 support. Kudos @webmandesign.
* Dev - Scripts and styles now versioned correctly.

= 1.1.0 - 08/02/2017 =
* New - Cart tab is now hidden when the cart is empty.
* Tweak - Overlay styling.
* Localisation - updated .pot file.

= 1.0.0 - 26/01/2017 =
* New - The cart tab now opens when an add to cart button on a shop page is clicked.
* New - Cart tab opens on click rather than hover.
* New - Display controls moved to the Customizer.
* New - Integration with Storefront theme.

= 0.5.0 - 06/07/2016 =
* New - Cart tab no longer displayed on handheld devices.

= 0.4.0 - 23/05/2016 =
* New - Cart tab widget now has a max-height and will scroll if the contents are larger than the container.
* New - Option to display cart total or subtotal. Props @craigtracey
* Tweak - Translations now managed on .org (https://translate.wordpress.org/projects/wp-plugins/woocommerce-cart-tab).

= 0.3.1 - 04/17/2014 =
* Fix - Hide the tab shadow when the cart is hidden.

= 0.3.0 - 04/03/2014 =
* WooCommerce 2.1 compatibility.

= 0.2.2 - 14/01/2014 =
* Sanitized some outputs (kudos colegeissinger).

= 0.2.1 - 16/09/2013 =
* Better way of hiding the cart. Compatible with WP Super Cache as long as "late init" is enabled. Kudos bigbrowncow.

= 0.2 - 01/07/2013 =
* Added option to hide cart tab if the cart is empty. Kudos azhkuro.

= 0.1.1 - 30/05/2013 =
* Improved i18n
* added languages folder
* added default .po file
* added German translations for v0.1.1 (inluding the above enhancements)
* Kudos to deckerweb for the above :-)
* UI tweak to be inline with 2.0s slightly updated settings API
* Stripped object pass by reference

= 0.1 =
Initial release.
