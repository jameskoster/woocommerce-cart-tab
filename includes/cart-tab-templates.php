<?php
if ( ! function_exists( 'woocommerce_cart_tab_button' ) ) {
	/**
	 * Displays the number of items in the cart with an icon
	 *
	 * @return void
	 */
	function woocommerce_cart_tab_button() {
		global $woocommerce;

		$empty = 'woocommerce-cart-tab--empty';

		if ( intval( $woocommerce->cart->get_cart_contents_count() > 0 ) ) {
			$empty = 'woocommerce-cart-tab--has-contents';
		}
		?>
		<div class="woocommerce-cart-tab <?php echo $empty; ?>">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 86 104.5" class="woocommerce-cart-tab__icon">
<path class="woocommerce-cart-tab__icon-bag" d="M67.2,26.7C64.6,11.5,54.8,0.2,43.1,0.2C31.4,0.2,21.6,11.5,19,26.7H0.1v77.6h86V26.7H67.2z M43.1,4.2
	c9.6,0,17.7,9.6,20,22.6H23C25.4,13.8,33.5,4.2,43.1,4.2z M82.1,100.4h-78V30.7h14.4c-0.1,1.3-0.2,2.6-0.2,3.9c0,1.1,0,2.2,0.1,3.3
	c-0.8,0.6-1.4,1.6-1.4,2.8c0,1.9,1.6,3.5,3.5,3.5s3.5-1.6,3.5-3.5c0-1.2-0.6-2.3-1.6-2.9c-0.1-1-0.1-2-0.1-3.1
	c0-1.3,0.1-2.6,0.2-3.9h41.2c0.1,1.3,0.2,2.6,0.2,3.9c0,1,0,2.1-0.1,3.1c-1,0.6-1.6,1.7-1.6,2.9c0,1.9,1.6,3.5,3.5,3.5
	c1.9,0,3.5-1.6,3.5-3.5c0-1.1-0.5-2.1-1.4-2.8c0.1-1.1,0.1-2.2,0.1-3.3c0-1.3-0.1-2.6-0.2-3.9h14.4V100.4z"/>
</svg>

			<?php
			echo '<span class="woocommerce-cart-tab__contents">' . intval( $woocommerce->cart->get_cart_contents_count() ) . '</span>';
			?>

			<script type="text/javascript">
			jQuery( '.woocommerce-cart-tab' ).click( function() {
				jQuery( '.woocommerce-cart-tab-container' ).toggleClass( 'woocommerce-cart-tab-container--visible' );
				jQuery( 'body' ).toggleClass( 'woocommerce-cart-tab-is-visible' );
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

			do_action( 'wcct_before_cart_widget' );

			the_widget( 'WC_Widget_Cart', 'title=' . __( 'Your Cart', 'woocommerce-cart-tab' ) );

			echo '</div>';
		}
	}
}
