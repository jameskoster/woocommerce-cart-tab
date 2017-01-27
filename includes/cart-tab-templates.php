<?php
if ( ! function_exists( 'woocommerce_cart_tab_button' ) ) {
	/**
	 * Displays the number of items in the cart with an icon
	 *
	 * @return void
	 */
	function woocommerce_cart_tab_button() {
		global $woocommerce;
		?>
		<div class="woocommerce-cart-tab">
			<svg class="woocommerce-cart-tab__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 508 620"><path class="woocommerce-cart-tab-icon__handle" d="M163.3 176.5c8.4-79.7 46.5-142 90.6-142 44.1 0 82.2 62.3 90.6 142 11.9-1.2 23.3-2.6 34.3-4C368.4 73.2 317.3 0 253.9 0c-63.4 0-114.5 73.2-124.8 172.4C140 173.9 151.4 175.2 163.3 176.5z"/><path class="woocommerce-cart-tab-icon__bag" d="M466.7 181.9c-21.7 3.5-51.4 8.8-86.3 13.4 -10.9 1.4-22.4 2.8-34.3 4 -28.6 2.9-59.6 4.9-92.2 4.9 -32.5 0-63.6-2-92.2-4.9 -11.9-1.2-23.4-2.6-34.3-4l0 0c-34.9-4.6-64.6-9.9-86.3-13.4L1.3 578.4C1.3 592.8 114.4 620 253.9 620s252.6-27.2 252.6-41.6L466.7 181.9z"/></svg>
			<?php
			echo '<span class="woocommerce-cart-tab__contents">' . intval( $woocommerce->cart->get_cart_contents_count() ) . '</span>';
			?>

			<script type="text/javascript">
			jQuery( '.woocommerce-cart-tab' ).click( function() {
				jQuery( '.woocommerce-cart-tab-container' ).toggleClass( 'woocommerce-cart-tab-container--visible' );
			});
			</script>
		</div>
		<?php
	}
}

if ( ! function_exists( 'woocommerce_cart_tab' ) ) {
	/**
	 * Display the cart tab / widget
	 *
	 * @return void
	 */
	function woocommerce_cart_tab() {
		if ( get_option( 'wc_ct_horizontal_position' ) ) {
			$position = get_option( 'wc_ct_horizontal_position' );
		} else {
			$position = get_theme_mod( 'woocommerce_cart_tab_position', 'right' );
		}

		if ( ! is_cart() && ! is_checkout() ) {
			echo '<div class="woocommerce-cart-tab-container woocommerce-cart-tab-container--' . esc_attr( $position ) . '">';

			woocommerce_cart_tab_button();

			the_widget( 'WC_Widget_Cart', 'title=' . __( 'Your Cart', 'woocommerce-cart-tab' ) );

			echo '</div>';
		}
	}
}
