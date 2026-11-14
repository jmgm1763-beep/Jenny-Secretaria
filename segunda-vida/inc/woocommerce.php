<?php
/**
 * Integración con WooCommerce: estructura de catálogo, ficha y modo catálogo.
 */
defined( 'ABSPATH' ) || exit;

/* ---------- Estructura general ---------- */

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

add_action( 'woocommerce_before_main_content', function () {
	echo '<main id="contenido" class="sv-main sv-container">';
}, 5 );
add_action( 'woocommerce_after_main_content', function () {
	echo '</main>';
}, 50 );

add_filter( 'woocommerce_breadcrumb_defaults', function ( $args ) {
	$args['delimiter']   = '<span class="sv-breadcrumb__sep" aria-hidden="true">/</span>';
	$args['wrap_before'] = '<nav class="woocommerce-breadcrumb sv-breadcrumb" aria-label="' . esc_attr__( 'Ruta de navegación', 'segunda-vida' ) . '">';
	return $args;
} );

// Tarjetas en proporción 4:5, como en las plataformas de moda de segunda mano.
add_filter( 'woocommerce_get_image_size_thumbnail', function () {
	return array( 'width' => 600, 'height' => 750, 'crop' => 1 );
} );

add_filter( 'loop_shop_per_page', function () {
	return 24;
} );
add_filter( 'loop_shop_columns', function () {
	return 3;
} );

/* ---------- Cabecera: contador del carrito ---------- */

function sv_cart_count_html() {
	$count = ( function_exists( 'WC' ) && WC()->cart ) ? WC()->cart->get_cart_contents_count() : 0;
	return '<span class="sv-count sv-cart-count"' . ( $count ? '' : ' hidden' ) . '>' . (int) $count . '</span>';
}
add_filter( 'woocommerce_add_to_cart_fragments', function ( $fragments ) {
	$fragments['span.sv-cart-count'] = sv_cart_count_html();
	return $fragments;
} );

/* ---------- Catálogo: filtros laterales ---------- */

function sv_filters_open() {
	echo '<div class="sv-shop"><aside class="sv-filters" aria-label="' . esc_attr__( 'Filtros', 'segunda-vida' ) . '">';
	sv_shop_filters();
	echo '</aside><div class="sv-shop__results">';
}
function sv_filters_close() {
	echo '</div></div>';
}
add_action( 'woocommerce_before_shop_loop', 'sv_filters_open', 5 );
add_action( 'woocommerce_after_shop_loop', 'sv_filters_close', 99 );
add_action( 'woocommerce_no_products_found', 'sv_filters_open', 1 );
add_action( 'woocommerce_no_products_found', 'sv_filters_close', 99 );

add_action( 'woocommerce_before_shop_loop', function () {
	echo '<div class="sv-toolbar">';
}, 15 );
add_action( 'woocommerce_before_shop_loop', function () {
	echo '</div>';
}, 35 );

function sv_current_filter_url() {
	global $wp;
	$url = home_url( trailingslashit( preg_replace( '#/?page/\d+/?$#', '', $wp->request ) ) );
	foreach ( array( 'estado', 'min_price', 'max_price', 'orderby', 's', 'post_type' ) as $key ) {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- filtros públicos de solo lectura.
		if ( isset( $_GET[ $key ] ) && '' !== $_GET[ $key ] ) {
			$url = add_query_arg( $key, rawurlencode( sanitize_text_field( wp_unslash( $_GET[ $key ] ) ) ), $url ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		}
	}
	return $url;
}

function sv_shop_filters() {
	$base       = sv_current_filter_url();
	$current    = get_query_var( 'estado' );
	$queried    = get_queried_object();
	$active_cat = is_tax( 'product_cat' ) ? get_query_var( 'product_cat' ) : '';
	// phpcs:disable WordPress.Security.NonceVerification.Recommended
	$min        = isset( $_GET['min_price'] ) ? absint( $_GET['min_price'] ) : '';
	$max        = isset( $_GET['max_price'] ) ? absint( $_GET['max_price'] ) : '';
	$has_filter = $current || '' !== $min || '' !== $max;
	// phpcs:enable

	echo '<details class="sv-filters__panel" open><summary>' . sv_icon( 'filter' ) . '<span>' . esc_html__( 'Filtros', 'segunda-vida' ) . '</span></summary>';

	// Categorías.
	$cats = get_terms( array(
		'taxonomy'   => 'product_cat',
		'parent'     => 0,
		'hide_empty' => true,
		'exclude'    => array( (int) get_option( 'default_product_cat' ) ),
	) );
	if ( $cats && ! is_wp_error( $cats ) ) {
		echo '<div class="sv-filter"><h2 class="sv-filter__title">' . esc_html__( 'Categoría', 'segunda-vida' ) . '</h2><ul class="sv-filter__list">';
		printf(
			'<li><a href="%s"%s>%s</a></li>',
			esc_url( sv_shop_url() ),
			$active_cat ? '' : ' aria-current="true"',
			esc_html__( 'Todo', 'segunda-vida' )
		);
		foreach ( $cats as $cat ) {
			printf(
				'<li><a href="%s"%s>%s <span class="sv-filter__count">%d</span></a></li>',
				esc_url( get_term_link( $cat ) ),
				$active_cat === $cat->slug ? ' aria-current="true"' : '',
				esc_html( $cat->name ),
				(int) $cat->count
			);
			$children = get_terms( array( 'taxonomy' => 'product_cat', 'parent' => $cat->term_id, 'hide_empty' => true ) );
			$is_open  = $queried instanceof WP_Term && ( $queried->term_id === $cat->term_id || $queried->parent === $cat->term_id );
			if ( $is_open && $children && ! is_wp_error( $children ) ) {
				echo '<li><ul class="sv-filter__list sv-filter__list--sub">';
				foreach ( $children as $child ) {
					printf(
						'<li><a href="%s"%s>%s</a></li>',
						esc_url( get_term_link( $child ) ),
						$active_cat === $child->slug ? ' aria-current="true"' : '',
						esc_html( $child->name )
					);
				}
				echo '</ul></li>';
			}
		}
		echo '</ul></div>';
	}

	// Estado de conservación.
	$estados = get_terms( array( 'taxonomy' => 'sv_estado', 'hide_empty' => true, 'orderby' => 'term_id' ) );
	if ( $estados && ! is_wp_error( $estados ) ) {
		echo '<div class="sv-filter"><h2 class="sv-filter__title">' . esc_html__( 'Estado', 'segunda-vida' ) . '</h2><ul class="sv-filter__list">';
		foreach ( $estados as $estado ) {
			$is_active = $current === $estado->slug;
			$url       = $is_active ? remove_query_arg( 'estado', $base ) : add_query_arg( 'estado', $estado->slug, $base );
			printf(
				'<li><a class="sv-check" href="%s"%s rel="nofollow"><span class="sv-check__box" aria-hidden="true"></span>%s</a></li>',
				esc_url( $url ),
				$is_active ? ' aria-current="true"' : '',
				esc_html( $estado->name )
			);
		}
		echo '</ul></div>';
	}

	// Precio.
	echo '<div class="sv-filter"><h2 class="sv-filter__title">' . esc_html__( 'Precio', 'segunda-vida' ) . '</h2>';
	echo '<form class="sv-price" method="get" action="' . esc_url( remove_query_arg( array( 'min_price', 'max_price', 'estado', 'orderby', 's', 'post_type' ), $base ) ) . '">';
	foreach ( array( 'estado', 'orderby', 's', 'post_type' ) as $key ) {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( isset( $_GET[ $key ] ) && '' !== $_GET[ $key ] ) {
			printf( '<input type="hidden" name="%s" value="%s">', esc_attr( $key ), esc_attr( sanitize_text_field( wp_unslash( $_GET[ $key ] ) ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		}
	}
	printf(
		'<label><span class="screen-reader-text">%1$s</span><input type="number" name="min_price" min="0" inputmode="numeric" placeholder="%1$s" value="%2$s"></label>',
		esc_attr__( 'Mín. €', 'segunda-vida' ),
		esc_attr( $min )
	);
	printf(
		'<label><span class="screen-reader-text">%1$s</span><input type="number" name="max_price" min="0" inputmode="numeric" placeholder="%1$s" value="%2$s"></label>',
		esc_attr__( 'Máx. €', 'segunda-vida' ),
		esc_attr( $max )
	);
	echo '<button type="submit" class="sv-btn sv-btn--ghost sv-btn--small">' . esc_html__( 'Aplicar', 'segunda-vida' ) . '</button></form></div>';

	if ( $has_filter ) {
		printf(
			'<a class="sv-filters__clear" href="%s">%s</a>',
			esc_url( remove_query_arg( array( 'estado', 'min_price', 'max_price' ), $base ) ),
			esc_html__( 'Quitar filtros', 'segunda-vida' )
		);
	}

	echo '</details>';
}

/* ---------- Ficha de artículo ---------- */

// En artículos únicos de segunda mano no tienen sentido las valoraciones ni las pestañas.
add_filter( 'woocommerce_product_tabs', function ( $tabs ) {
	unset( $tabs['reviews'], $tabs['additional_information'] );
	return $tabs;
}, 98 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

add_filter( 'woocommerce_output_related_products_args', function ( $args ) {
	$args['posts_per_page'] = 4;
	$args['columns']        = 4;
	return $args;
} );
add_filter( 'woocommerce_product_related_products_heading', function () {
	return __( 'También te puede gustar', 'segunda-vida' );
} );
add_filter( 'woocommerce_product_description_heading', '__return_empty_string' );

// Marca sobre el título.
add_action( 'woocommerce_single_product_summary', function () {
	global $product;
	$brand = sv_term_name( $product->get_id(), 'product_brand' );
	if ( $brand ) {
		echo '<p class="sv-product__brand">' . esc_html( $brand ) . '</p>';
	}
}, 4 );

// Estado y talla, justo bajo el precio.
add_action( 'woocommerce_single_product_summary', function () {
	global $product;
	$estado = sv_term_name( $product->get_id(), 'sv_estado' );
	$talla  = $product->get_meta( '_sv_talla' );
	if ( ! $estado && ! $talla ) {
		return;
	}
	echo '<ul class="sv-chips">';
	if ( $estado ) {
		echo '<li class="sv-chip sv-chip--accent">' . esc_html( $estado ) . '</li>';
	}
	if ( $talla ) {
		echo '<li class="sv-chip">' . esc_html( $talla ) . '</li>';
	}
	echo '</ul>';
}, 11 );

// Ficha técnica.
add_action( 'woocommerce_single_product_summary', function () {
	global $product;
	$cats = wc_get_product_category_list( $product->get_id(), ', ' );
	$rows = array_filter( array(
		__( 'Categoría', 'segunda-vida' )       => $cats ? wp_kses_post( $cats ) : '',
		__( 'Marca', 'segunda-vida' )           => esc_html( sv_term_name( $product->get_id(), 'product_brand' ) ),
		__( 'Estado', 'segunda-vida' )          => esc_html( sv_term_name( $product->get_id(), 'sv_estado' ) ),
		__( 'Talla / medidas', 'segunda-vida' ) => esc_html( $product->get_meta( '_sv_talla' ) ),
		__( 'Material', 'segunda-vida' )        => esc_html( $product->get_meta( '_sv_material' ) ),
		__( 'Color', 'segunda-vida' )           => esc_html( $product->get_meta( '_sv_color' ) ),
		__( 'Referencia', 'segunda-vida' )      => esc_html( $product->get_sku() ),
	) );
	if ( ! $rows ) {
		return;
	}
	echo '<dl class="sv-specs">';
	foreach ( $rows as $label => $value ) {
		echo '<div><dt>' . esc_html( $label ) . '</dt><dd>' . $value . '</dd></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escapado arriba.
	}
	echo '</dl>';
}, 25 );

// Botones de otras plataformas y WhatsApp.
add_action( 'woocommerce_single_product_summary', function () {
	global $product;
	$links    = $product->is_in_stock() ? sv_product_marketplaces( $product ) : array();
	$whatsapp = sv_whatsapp_url( sprintf(
		/* translators: 1: nombre del artículo, 2: URL. */
		__( 'Hola, me interesa «%1$s»: %2$s', 'segunda-vida' ),
		$product->get_name(),
		$product->get_permalink()
	) );
	if ( ! $links && ! $whatsapp ) {
		return;
	}
	echo '<div class="sv-channels">';
	if ( $links ) {
		$purchasable = $product->is_purchasable();
		echo '<p class="sv-channels__label">' . esc_html( $purchasable ? __( 'También disponible en', 'segunda-vida' ) : __( 'Cómpralo en', 'segunda-vida' ) ) . '</p>';
		foreach ( $links as $name => $url ) {
			printf(
				'<a class="sv-btn %s" href="%s" target="_blank" rel="noopener nofollow">%s</a>',
				$purchasable ? 'sv-btn--ghost' : 'sv-btn--primary',
				esc_url( $url ),
				/* translators: %s: nombre de la plataforma. */
				esc_html( sprintf( __( 'Comprar en %s', 'segunda-vida' ), $name ) )
			);
		}
	}
	if ( $whatsapp ) {
		printf(
			'<a class="sv-btn sv-btn--ghost" href="%s" target="_blank" rel="noopener">%s<span>%s</span></a>',
			esc_url( $whatsapp ),
			sv_icon( 'chat' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			esc_html__( 'Preguntar por WhatsApp', 'segunda-vida' )
		);
	}
	echo '</div>';
}, 32 );

// Mensajes de confianza en la ficha.
add_action( 'woocommerce_single_product_summary', function () {
	echo '<ul class="sv-assurance">';
	foreach ( array( 1 => 'check', 2 => 'lock', 3 => 'box' ) as $i => $icon ) {
		$title = sv_opt( "trust_{$i}_title" );
		if ( $title ) {
			echo '<li>' . sv_icon( $icon ) . '<span><strong>' . esc_html( $title ) . '</strong> ' . esc_html( sv_opt( "trust_{$i}_text" ) ) . '</span></li>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
	echo '</ul>';
}, 45 );

add_filter( 'woocommerce_get_availability_text', function ( $text, $product ) {
	if ( ! $product->is_in_stock() ) {
		return __( 'Vendido — este artículo ya ha encontrado nueva casa.', 'segunda-vida' );
	}
	// «1 disponible» no aporta nada cuando todo el catálogo son piezas únicas.
	return $product->is_sold_individually() ? '' : $text;
}, 10, 2 );

add_filter( 'woocommerce_sale_flash', function ( $html, $post, $product ) {
	$regular = (float) $product->get_regular_price();
	$sale    = (float) $product->get_sale_price();
	if ( $regular > 0 && $sale > 0 && $sale < $regular ) {
		return '<span class="onsale">-' . round( ( 1 - $sale / $regular ) * 100 ) . '%</span>';
	}
	return $html;
}, 10, 3 );

/* ---------- Modo catálogo ---------- */

add_filter( 'woocommerce_is_purchasable', function ( $purchasable ) {
	return sv_opt( 'catalog_mode' ) ? false : $purchasable;
} );
