<?php
/**
 * Plugin Name: WooCommerce Cart Tab
 * Plugin URI: http://jameskoster.co.uk/tag/cart-tab/
 * Version: 1.1.0
 * Description: Displays a sitewide link to the cart which reveals the cart contents on hover.
 * Author: jameskoster
 * Tested up to: 4.7.1
 * Author URI: http://jameskoster.co.uk
 * Text Domain: woocommerce-cart-tab
 * Domain Path: /languages/

 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package woocommerce-cart-tab
 */

/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {

	/**
	 * Localisation
	 */
	load_plugin_textdomain( 'woocommerce-cart-tab', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

	if ( ! class_exists( 'WooCommerce_Cart_Tab' ) ) {

		/**
		 * Cart Tab class
		 */
		class WooCommerce_Cart_Tab {

			/**
			 * Set up all the things
			 */
			public function __construct() {
				$this->setup();
			}

			/**
			 * Setup
			 * @return void
			 */
			public function setup() {
				include_once( 'includes/cart-tab-functions.php' );
				include_once( 'includes/cart-tab-templates.php' );
				include_once( 'includes/class-cart-tab-customizer.php' );
				include_once( 'includes/class-cart-tab-frontend.php' );
				include_once( 'includes/class-cart-tab-hooks.php' );
			}
		}

		$woocommerce_cart_tab = new WooCommerce_Cart_Tab();
	}
}
