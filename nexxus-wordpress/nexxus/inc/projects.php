<?php
/**
 * Proyectos: fotografías de obras de los partners, gestionadas desde el panel de WordPress.
 * Cada proyecto tiene un título, una imagen destacada, un partner y un texto breve (extracto).
 *
 * @package Nexxus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registra el tipo de contenido «Proyectos» y la clasificación por partner.
 */
function nexxus_register_projects() {
	register_post_type(
		'nexxus_proyecto',
		array(
			'labels'              => array(
				'name'                  => 'Proyectos',
				'singular_name'         => 'Proyecto',
				'add_new'               => 'Añadir proyecto',
				'add_new_item'          => 'Añadir proyecto',
				'edit_item'             => 'Editar proyecto',
				'new_item'              => 'Nuevo proyecto',
				'view_item'             => 'Ver proyecto',
				'search_items'          => 'Buscar proyectos',
				'not_found'             => 'Todavía no hay proyectos.',
				'not_found_in_trash'    => 'No hay proyectos en la papelera.',
				'all_items'             => 'Todos los proyectos',
				'menu_name'             => 'Proyectos',
				'featured_image'        => 'Fotografía del proyecto',
				'set_featured_image'    => 'Elegir fotografía',
				'remove_featured_image' => 'Quitar fotografía',
				'use_featured_image'    => 'Usar como fotografía del proyecto',
			),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_rest'        => true,
			'exclude_from_search' => true,
			'menu_position'       => 21,
			'menu_icon'           => 'dashicons-building',
			'supports'            => array( 'title', 'thumbnail', 'excerpt', 'page-attributes' ),
			'taxonomies'          => array( 'nexxus_partner', 'nexxus_estado' ),
		)
	);

	register_taxonomy(
		'nexxus_partner',
		'nexxus_proyecto',
		array(
			'labels'            => array(
				'name'          => 'Partners',
				'singular_name' => 'Partner',
				'menu_name'     => 'Partners',
				'all_items'     => 'Todos los partners',
				'edit_item'     => 'Editar partner',
				'add_new_item'  => 'Añadir partner',
				'search_items'  => 'Buscar partners',
			),
			'public'            => false,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'hierarchical'      => true,
		)
	);

	register_taxonomy(
		'nexxus_estado',
		'nexxus_proyecto',
		array(
			'labels'            => array(
				'name'          => 'Estado',
				'singular_name' => 'Estado',
				'menu_name'     => 'Estados',
				'all_items'     => 'Todos los estados',
				'edit_item'     => 'Editar estado',
				'add_new_item'  => 'Añadir estado',
			),
			'public'            => false,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'hierarchical'      => true,
		)
	);
}
add_action( 'init', 'nexxus_register_projects' );

/**
 * Crea una sola vez los cinco partners como opciones de clasificación.
 */
function nexxus_seed_partner_terms() {
	if ( get_option( 'nexxus_partner_terms_seeded' ) ) {
		return;
	}
	foreach ( nexxus_partners() as $partner ) {
		if ( ! term_exists( $partner['name'], 'nexxus_partner' ) ) {
			wp_insert_term( $partner['name'], 'nexxus_partner', array( 'slug' => $partner['id'] ) );
		}
	}
	update_option( 'nexxus_partner_terms_seeded', 1 );
}

/**
 * Crea una sola vez los dos estados de proyecto.
 */
function nexxus_seed_status_terms() {
	if ( get_option( 'nexxus_estado_terms_seeded' ) ) {
		return;
	}
	foreach ( array( 'ejecutado' => 'Ejecutado', 'en-proceso' => 'En proceso' ) as $slug => $name ) {
		if ( ! term_exists( $slug, 'nexxus_estado' ) ) {
			wp_insert_term( $name, 'nexxus_estado', array( 'slug' => $slug ) );
		}
	}
	update_option( 'nexxus_estado_terms_seeded', 1 );
}
add_action( 'admin_init', 'nexxus_seed_status_terms' );
add_action( 'admin_init', 'nexxus_seed_partner_terms' );

/**
 * Instrucciones breves en la pantalla de proyectos.
 */
function nexxus_projects_help_notice() {
	$screen = get_current_screen();
	if ( ! $screen || 'edit-nexxus_proyecto' !== $screen->id ) {
		return;
	}
	echo '<div class="notice notice-info"><p><strong>Cómo añadir un proyecto:</strong> pulse «Añadir proyecto», escriba el nombre de la obra como título, elija la <em>Fotografía del proyecto</em>, marque el <em>Partner</em> y el <em>Estado</em> (Ejecutado o En proceso) y, en <em>Extracto</em>, escriba la ubicación o una frase breve. Al publicar, aparece en la sección «Proyectos» de la portada. Fotografías recomendadas: horizontales, de 1600 px de ancho como mínimo.</p></div>';
}
add_action( 'admin_notices', 'nexxus_projects_help_notice' );

/**
 * Proyectos publicados, en el orden indicado en cada uno y después por fecha.
 */
function nexxus_get_projects( $limit = 24 ) {
	return get_posts(
		array(
			'post_type'        => 'nexxus_proyecto',
			'post_status'      => 'publish',
			'numberposts'      => $limit,
			'orderby'          => array(
				'menu_order' => 'ASC',
				'date'       => 'DESC',
			),
			'suppress_filters' => false,
		)
	);
}

/**
 * Nombre del partner de un proyecto.
 */
function nexxus_project_partner( $post_id ) {
	$terms = get_the_terms( $post_id, 'nexxus_partner' );
	if ( ! $terms || is_wp_error( $terms ) ) {
		return '';
	}
	return $terms[0]->name;
}

/**
 * Estado de un proyecto: 'en-proceso' o 'ejecutado' (por defecto).
 */
function nexxus_project_status( $post_id ) {
	return has_term( 'en-proceso', 'nexxus_estado', $post_id ) ? 'en-proceso' : 'ejecutado';
}
