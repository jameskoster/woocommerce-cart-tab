/**
 * cart-tab.js
 *
 * Handles display of cart tab
 */
( function() {

	/**
	 * Reveal the cart
	 */
	function revealCart() {
		var windowWidth  = jQuery( window ).width();

		if ( windowWidth > 768 ) {
			if ( jQuery( '.woocommerce-cart-tab-container' ).hasClass( 'woocommerce-cart-tab-container--visible' ) ) {
				return;
			} else {
				jQuery( '.woocommerce-cart-tab-container' ).addClass( 'woocommerce-cart-tab-container--visible' );
			}

			jQuery( 'body' ).toggleClass( 'woocommerce-cart-tab-is-visible' );
		}
	}

	/**
	 * Hide the cart
	 */
	function hideCart() {
		var windowWidth  = jQuery( window ).width();

		if ( windowWidth > 768 ) {
			jQuery( '.woocommerce-cart-tab-container' ).removeClass( 'woocommerce-cart-tab-container--visible' );
		}

		jQuery( 'body' ).toggleClass( 'woocommerce-cart-tab-is-visible' );
	}

	/**
	 * Make the cart tab height match the widow height.
	 */
	function setCartHeight() {
		var windowHeight = jQuery( window ).height();
		var windowWidth  = jQuery( window ).width();

		if ( windowWidth > 768 ) {
			if ( jQuery( 'body' ).hasClass( 'admin-bar' ) ) {
				jQuery( '.woocommerce-cart-tab-container .widget_shopping_cart' ).css( 'height', windowHeight - 32 );
			} else {
				jQuery( '.woocommerce-cart-tab-container .widget_shopping_cart' ).css( 'height', windowHeight );
			}
		}
	}

	/**
	 * On mouseup
	 */
	jQuery( document ).mouseup( function( e ) {

		/**
		 * Hide the cart when user clicks outside it.
		 */
		var container = jQuery( '.woocommerce-cart-tab-container' );

		if ( ! jQuery( '.button.add_to_cart_button' ).is( e.target ) && ! container.is( e.target ) && container.has( e.target ).length === 0 && container.hasClass( 'woocommerce-cart-tab-container--visible' ) ) {
			container.removeClass( 'woocommerce-cart-tab-container--visible' );
			jQuery( 'body' ).removeClass( 'woocommerce-cart-tab-is-visible' );
		}
	});


	/**
	 * On document ready
	 */
	jQuery( document ).ready( function() {

		jQuery( 'body' ).on( 'added_to_cart', function() {
			revealCart();
		});

		setCartHeight();

		/**
		 * Hide cart tab when cart is empty
		 */
		jQuery( 'body' ).on( 'removed_from_cart', function() {
				if ( Cookies.get( 'woocommerce_items_in_cart' ) == null ) {
					hideCart();
				}
		});
	});

	/**
	 * On window resize
	 */
	jQuery( window ).resize( function() {
		setCartHeight();
	});
} )();
