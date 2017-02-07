<?php
/**
 * WooCommerce Cart Tab Customizer Class
 *
 * @author   jameskoster
 * @package  woocommerce-cart-tab
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WooCommerce_Cart_Tab_Customizer' ) ) :

	/**
	 * Cart tab Customizer class
	 */
	class WooCommerce_Cart_Tab_Customizer {

		/**
		 * Setup class.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			if ( 'storefront' == get_option( 'template' ) ) {
				add_action( 'wp_enqueue_scripts', array( $this, 'add_customizer_css_storefront' ), 9999 );
			} else {
				add_action( 'customize_register', array( $this, 'customize_register' ), 10 );
				add_action( 'wp_enqueue_scripts', array( $this, 'add_customizer_css' ), 9999 );
			}
		}

		/**
		 * Customizer controls / settings
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @since  1.0.0
		 */
		public function customize_register( $wp_customize ) {

			/**
			 * Create defaults from existing options set using the old method
			 */
			$cart_tab_position_default = get_option( 'wc_ct_horizontal_position' );

			if ( $cart_tab_position_default ) {
				delete_option( 'wc_ct_horizontal_position' );
			} else {
				$cart_tab_position_default = 'right';
			}

			/**
			 * Sections
			 */
			$wp_customize->add_section( 'woocommerce_cart_tab' , array(
				'title'    => __( 'Cart Tab', 'storefront' ),
				'priority' => 85,
			) );

			/**
			 * Settings
			 */
			$wp_customize->add_setting( 'woocommerce_cart_tab_position' , array(
				'default'           => $cart_tab_position_default,
				'transport'         => 'refresh',
				'sanitize_callback' => 'woocommerce_cart_tab_sanitize_choices',
			) );

			$wp_customize->add_setting( 'woocommerce_cart_tab_background', array(
				'default'           	=> '#ffffff',
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_setting( 'woocommerce_cart_tab_accent', array(
				'default'           	=> '#333333',
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			/**
			 * Controls
			 */
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'woocommerce_cart_tab_position', array(
				'label'    => __( 'Position', 'woocommerce-cart-tab' ),
				'section'  => 'woocommerce_cart_tab',
				'settings' => 'woocommerce_cart_tab_position',
				'type'     => 'select',
				'choices'  => array(
								'right' => __( 'Right', 'woocommerce-cart-tab' ),
								'left'  => __( 'Left', 'woocommerce-cart-tab' ),
				),
			) ) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'woocommerce_cart_tab_background', array(
				'label'	   				=> __( 'Background color', 'woocommerce-cart-tab' ),
				'section'  				=> 'woocommerce_cart_tab',
				'settings' 				=> 'woocommerce_cart_tab_background',
			) ) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'woocommerce_cart_tab_accent', array(
				'label'	   				=> __( 'Icon color', 'woocommerce-cart-tab' ),
				'section'  				=> 'woocommerce_cart_tab',
				'settings' 				=> 'woocommerce_cart_tab_accent',
			) ) );
		}

		/**
		 * Add CSS in <head> for styles handled by the theme customizer
		 * If the Customizer is active pull in the raw css. Otherwise pull in the prepared theme_mods if they exist.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function add_customizer_css() {
			$background = get_theme_mod( 'woocommerce_cart_tab_background', '#ffffff' );
			$accent     = get_theme_mod( 'woocommerce_cart_tab_accent', '#333333' );

			$styles                = '
			.woocommerce-cart-tab-container {
				background-color: ' . $this->woocommerce_cart_tab_adjust_color_brightness( $background, -7 ) . ';
			}

			.woocommerce-cart-tab,
			.woocommerce-cart-tab-container .widget_shopping_cart .widgettitle,
			.woocommerce-cart-tab-container .widget_shopping_cart .buttons {
				background-color: ' . $background . ';
			}

			.woocommerce-cart-tab,
			.woocommerce-cart-tab:hover {
				color: ' . $background . ';
			}

			.woocommerce-cart-tab__contents {
				background-color: ' . $accent . ';
			}

			.woocommerce-cart-tab__icon-bag {
				fill: ' . $accent . ';
			}';

			wp_add_inline_style( 'cart-tab-styles', $styles );
		}

		/**
		 * Add CSS in <head> for styles handled by the theme customizer - Storefront edition
		 * If the Customizer is active pull in the raw css. Otherwise pull in the prepared theme_mods if they exist.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function add_customizer_css_storefront() {
			$background        = get_theme_mod( 'storefront_header_background_color' );
			$header_link_color = get_theme_mod( 'storefront_header_link_color' );
			$header_text_color = get_theme_mod( 'storefront_header_text_color' );
			$button_background = get_theme_mod( 'storefront_button_alt_background_color' );
			$button_text       = get_theme_mod( 'storefront_button_alt_text_color' );

			$styles                = '
			.woocommerce-cart-tab-container {
				background-color: ' . $this->woocommerce_cart_tab_adjust_color_brightness( $background, 10 ) . ';
			}

			.woocommerce-cart-tab,
			.woocommerce-cart-tab-container .widget_shopping_cart .widgettitle,
			.woocommerce-cart-tab-container .widget_shopping_cart .buttons {
				background-color: ' . $this->woocommerce_cart_tab_adjust_color_brightness( $background, 20 ) . ';
			}

			.woocommerce-cart-tab,
			.woocommerce-cart-tab:hover {
				color: ' . $this->woocommerce_cart_tab_adjust_color_brightness( $background, 10 ) . ';
			}

			.woocommerce-cart-tab-container .widget_shopping_cart {
				color: ' . $header_text_color . ';
			}

			.woocommerce-cart-tab-container .widget_shopping_cart a:not(.button),
			.woocommerce-cart-tab-container .widget_shopping_cart .widgettitle {
				color: ' . $header_link_color . ';
			}

			.woocommerce-cart-tab__contents {
				background-color: ' . $button_background . ';
				color: ' . $button_text . ';
			}

			.woocommerce-cart-tab__icon-bag {
				fill: ' . $header_link_color . ';
			}';

			wp_add_inline_style( 'cart-tab-styles-storefront', $styles );
		}

		/**
		 * Adjust a hex color brightness
		 * Allows us to create hover styles for custom link colors
		 *
		 * @param  strong  $hex   hex color e.g. #111111.
		 * @param  integer $steps factor by which to brighten/darken ranging from -255 (darken) to 255 (brighten).
		 * @return string        brightened/darkened hex color
		 * @since  1.0.0
		 */
		public function woocommerce_cart_tab_adjust_color_brightness( $hex, $steps ) {
			// Steps should be between -255 and 255. Negative = darker, positive = lighter.
			$steps  = max( -255, min( 255, $steps ) );

			// Format the hex color string.
			$hex    = str_replace( '#', '', $hex );

			if ( 3 == strlen( $hex ) ) {
				$hex    = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
			}

			// Get decimal values.
			$r  = hexdec( substr( $hex, 0, 2 ) );
			$g  = hexdec( substr( $hex, 2, 2 ) );
			$b  = hexdec( substr( $hex, 4, 2 ) );

			// Adjust number of steps and keep it inside 0 to 255.
			$r  = max( 0, min( 255, $r + $steps ) );
			$g  = max( 0, min( 255, $g + $steps ) );
			$b  = max( 0, min( 255, $b + $steps ) );

			$r_hex  = str_pad( dechex( $r ), 2, '0', STR_PAD_LEFT );
			$g_hex  = str_pad( dechex( $g ), 2, '0', STR_PAD_LEFT );
			$b_hex  = str_pad( dechex( $b ), 2, '0', STR_PAD_LEFT );

			return '#' . $r_hex . $g_hex . $b_hex;
		}
	}

endif;

return new WooCommerce_Cart_Tab_Customizer();
