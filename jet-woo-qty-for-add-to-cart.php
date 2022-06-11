<?php
/**
 * Plugin Name: Jet WooCommerce Qty Input
 * Plugin URI:  
 * Description: Add qty input t Add to cart shortcode.
 * Version:     1.0.0
 * Author:      Crocoblock
 * Author URI:  https://crocoblock.com/
 * License:     GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die();
}

class Jet_Woo_Qty_For_Add_To_Cart {

	private $print_js = true;

	public function __construct() {

		add_shortcode( 'jet_woo_add_to_cart_with_qty', array( $this, 'shortcode' ) );
	}

	public function shortcode( $atts ) {
		
		global $post;

		if ( empty( $atts ) ) {
			return '';
		}

		$atts = shortcode_atts(
			array(
				'id'         => '',
				'class'      => '',
				'quantity'   => '1',
				'sku'        => '',
			),
			$atts,
			'jet_woo_add_to_cart_with_qty'
		);

		if ( ! empty( $atts['id'] ) ) {
			$product_data = get_post( $atts['id'] );
		} elseif ( ! empty( $atts['sku'] ) ) {
			$product_id   = wc_get_product_id_by_sku( $atts['sku'] );
			$product_data = get_post( $product_id );
		} else {
			return '';
		}

		$product = is_object( $product_data ) && in_array( $product_data->post_type, array( 'product', 'product_variation' ), true ) ? wc_setup_product_data( $product_data ) : false;

		ob_start();

		echo '<div class="jet-woo-add-to-cart">';

		if ( in_array( $product->get_type(), array( 'simple', 'grouped' ) ) ) {
			woocommerce_quantity_input( array(
				'min_value'   => $product->get_min_purchase_quantity(),
				'max_value'   => $product->get_max_purchase_quantity(),
				'input_id'    => 'jet_product_' . $product->get_id(),
				'classes'     => array( 'input-text', 'qty', 'text', 'jet-woo-loop-qty' ),
				'input_value' => isset( $args['quantity'] ) ? wc_stock_amount( $args['quantity'] ) : $product->get_min_purchase_quantity(),
			), $product, true );
		}

		woocommerce_template_loop_add_to_cart(
			array(
				'quantity' => $atts['quantity'],
			)
		);

		if ( $this->print_js ) {
			$this->print_js = false;
			echo '<script>
			(function( $ ) {
			
				"use strict";

				$( document ).on( \'change\', \'.jet-woo-loop-qty\', function( event ) {
					var $this = $( this );
					$this.closest( \'.jet-woo-add-to-cart\' ).find( \'a.add_to_cart_button\' ).data( \'quantity\', $this.val() ).attr( \'data-quantity\', $this.val() );
				} );

			})( jQuery );
			</script>';
		}

		echo '</div>';

		// Restore Product global in case this is shown inside a product post.
		wc_setup_product_data( $post );

		return ob_get_clean();
	}

}

new Jet_Woo_Qty_For_Add_To_Cart();
