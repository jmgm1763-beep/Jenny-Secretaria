<?php
/**
 * NEXXUS — funciones del tema.
 *
 * @package Nexxus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'NEXXUS_VERSION', '1.2.0' );

require get_template_directory() . '/inc/content.php';
require get_template_directory() . '/inc/illustrations.php';
require get_template_directory() . '/inc/icons.php';
require get_template_directory() . '/inc/projects.php';
require get_template_directory() . '/inc/contact-form.php';

/**
 * Configuración básica del tema.
 */
function nexxus_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'nexxus-card', 960, 720, true );
	add_image_size( 'nexxus-wide', 1920, 820, true );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );

	register_nav_menus(
		array(
			'legal' => 'Menú legal (pie de página)',
		)
	);
}
add_action( 'after_setup_theme', 'nexxus_setup' );

/**
 * Estilos y scripts.
 */
function nexxus_assets() {
	wp_enqueue_style( 'nexxus', get_stylesheet_uri(), array(), NEXXUS_VERSION );
	wp_enqueue_script( 'nexxus', get_template_directory_uri() . '/assets/js/main.js', array(), NEXXUS_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'nexxus_assets' );

/**
 * Precarga de la tipografía corporativa (alojada en el propio tema, sin llamadas externas).
 */
function nexxus_head() {
	$dir = get_template_directory_uri();
	echo '<link rel="preload" href="' . esc_url( $dir . '/assets/fonts/montserrat-latin-wght-normal.woff2' ) . '" as="font" type="font/woff2" crossorigin>' . "\n";
	echo '<meta name="theme-color" content="#061D38">' . "\n";

	// Icono del sitio: se usa el isotipo salvo que se haya definido otro en Apariencia > Personalizar.
	if ( ! has_site_icon() ) {
		echo '<link rel="icon" href="' . esc_url( $dir . '/assets/img/favicon.svg' ) . '" type="image/svg+xml">' . "\n";
	}

	// Metadatos básicos de la portada, solo si no hay un plugin de SEO que ya los gestione.
	if ( is_front_page() && ! nexxus_has_seo_plugin() ) {
		$desc = nexxus_opt( 'meta_description' );
		echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
		echo '<meta property="og:type" content="website">' . "\n";
		echo '<meta property="og:title" content="' . esc_attr( wp_get_document_title() ) . '">' . "\n";
		echo '<meta property="og:description" content="' . esc_attr( $desc ) . '">' . "\n";
		echo '<meta property="og:url" content="' . esc_url( home_url( '/' ) ) . '">' . "\n";
		echo '<meta property="og:locale" content="es_ES">' . "\n";
	}
}
add_action( 'wp_head', 'nexxus_head', 2 );

/**
 * Marca el documento como «con JavaScript» lo antes posible (evita parpadeos en las animaciones).
 */
function nexxus_js_flag() {
	echo "<script>document.documentElement.className+=' js';</script>\n";
}
add_action( 'wp_head', 'nexxus_js_flag', 0 );

/**
 * ¿Hay un plugin de SEO activo?
 */
function nexxus_has_seo_plugin() {
	return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' ) || defined( 'SEOPRESS_VERSION' );
}

/**
 * Título de la portada.
 */
function nexxus_document_title( $parts ) {
	if ( is_front_page() && ! nexxus_has_seo_plugin() ) {
		$parts['title']   = 'NEXXUS';
		$parts['tagline'] = 'Real Estate y construcción industrializada';
		unset( $parts['site'] );
	}
	return $parts;
}
add_filter( 'document_title_parts', 'nexxus_document_title' );

/**
 * Valores por defecto de las opciones editables.
 */
function nexxus_defaults() {
	return array(
		'contact_name'     => 'Josep M. González',
		'contact_role'     => 'Consultor Inmobiliario',
		'contact_phone'    => '+34 696 94 55 85',
		'contact_email'    => 'josep@tradinghabitat.com',
		'form_recipient'   => '',
		'hero_title'       => 'Un solo interlocutor desde el suelo hasta la entrega.',
		'hero_text'        => 'Unimos activo, financiación, sistema constructivo, montaje y comercialización bajo una misma dirección.',
		'meta_description' => 'NEXXUS coordina a cinco empresas especialistas en activos terciarios e industriales y en construcción industrializada. Un único responsable desde el suelo hasta la entrega.',
	);
}

/**
 * Devuelve una opción del tema.
 */
function nexxus_opt( $key ) {
	$defaults = nexxus_defaults();
	$default  = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
	$value    = get_theme_mod( 'nexxus_' . $key, $default );
	return '' === trim( (string) $value ) ? $default : $value;
}

/**
 * Teléfono en formato válido para enlaces tel:.
 */
function nexxus_tel_href( $phone ) {
	return 'tel:' . preg_replace( '/[^0-9+]/', '', $phone );
}

/**
 * Opciones en Apariencia > Personalizar.
 */
function nexxus_customize( $wp_customize ) {
	$wp_customize->add_section(
		'nexxus_contacto',
		array(
			'title'       => 'NEXXUS · Contacto',
			'description' => 'Datos que se muestran en la cabecera, la sección de contacto y el pie.',
			'priority'    => 30,
		)
	);
	$wp_customize->add_section(
		'nexxus_portada',
		array(
			'title'    => 'NEXXUS · Portada',
			'priority' => 31,
		)
	);

	$fields = array(
		'contact_name'     => array( 'nexxus_contacto', 'Nombre de contacto', 'text', 'sanitize_text_field' ),
		'contact_role'     => array( 'nexxus_contacto', 'Cargo', 'text', 'sanitize_text_field' ),
		'contact_phone'    => array( 'nexxus_contacto', 'Teléfono', 'text', 'sanitize_text_field' ),
		'contact_email'    => array( 'nexxus_contacto', 'Correo visible en la web', 'email', 'sanitize_email' ),
		'form_recipient'   => array( 'nexxus_contacto', 'Correo que recibe el formulario (si se deja vacío, el correo visible)', 'email', 'sanitize_email' ),
		'hero_title'       => array( 'nexxus_portada', 'Titular principal', 'text', 'sanitize_text_field' ),
		'hero_text'        => array( 'nexxus_portada', 'Texto bajo el titular', 'textarea', 'sanitize_textarea_field' ),
		'meta_description' => array( 'nexxus_portada', 'Descripción para buscadores', 'textarea', 'sanitize_textarea_field' ),
	);

	// Fotografías opcionales: si se dejan vacías, se muestran los esquemas técnicos.
	$wp_customize->add_section(
		'nexxus_imagenes',
		array(
			'title'       => 'NEXXUS · Imágenes',
			'description' => 'Fotografías opcionales. Si deja un campo vacío, se muestra el esquema técnico original. Use fotos horizontales de 1600 px de ancho como mínimo. Las fotos de obras de los partners se añaden en el menú «Proyectos».',
			'priority'    => 32,
		)
	);
	foreach ( nexxus_image_slots() as $key => $label ) {
		$wp_customize->add_setting(
			'nexxus_' . $key,
			array(
				'default'           => 0,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Media_Control(
				$wp_customize,
				'nexxus_' . $key,
				array(
					'section'   => 'nexxus_imagenes',
					'label'     => $label,
					'mime_type' => 'image',
				)
			)
		);
	}

	$defaults = nexxus_defaults();
	foreach ( $fields as $key => $f ) {
		$wp_customize->add_setting(
			'nexxus_' . $key,
			array(
				'default'           => $defaults[ $key ],
				'sanitize_callback' => $f[3],
			)
		);
		$wp_customize->add_control(
			'nexxus_' . $key,
			array(
				'section' => $f[0],
				'label'   => $f[1],
				'type'    => $f[2],
			)
		);
	}
}
add_action( 'customize_register', 'nexxus_customize' );

/**
 * Al activar el tema: crea, como borradores, las páginas legales pendientes de revisión.
 * No se publican solas: el titular debe revisarlas antes.
 */
function nexxus_on_activation() {
	$pages = array(
		'aviso-legal'            => array( 'Aviso legal', nexxus_legal_notice_draft() ),
		'politica-de-privacidad' => array( 'Política de privacidad', nexxus_privacy_draft() ),
	);
	foreach ( $pages as $slug => $page ) {
		$existing = get_posts(
			array(
				'name'        => $slug,
				'post_type'   => 'page',
				'post_status' => array( 'publish', 'draft', 'pending', 'private', 'future', 'trash' ),
				'numberposts' => 1,
			)
		);
		if ( $existing ) {
			continue;
		}
		wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'draft',
				'post_name'    => $slug,
				'post_title'   => $page[0],
				'post_content' => $page[1],
			)
		);
	}
}
add_action( 'after_switch_theme', 'nexxus_on_activation' );

/**
 * Enlaces legales del pie: menú «legal» si existe; si no, las páginas legales ya publicadas.
 */
function nexxus_legal_links() {
	if ( has_nav_menu( 'legal' ) ) {
		wp_nav_menu(
			array(
				'theme_location' => 'legal',
				'container'      => false,
				'menu_class'     => 'legal-links',
				'depth'          => 1,
				'fallback_cb'    => false,
			)
		);
		return;
	}
	$items = '';
	foreach ( array( 'aviso-legal', 'politica-de-privacidad' ) as $slug ) {
		$page = get_page_by_path( $slug );
		if ( $page && 'publish' === $page->post_status ) {
			$items .= '<li><a href="' . esc_url( get_permalink( $page ) ) . '">' . esc_html( get_the_title( $page ) ) . '</a></li>';
		}
	}
	if ( $items ) {
		echo '<ul class="legal-links">' . $items . '</ul>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

/**
 * URL de la política de privacidad publicada (o cadena vacía).
 */
function nexxus_privacy_url() {
	$page = get_page_by_path( 'politica-de-privacidad' );
	if ( $page && 'publish' === $page->post_status ) {
		return get_permalink( $page );
	}
	$wp_privacy = get_privacy_policy_url();
	return $wp_privacy ? $wp_privacy : '';
}

/**
 * Enlace a una sección de la portada desde cualquier página.
 */
function nexxus_anchor( $id ) {
	return ( is_front_page() ? '' : home_url( '/' ) ) . '#' . $id;
}

/**
 * Huecos de fotografía editables en Apariencia > Personalizar > NEXXUS · Imágenes.
 */
function nexxus_image_slots() {
	return array(
		'img_hero'    => 'Portada (sustituye al alzado técnico)',
		'img_quienes' => 'Quiénes somos (franja panorámica)',
		'img_linea_a' => 'Línea A · Activos terciarios e industriales',
		'img_linea_b' => 'Línea B · Edificación residencial en altura',
		'img_linea_c' => 'Línea C · Vivienda pública y municipios',
		'img_contact' => 'Contacto (fondo de la sección)',
	);
}

/**
 * Devuelve la etiqueta de imagen de un hueco, o cadena vacía si no hay foto elegida.
 */
function nexxus_img( $key, $size = 'nexxus-card', $attrs = array() ) {
	$id = absint( get_theme_mod( 'nexxus_' . $key, 0 ) );
	if ( ! $id ) {
		return '';
	}
	$attrs = wp_parse_args( $attrs, array( 'loading' => 'lazy' ) );
	return wp_get_attachment_image( $id, $size, false, $attrs );
}
