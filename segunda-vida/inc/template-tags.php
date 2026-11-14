<?php
defined( 'ABSPATH' ) || exit;

/**
 * Valores por defecto de las opciones del tema (Apariencia → Personalizar).
 */
function sv_defaults() {
	return array(
		'announcement'  => __( 'Piezas únicas, revisadas una a una · Envíos a toda la península', 'segunda-vida' ),
		'hero_eyebrow'  => __( 'Segunda mano con criterio', 'segunda-vida' ),
		'hero_title'    => __( 'Cosas bonitas que merecen una segunda vida', 'segunda-vida' ),
		'hero_text'     => __( 'Ropa, mobiliario y decoración seleccionados y cuidados. Cada artículo es único: cuando se vende, no vuelve.', 'segunda-vida' ),
		'hero_cta'      => __( 'Ver novedades', 'segunda-vida' ),
		'hero_image'    => '',
		'story_title'   => __( 'Cada pieza tiene una historia', 'segunda-vida' ),
		'story_text'    => __( 'Comprar de segunda mano es elegir objetos con carácter, pagar un precio justo y alargar la vida de lo que ya existe. Describimos cada artículo con detalle y fotos reales para que sepas exactamente lo que recibes.', 'segunda-vida' ),
		'trust_1_title' => __( 'Revisado a mano', 'segunda-vida' ),
		'trust_1_text'  => __( 'Estado descrito con honestidad y fotos reales.', 'segunda-vida' ),
		'trust_2_title' => __( 'Pago seguro', 'segunda-vida' ),
		'trust_2_text'  => __( 'Tarjeta, Bizum o transferencia con total garantía.', 'segunda-vida' ),
		'trust_3_title' => __( 'Envío cuidado', 'segunda-vida' ),
		'trust_3_text'  => __( 'Embalaje protegido y seguimiento del pedido.', 'segunda-vida' ),
		'vinted_url'    => '',
		'wallapop_url'  => '',
		'instagram_url' => '',
		'whatsapp'      => '',
		'catalog_mode'  => false,
		'budget_price'  => 25,
	);
}

function sv_opt( $key ) {
	$defaults = sv_defaults();
	return get_theme_mod( 'sv_' . $key, isset( $defaults[ $key ] ) ? $defaults[ $key ] : '' );
}

function sv_icon( $name ) {
	$paths = array(
		'search' => '<circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/>',
		'heart'  => '<path d="M12 20.5s-7.5-4.6-7.5-10.2A4.3 4.3 0 0 1 12 7.6a4.3 4.3 0 0 1 7.5 2.7c0 5.6-7.5 10.2-7.5 10.2Z"/>',
		'user'   => '<circle cx="12" cy="8" r="4"/><path d="M4.5 20.5c1.2-3.6 4-5.5 7.5-5.5s6.3 1.9 7.5 5.5"/>',
		'bag'    => '<path d="M5 8h14l-1 12.5H6L5 8Z"/><path d="M9 8V6.5a3 3 0 0 1 6 0V8"/>',
		'menu'   => '<path d="M4 7h16M4 12h16M4 17h16"/>',
		'close'  => '<path d="m6 6 12 12M18 6 6 18"/>',
		'check'  => '<path d="M12 3 5 6v5.5c0 4.3 2.9 7.7 7 9.5 4.1-1.8 7-5.2 7-9.5V6l-7-3Z"/><path d="m9 12 2.2 2.2L15.2 10"/>',
		'lock'   => '<rect x="5" y="10.5" width="14" height="10" rx="2"/><path d="M8.5 10.5V7.5a3.5 3.5 0 0 1 7 0v3"/>',
		'box'    => '<path d="m3.5 7.5 8.5-4 8.5 4v9l-8.5 4-8.5-4v-9Z"/><path d="m3.5 7.5 8.5 4 8.5-4M12 11.5v9"/>',
		'arrow'  => '<path d="M5 12h14m-5-5 5 5-5 5"/>',
		'filter' => '<path d="M4 7h16M7 12h10M10 17h4"/>',
		'chat'   => '<path d="M4.5 19.5 6 15.8A7.5 7.5 0 1 1 9 18.6l-4.5.9Z"/>',
	);
	if ( ! isset( $paths[ $name ] ) ) {
		return '';
	}
	return '<svg class="sv-icon" viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $paths[ $name ] . '</svg>';
}

function sv_shop_url() {
	return function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
}

function sv_favorites_page_id() {
	$pages = get_posts( array(
		'post_type'   => 'page',
		'post_status' => 'publish',
		'meta_key'    => '_wp_page_template',
		'meta_value'  => 'page-templates/favoritos.php',
		'numberposts' => 1,
		'fields'      => 'ids',
	) );
	return $pages ? (int) $pages[0] : 0;
}

function sv_favorites_url() {
	$id = sv_favorites_page_id();
	return $id ? get_permalink( $id ) : '';
}

function sv_whatsapp_url( $message = '' ) {
	$number = preg_replace( '/\D+/', '', (string) sv_opt( 'whatsapp' ) );
	if ( ! $number ) {
		return '';
	}
	$url = 'https://wa.me/' . $number;
	return $message ? $url . '?text=' . rawurlencode( $message ) : $url;
}

/**
 * Perfiles de la tienda en otras plataformas (cabecera de portada y pie).
 */
function sv_shop_profiles() {
	$profiles = array();
	if ( sv_opt( 'vinted_url' ) ) {
		$profiles['Vinted'] = sv_opt( 'vinted_url' );
	}
	if ( sv_opt( 'wallapop_url' ) ) {
		$profiles['Wallapop'] = sv_opt( 'wallapop_url' );
	}
	return $profiles;
}

function sv_term_name( $product_id, $taxonomy ) {
	if ( ! taxonomy_exists( $taxonomy ) ) {
		return '';
	}
	$terms = get_the_terms( $product_id, $taxonomy );
	return ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';
}

/**
 * Pinta una rejilla de productos reutilizando la tarjeta del catálogo.
 *
 * @param int[] $ids IDs de producto.
 */
function sv_render_products( $ids ) {
	if ( ! $ids ) {
		return;
	}
	global $post;
	woocommerce_product_loop_start();
	foreach ( $ids as $id ) {
		$post = get_post( $id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		setup_postdata( $post );
		wc_get_template_part( 'content', 'product' );
	}
	woocommerce_product_loop_end();
	wp_reset_postdata();
}

function sv_primary_nav() {
	if ( has_nav_menu( 'primary' ) ) {
		wp_nav_menu( array(
			'theme_location' => 'primary',
			'container'      => false,
			'menu_class'     => 'sv-nav__list',
			'depth'          => 1,
		) );
		return;
	}
	// Sin menú asignado: se muestran las categorías principales de producto.
	echo '<ul class="sv-nav__list">';
	if ( taxonomy_exists( 'product_cat' ) ) {
		$cats = get_terms( array(
			'taxonomy'   => 'product_cat',
			'parent'     => 0,
			'hide_empty' => true,
			'exclude'    => array( (int) get_option( 'default_product_cat' ) ),
			'number'     => 8,
		) );
		if ( ! is_wp_error( $cats ) ) {
			foreach ( $cats as $cat ) {
				printf( '<li><a href="%s">%s</a></li>', esc_url( get_term_link( $cat ) ), esc_html( $cat->name ) );
			}
		}
		printf( '<li><a href="%s">%s</a></li>', esc_url( sv_shop_url() ), esc_html__( 'Ver todo', 'segunda-vida' ) );
	}
	echo '</ul>';
}
