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
			'public'              => true,
			'publicly_queryable'  => true,
			'show_in_nav_menus'   => false,
			'has_archive'         => false,
			'rewrite'             => array(
				'slug'       => 'proyecto',
				'with_front' => false,
			),
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_rest'        => true,
			'exclude_from_search' => true,
			'menu_position'       => 21,
			'menu_icon'           => 'dashicons-building',
			'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
			'taxonomies'          => array( 'nexxus_partner', 'nexxus_estado', 'nexxus_linea' ),
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

	register_taxonomy(
		'nexxus_linea',
		'nexxus_proyecto',
		array(
			'labels'            => array(
				'name'          => 'Línea de negocio',
				'singular_name' => 'Línea de negocio',
				'menu_name'     => 'Líneas de negocio',
				'all_items'     => 'Todas las líneas',
				'edit_item'     => 'Editar línea',
				'add_new_item'  => 'Añadir línea',
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
 * Las fichas de proyecto tienen dirección propia: se refrescan los enlaces una vez por versión del tema.
 */
function nexxus_maybe_flush_rewrites() {
	if ( get_option( 'nexxus_rewrite_version' ) !== NEXXUS_VERSION ) {
		flush_rewrite_rules( false );
		update_option( 'nexxus_rewrite_version', NEXXUS_VERSION );
	}
}
add_action( 'init', 'nexxus_maybe_flush_rewrites', 99 );

/**
 * Líneas de negocio disponibles para clasificar proyectos.
 */
function nexxus_line_terms() {
	return array(
		'linea-a' => 'Línea A · Terciario e industrial',
		'linea-b' => 'Línea B · Residencial en altura',
		'linea-c' => 'Línea C · Vivienda pública',
	);
}

/**
 * Crea una sola vez las tres líneas de negocio.
 */
function nexxus_seed_line_terms() {
	if ( get_option( 'nexxus_linea_terms_seeded' ) ) {
		return;
	}
	foreach ( nexxus_line_terms() as $slug => $name ) {
		if ( ! term_exists( $slug, 'nexxus_linea' ) ) {
			wp_insert_term( $name, 'nexxus_linea', array( 'slug' => $slug ) );
		}
	}
	update_option( 'nexxus_linea_terms_seeded', 1 );
}
add_action( 'admin_init', 'nexxus_seed_line_terms' );

/**
 * Datos de la ficha de proyecto.
 */
function nexxus_project_fields() {
	return array(
		'ubicacion'  => 'Ubicación',
		'superficie' => 'Superficie',
		'plazo'      => 'Plazo de ejecución',
		'sistema'    => 'Sistema constructivo',
		'anio'       => 'Año',
		'cliente'    => 'Promotor o cliente',
	);
}

/**
 * Caja «Datos del proyecto» en el editor.
 */
function nexxus_project_meta_box() {
	add_meta_box( 'nexxus_project_data', 'Datos del proyecto', 'nexxus_project_meta_box_html', 'nexxus_proyecto', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'nexxus_project_meta_box' );

/**
 * Campos de la caja.
 */
function nexxus_project_meta_box_html( $post ) {
	wp_nonce_field( 'nexxus_project_data', 'nexxus_project_nonce' );
	echo '<p>Datos opcionales que se muestran en la ficha del proyecto. Los campos vacíos no aparecen.</p><table class="form-table" role="presentation"><tbody>';
	foreach ( nexxus_project_fields() as $key => $label ) {
		$value = get_post_meta( $post->ID, '_nexxus_' . $key, true );
		printf(
			'<tr><th scope="row"><label for="nexxus_%1$s">%2$s</label></th><td><input type="text" class="regular-text" id="nexxus_%1$s" name="nexxus_%1$s" value="%3$s"></td></tr>',
			esc_attr( $key ),
			esc_html( $label ),
			esc_attr( $value )
		);
	}
	echo '</tbody></table>';
}

/**
 * Guarda los datos del proyecto.
 */
function nexxus_project_save( $post_id ) {
	if ( ! isset( $_POST['nexxus_project_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['nexxus_project_nonce'] ) ), 'nexxus_project_data' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	foreach ( array_keys( nexxus_project_fields() ) as $key ) {
		$value = isset( $_POST[ 'nexxus_' . $key ] ) ? sanitize_text_field( wp_unslash( $_POST[ 'nexxus_' . $key ] ) ) : '';
		if ( '' === $value ) {
			delete_post_meta( $post_id, '_nexxus_' . $key );
		} else {
			update_post_meta( $post_id, '_nexxus_' . $key, $value );
		}
	}
}
add_action( 'save_post_nexxus_proyecto', 'nexxus_project_save' );

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
	echo '<div class="notice notice-info"><p><strong>Cómo añadir un proyecto:</strong> pulse «Añadir proyecto», escriba el nombre de la obra como título, elija la <em>Fotografía del proyecto</em>, marque el <em>Partner</em>, el <em>Estado</em> y la <em>Línea de negocio</em> y, en <em>Extracto</em>, escriba la ubicación o una frase breve. Al publicar, aparece en la sección «Proyectos» de la portada. Si además escribe un texto, añade una galería de fotos o rellena «Datos del proyecto», el proyecto tendrá su propia ficha. Fotografías recomendadas: horizontales, de 1600 px de ancho como mínimo.</p></div>';
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

/**
 * Línea de negocio de un proyecto: 'a', 'b', 'c' o cadena vacía.
 */
function nexxus_project_line( $post_id ) {
	foreach ( array( 'a', 'b', 'c' ) as $letter ) {
		if ( has_term( 'linea-' . $letter, 'nexxus_linea', $post_id ) ) {
			return $letter;
		}
	}
	return '';
}

/**
 * Datos rellenados de un proyecto (etiqueta => valor).
 */
function nexxus_project_facts( $post_id ) {
	$facts = array();
	foreach ( nexxus_project_fields() as $key => $label ) {
		$value = get_post_meta( $post_id, '_nexxus_' . $key, true );
		if ( '' !== (string) $value ) {
			$facts[ $label ] = $value;
		}
	}
	return $facts;
}

/**
 * ¿Tiene el proyecto contenido suficiente para enlazar a su ficha?
 */
function nexxus_project_has_detail( $post ) {
	return '' !== trim( (string) $post->post_content ) || nexxus_project_facts( $post->ID );
}
