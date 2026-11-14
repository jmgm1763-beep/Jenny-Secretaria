<?php
defined( 'ABSPATH' ) || exit;

add_action( 'after_setup_theme', function () {
	load_theme_textdomain( 'segunda-vida', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array( 'height' => 80, 'width' => 320, 'flex-width' => true, 'flex-height' => true ) );

	add_theme_support( 'woocommerce', array(
		'thumbnail_image_width' => 600,
		'single_image_width'    => 1000,
	) );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	register_nav_menus( array(
		'primary' => __( 'Menú principal (categorías)', 'segunda-vida' ),
		'footer'  => __( 'Menú del pie (ayuda y legal)', 'segunda-vida' ),
	) );
} );

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'segunda-vida', get_stylesheet_uri(), array(), SV_VERSION );
	wp_enqueue_script( 'segunda-vida', get_template_directory_uri() . '/assets/js/main.js', array(), SV_VERSION, true );
	wp_localize_script( 'segunda-vida', 'svData', array(
		'storeApi' => esc_url_raw( rest_url( 'wc/store/v1/products' ) ),
		'i18n'     => array(
			'add'    => __( 'Guardar en favoritos', 'segunda-vida' ),
			'remove' => __( 'Quitar de favoritos', 'segunda-vida' ),
			'empty'  => __( 'Todavía no has guardado ningún artículo. Pulsa el corazón de los que te gusten para verlos aquí.', 'segunda-vida' ),
			'sold'   => __( 'Vendido', 'segunda-vida' ),
		),
	) );
} );

/**
 * Estado de conservación: taxonomía propia para poder filtrar el catálogo.
 */
add_action( 'init', function () {
	register_taxonomy( 'sv_estado', array( 'product' ), array(
		'labels'            => array(
			'name'          => __( 'Estado', 'segunda-vida' ),
			'singular_name' => __( 'Estado', 'segunda-vida' ),
			'menu_name'     => __( 'Estado de conservación', 'segunda-vida' ),
			'all_items'     => __( 'Todos los estados', 'segunda-vida' ),
			'edit_item'     => __( 'Editar estado', 'segunda-vida' ),
			'add_new_item'  => __( 'Añadir estado', 'segunda-vida' ),
		),
		'public'            => true,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'query_var'         => 'estado',
		'rewrite'           => false,
	) );
}, 5 );

function sv_default_estados() {
	return array(
		'nuevo-con-etiqueta' => __( 'Nuevo con etiqueta', 'segunda-vida' ),
		'como-nuevo'         => __( 'Como nuevo', 'segunda-vida' ),
		'muy-buen-estado'    => __( 'Muy buen estado', 'segunda-vida' ),
		'buen-estado'        => __( 'Buen estado', 'segunda-vida' ),
		'con-senales-de-uso' => __( 'Con señales de uso', 'segunda-vida' ),
	);
}

function sv_install_defaults() {
	foreach ( sv_default_estados() as $slug => $name ) {
		if ( ! term_exists( $slug, 'sv_estado' ) ) {
			wp_insert_term( $name, 'sv_estado', array( 'slug' => $slug ) );
		}
	}

	if ( ! sv_favorites_page_id() ) {
		$id = wp_insert_post( array(
			'post_type'   => 'page',
			'post_status' => 'publish',
			'post_title'  => __( 'Favoritos', 'segunda-vida' ),
			'post_name'   => 'favoritos',
		) );
		if ( $id && ! is_wp_error( $id ) ) {
			update_post_meta( $id, '_wp_page_template', 'page-templates/favoritos.php' );
		}
	}
}
add_action( 'after_switch_theme', function () {
	// La taxonomía ya está registrada en este punto (init, prioridad 5).
	sv_install_defaults();
} );
