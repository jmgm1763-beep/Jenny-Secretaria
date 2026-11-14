<?php
/**
 * Campos propios de cada artículo: ficha técnica y enlaces a otras plataformas.
 */
defined( 'ABSPATH' ) || exit;

function sv_product_fields() {
	return array(
		'_sv_talla'        => array( __( 'Talla / medidas', 'segunda-vida' ), 'text', __( 'Ej.: «M», «38» o «80 × 45 × 90 cm».', 'segunda-vida' ) ),
		'_sv_material'     => array( __( 'Material', 'segunda-vida' ), 'text', '' ),
		'_sv_color'        => array( __( 'Color', 'segunda-vida' ), 'text', '' ),
		'_sv_vinted_url'   => array( __( 'Enlace del artículo en Vinted', 'segunda-vida' ), 'url', __( 'Si lo rellenas, la ficha mostrará el botón «Comprar en Vinted».', 'segunda-vida' ) ),
		'_sv_wallapop_url' => array( __( 'Enlace del artículo en Wallapop', 'segunda-vida' ), 'url', '' ),
		'_sv_otro_label'   => array( __( 'Otra plataforma: nombre', 'segunda-vida' ), 'text', __( 'Ej.: «Etsy», «Milanuncios», «eBay».', 'segunda-vida' ) ),
		'_sv_otro_url'     => array( __( 'Otra plataforma: enlace', 'segunda-vida' ), 'url', '' ),
	);
}

add_action( 'woocommerce_product_options_general_product_data', function () {
	echo '<div class="options_group">';
	foreach ( sv_product_fields() as $key => $field ) {
		woocommerce_wp_text_input( array(
			'id'          => $key,
			'label'       => $field[0],
			'type'        => $field[1],
			'description' => $field[2],
			'desc_tip'    => (bool) $field[2],
		) );
	}
	echo '</div>';
} );

add_action( 'woocommerce_admin_process_product_object', function ( $product ) {
	foreach ( sv_product_fields() as $key => $field ) {
		// phpcs:ignore WordPress.Security.NonceVerification.Missing -- WooCommerce valida el nonce antes de este hook.
		$raw   = isset( $_POST[ $key ] ) ? wp_unslash( $_POST[ $key ] ) : '';
		$value = 'url' === $field[1] ? esc_url_raw( $raw ) : sanitize_text_field( $raw );
		if ( '' === $value ) {
			$product->delete_meta_data( $key );
		} else {
			$product->update_meta_data( $key, $value );
		}
	}

	// Artículo único: la primera vez que se guarda se fija 1 unidad en stock,
	// de modo que al venderse pase a «Vendido» automáticamente.
	if ( $product->is_type( 'simple' ) && ! $product->get_meta( '_sv_unique_init' ) ) {
		if ( ! $product->get_manage_stock() ) {
			$product->set_manage_stock( true );
			$product->set_stock_quantity( 1 );
		}
		$product->set_sold_individually( true );
		$product->update_meta_data( '_sv_unique_init', '1' );
	}
} );

/**
 * Enlaces de un artículo en otras plataformas.
 *
 * @return array<string,string> nombre => URL.
 */
function sv_product_marketplaces( $product ) {
	$links = array();
	if ( $product->get_meta( '_sv_vinted_url' ) ) {
		$links['Vinted'] = $product->get_meta( '_sv_vinted_url' );
	}
	if ( $product->get_meta( '_sv_wallapop_url' ) ) {
		$links['Wallapop'] = $product->get_meta( '_sv_wallapop_url' );
	}
	if ( $product->get_meta( '_sv_otro_url' ) ) {
		$label           = $product->get_meta( '_sv_otro_label' );
		$links[ $label ? $label : __( 'otra plataforma', 'segunda-vida' ) ] = $product->get_meta( '_sv_otro_url' );
	}
	return $links;
}

/**
 * Línea resumen para la tarjeta: «Talla M · Muy buen estado».
 */
function sv_product_meta_line( $product ) {
	$parts = array_filter( array(
		$product->get_meta( '_sv_talla' ),
		sv_term_name( $product->get_id(), 'sv_estado' ),
	) );
	return implode( ' · ', $parts );
}
