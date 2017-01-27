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
			add_action( 'customize_register', array( $this, 'customize_register' ), 10 );
			add_action( 'wp_enqueue_scripts', array( $this, 'add_customizer_css' ), 9999 );
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
				'default'           	=> '#2c2d33',
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
			$accent     = get_theme_mod( 'woocommerce_cart_tab_accent', '#2c2d33' );

			$styles                = '
			.woocommerce-cart-tab,
			.woocommerce-cart-tab-container {
				background-color: ' . $background . ';
			}

			.woocommerce-cart-tab,
			.woocommerce-cart-tab:hover {
				color: ' . $background . ';
			}

			.woocommerce-cart-tab-icon__bag,
			.woocommerce-cart-tab-icon__handle {
				fill: ' . $accent . ';
			}';

			wp_add_inline_style( 'cart-tab-styles', $styles );
		}
	}

endif;

return new WooCommerce_Cart_Tab_Customizer();
