<?php
/**
 * WooCommerce Cart Tab Frontend Class
 *
 * @author   jameskoster
 * @package  woocommerce-cart-tab
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WooCommerce_Cart_Tab_Frontend' ) ) :

	/**
	 * Cart tab frontend class
	 */
	class WooCommerce_Cart_Tab_Frontend {

		/**
		 * Setup class.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			add_action( 'wp_enqueue_scripts',    array( $this, 'setup_styles' ), 999 );
			add_filter( 'add_to_cart_fragments', array( $this, 'woocommerce_cart_tab_add_to_cart_fragment' ) );

			add_action( 'wp_footer',             'woocommerce_cart_tab' );
		}

		/**
		 * Styles
		 *
		 * @return void
		 */
		function setup_styles() {
			if ( ! is_cart() && ! is_checkout() ) {
				if ( 'storefront' == get_option( 'template' ) ) {
					wp_enqueue_style( 'cart-tab-styles-storefront', plugins_url( '../assets/css/style-storefront.css', __FILE__ ) );
				} else {
					wp_enqueue_style( 'cart-tab-styles', plugins_url( '../assets/css/style.css', __FILE__ ) );
				}
				wp_enqueue_script( 'cart-tab-script', plugins_url( '../assets/js/cart-tab.min.js', __FILE__ ), array( 'jquery' ), '1.0.0' );
			}
		}

		/**
		 * The cart fragment
		 *
		 * @param array $fragments elements that should be refreshed when items are added/removed from the cart.
		 */
		function woocommerce_cart_tab_add_to_cart_fragment( $fragments ) {
			ob_start();
			woocommerce_cart_tab_button();
			$fragments['.woocommerce-cart-tab'] = ob_get_clean();
			return $fragments;
		}
	}

endif;

return new WooCommerce_Cart_Tab_Frontend();
