<?php
/**
 * WooCommerce Cart Tab Action hooks
 *
 * @author   jameskoster
 * @package  woocommerce-cart-tab
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wcct_before_cart_widget', 'woocommerce_cart_tab_button' );