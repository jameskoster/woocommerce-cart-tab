<?php
/*
Plugin Name: WooCommerce Cart Tab
Plugin URI: http://jameskoster.co.uk/tag/cart-tab/
Version: 0.1
Description: Displays a sitewide link to the cart which reveals the cart contents on hover.
Author: jameskoster
Tested up to: 3.5
Author URI: http://jameskoster.co.uk

	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	/**
	 * Localisation
	 **/
	load_plugin_textdomain( 'woocommerce-cart-tab', false, dirname( plugin_basename( __FILE__ ) ) . '/' );


	/**
	 * Accepted Payment Methods class
	 **/
	if ( ! class_exists( 'WC_ct' ) ) {

		class WC_ct {

			public function __construct() {
				add_action( 'wp_enqueue_scripts', array( &$this, 'setup_styles' ) );				// Enqueue the styles
				add_action( 'wp_footer', array( &$this, 'woocommerce_cart_tab' ) ); 				// The cart tab function
				add_filter( 'add_to_cart_fragments', array( &$this, 'wcct_add_to_cart_fragment' ) ); // The cart fragment

				// Init settings
				$this->settings = array(
					array(
						'name' => __( 'Cart Tab', 'woocommerce-cart-tab' ),
						'type' => 'title',
						'id' => 'wc_ct_options'
					),
					array(
						'name' 		=> __( 'Cart Widget', 'woocommerce-cart-tab' ),
						'desc_tip' 	=> __( 'Display the cart widget on hover', 'woocommerce-cart-tab' ),
						'id' 		=> 'wc_ct_cart_widget',
						'type' 		=> 'checkbox'
					),
					array(
						'name' 		=> __( 'Use the light or dark skin', 'woocommerce-cart-tab' ),
						'id' 		=> 'wc_ct_skin',
						'type' 		=> 'select',
						'options' 	=> array(
							'light' => __( 'Light', 'woocommerce-cart-tab' ) ,
							'dark' 	=> __( 'Dark', 'woocommerce-cart-tab' )
						)
					),
					array(
						'name' 		=> __( 'Position the cart tab on the right or left', 'woocommerce-cart-tab' ),
						'id' 		=> 'wc_ct_horizontal_position',
						'type' 		=> 'select',
						'options' 	=> array(
							'right' => __( 'Right', 'woocommerce-cart-tab' ) ,
							'left' 	=> __( 'Left', 'woocommerce-cart-tab' )
						)
					),
					array( 'type' => 'sectionend', 'id' => 'wc_ct_options' ),
				);


				// Default options
				add_option( 'wc_ct_cart_widget', 'yes' );
				add_option( 'wc_ct_skin', 'light' );
				add_option( 'wc_ct_horizontal_position', 'right' );


				// Admin
				add_action( 'woocommerce_settings_image_options_after', array( &$this, 'admin_settings' ), 20);
				add_action( 'woocommerce_update_options_catalog', array( &$this, 'save_admin_settings' ) );
			}


	        /*-----------------------------------------------------------------------------------*/
			/* Class Functions */
			/*-----------------------------------------------------------------------------------*/

			// Load the settings
			function admin_settings() {
				woocommerce_admin_fields( $this->settings );
			}


			// Save the settings
			function save_admin_settings() {
				woocommerce_update_options( $this->settings );
			}


			// Setup styles
			function setup_styles() {
				if ( ! is_cart() && ! is_checkout() ) {
					wp_enqueue_style( 'ct-styles', plugins_url( '/assets/css/style.css', __FILE__ ) );
				}
			}


			// The cart fragment (ensures the cart button updates via AJAX)
			function wcct_add_to_cart_fragment( $fragments ) {
				global $woocommerce;
				ob_start();
				wcct_cart_button();
				$fragments['a.cart-parent'] = ob_get_clean();
				return $fragments;
			}


			/*-----------------------------------------------------------------------------------*/
			/* Frontend Functions */
			/*-----------------------------------------------------------------------------------*/

			// Display the cart tab and widget
			function woocommerce_cart_tab() {
				global $woocommerce;
				$skin = get_option( 'wc_ct_skin' );
				$position = get_option( 'wc_ct_horizontal_position' );
				$widget = get_option( 'wc_ct_cart_widget' );
				if ( ! is_cart() && ! is_checkout() ) {
					if ( $widget == 'yes' ) {
						echo '<div class="' . $position . ' cart-tab ' . $skin . '">';
					} else {
						echo '<div class="' . $position . ' cart-tab no-animation ' . $skin . '">';
					}
						wcct_cart_button();
						// Display the widget if specified
						if ( $widget == 'yes' ) {
							// Check for WooCommerce 2.0 and display the cart widget
							if ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) >= 0 ) {
								the_widget( 'WC_Widget_Cart', 'title=' );
							} else {
								the_widget( 'WooCommerce_Widget_Cart', 'title=' );
							}
						}
					echo '</div>';
				}
			}
		}


		// Displays the cart total and number of items as a link
		function wcct_cart_button() {
			global $woocommerce;
			?>
			<a href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart', 'woocommerce-cart-tab' ); ?>" class="cart-parent">
				<?php
					echo $woocommerce->cart->get_cart_total();
					echo '<span class="contents">' . sprintf( _n( '%d item', '%d items', $woocommerce->cart->get_cart_contents_count(), 'woocommerce-cart-tab' ), $woocommerce->cart->get_cart_contents_count() ) . '</span>';
				?>
			</a>
			<?php
		}


		$WC_ct = new WC_ct();
	}
}