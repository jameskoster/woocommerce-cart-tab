<?php
/**
 * Plugin Name: WooCommerce Cart Tab
 * Plugin URI: http://jameskoster.co.uk/tag/cart-tab/
 * Version: 0.5.0
 * Description: Displays a sitewide link to the cart which reveals the cart contents on hover.
 * Author: jameskoster
 * Tested up to: 4.5.2
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

	if ( ! class_exists( 'WC_ct' ) ) {

		/**
		 * Cart Tab class
		 */
		class WC_ct {

			/**
			 * Set up all the things
			 */
			public function __construct() {
				add_action( 'wp_enqueue_scripts',    array( $this, 'setup_styles' ) );
				add_action( 'wp_footer',             array( $this, 'woocommerce_cart_tab' ) );
				add_filter( 'add_to_cart_fragments', array( $this, 'wcct_add_to_cart_fragment' ) );

				// Init settings.
				$this->settings = array(
					array(
						'name' => __( 'Cart Tab', 'woocommerce-cart-tab' ),
						'type' => 'title',
						'id'   => 'wc_ct_options',
					),
					array(
						'name' => __( 'Cart Widget', 'woocommerce-cart-tab' ),
						'desc' => __( 'Display the cart widget on hover', 'woocommerce-cart-tab' ),
						'id'   => 'wc_ct_cart_widget',
						'type' => 'checkbox',
					),
					array(
						'name' => __( 'Hide Empty Cart', 'woocommerce-cart-tab' ),
						'desc' => __( 'Hide the cart tab if the cart is empty', 'woocommerce-cart-tab' ),
						'id'   => 'wc_ct_hide_empty_cart',
						'type' => 'checkbox',
					),
					array(
						'name'    => __( 'Use the light or dark skin', 'woocommerce-cart-tab' ),
						'id'      => 'wc_ct_skin',
						'type'    => 'select',
						'options' => array(
								'light' => __( 'Light', 'woocommerce-cart-tab' ),
								'dark'  => __( 'Dark', 'woocommerce-cart-tab' ),
						),
					),
					array(
						'name'    => __( 'Position the cart tab on the right or left', 'woocommerce-cart-tab' ),
						'id'      => 'wc_ct_horizontal_position',
						'type'    => 'select',
						'options' => array(
								'right' => __( 'Right', 'woocommerce-cart-tab' ),
								'left' 	=> __( 'Left', 'woocommerce-cart-tab' ),
						),
					),
					array(
						'name'    => __( 'Cart link display total/subtotal', 'woocommerce-cart-tab' ),
						'id'      => 'wc_ct_link_display_total',
						'type'    => 'select',
						'options' => array(
								'total'    => __( 'total', 'woocommerce-cart-tab' ),
								'subtotal' => __( 'subtotal', 'woocommerce-cart-tab' ),
						),
					),

					array(
						'type' => 'sectionend',
						'id'   => 'wc_ct_options',
					),
				);

				// Default options.
				add_option( 'wc_ct_cart_widget',         'yes' );
				add_option( 'wc_ct_hide_empty_cart',     'no' );
				add_option( 'wc_ct_skin',                'light' );
				add_option( 'wc_ct_horizontal_position', 'right' );
				add_option( 'wc_ct_link_display_total',  'total' );

				// Admin.
				add_action( 'woocommerce_settings_image_options_after', array( $this, 'admin_settings' ), 20 );
				add_action( 'woocommerce_update_options_catalog',       array( $this, 'save_admin_settings' ) );
				add_action( 'woocommerce_update_options_products',      array( $this, 'save_admin_settings' ) );
			}

			/**
			 * Load the settings
			 *
			 * @return void
			 */
			function admin_settings() {
				woocommerce_admin_fields( $this->settings );
			}

			/**
			 * Save the settings
			 *
			 * @return void
			 */
			function save_admin_settings() {
				woocommerce_update_options( $this->settings );
			}

			/**
			 * Styles
			 *
			 * @return void
			 */
			function setup_styles() {
				if ( ! is_cart() && ! is_checkout() ) {
					wp_enqueue_style( 'ct-styles', plugins_url( '/assets/css/style.css', __FILE__ ) );
				}
			}

			/**
			 * The cart fragment
			 *
			 * @param array $fragments elements that should be refreshed when items are added/removed from the cart.
			 */
			function wcct_add_to_cart_fragment( $fragments ) {
				global $woocommerce;
				ob_start();
				wcct_cart_button();
				$fragments['a.cart-parent'] = ob_get_clean();
				return $fragments;
			}

			/**
			 * Display the cart tab / widget
			 *
			 * @return void
			 */
			function woocommerce_cart_tab() {
				global $woocommerce;
				$skin        = get_option( 'wc_ct_skin' );
				$position    = get_option( 'wc_ct_horizontal_position' );
				$widget      = get_option( 'wc_ct_cart_widget' );
				$hide_widget = get_option( 'wc_ct_hide_empty_cart' );

				if ( 0 == $woocommerce->cart->get_cart_contents_count() && 'yes' == $hide_widget ) {
					/**
					 * Hide empty cart
					 * Compatible with WP Super Cache as long as "late init" is enabled
					 */
					$visibility	= 'hidden';
				} else {
					$visibility	= 'visible';
				}

				if ( ! is_cart() && ! is_checkout() ) {
					if ( 'yes' == $widget && ! wp_is_mobile() ) {
						echo '<div class="' . esc_attr( $position ) . ' cart-tab ' . esc_attr( $skin ) . ' ' . esc_attr( $visibility ) . '">';
					} else {
						echo '<div class="' . esc_attr( $position ) . ' cart-tab no-animation ' . esc_attr( $skin ) . ' ' . esc_attr( $visibility ) . '">';
					}

					wcct_cart_button();

					// Display the widget if specified.
					if ( 'yes' == $widget && ! wp_is_mobile() ) {
						// Check for WooCommerce 2.0 and display the cart widget.
						if ( version_compare( WOOCOMMERCE_VERSION, '2.0.0' ) >= 0 ) {
							the_widget( 'WC_Widget_Cart', 'title=' );
						} else {
							the_widget( 'WooCommerce_Widget_Cart', 'title=' );
						}
					}
					echo '</div>';
				}
			}
		}

		/**
		 * Displays the cart total and number of items as a link
		 *
		 * @return void
		 */
		function wcct_cart_button() {
			global $woocommerce;
			$link_total = get_option( 'wc_ct_link_display_total' );
			?>
			<a href="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'woocommerce-cart-tab' ); ?>" class="cart-parent">
				<?php
				if ( 'total' == $link_total ) {
					echo wp_kses_post( $woocommerce->cart->get_cart_total() );
				} elseif ( 'subtotal' == $link_total ) {
					echo wp_kses_post( $woocommerce->cart->get_cart_subtotal() );
				}
				echo '<span class="contents">' . sprintf( _n( '%d item', '%d items', intval( $woocommerce->cart->get_cart_contents_count() ), 'woocommerce-cart-tab' ), intval( $woocommerce->cart->get_cart_contents_count() ) ) . '</span>';
				?>
			</a>
			<?php
		}

		$woocommerce_cart_tab = new WC_ct();
	}
}
