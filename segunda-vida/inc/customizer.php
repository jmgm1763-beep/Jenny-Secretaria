<?php
defined( 'ABSPATH' ) || exit;

add_action( 'customize_register', function ( $wp_customize ) {
	$wp_customize->add_panel( 'sv_panel', array(
		'title'    => __( 'Segunda Vida · Ajustes de la tienda', 'segunda-vida' ),
		'priority' => 20,
	) );

	$sections = array(
		'sv_home'     => __( 'Portada', 'segunda-vida' ),
		'sv_trust'    => __( 'Mensajes de confianza', 'segunda-vida' ),
		'sv_channels' => __( 'Vinted, Wallapop y contacto', 'segunda-vida' ),
		'sv_selling'  => __( 'Modo de venta', 'segunda-vida' ),
	);
	foreach ( $sections as $id => $title ) {
		$wp_customize->add_section( $id, array( 'title' => $title, 'panel' => 'sv_panel' ) );
	}

	$fields = array(
		// clave => array( sección, etiqueta, tipo, descripción ).
		'announcement'  => array( 'sv_home', __( 'Barra de aviso superior', 'segunda-vida' ), 'text', __( 'Déjalo vacío para ocultarla.', 'segunda-vida' ) ),
		'hero_eyebrow'  => array( 'sv_home', __( 'Portada: antetítulo', 'segunda-vida' ), 'text', '' ),
		'hero_title'    => array( 'sv_home', __( 'Portada: título', 'segunda-vida' ), 'text', '' ),
		'hero_text'     => array( 'sv_home', __( 'Portada: texto', 'segunda-vida' ), 'textarea', '' ),
		'hero_cta'      => array( 'sv_home', __( 'Portada: texto del botón', 'segunda-vida' ), 'text', '' ),
		'hero_image'    => array( 'sv_home', __( 'Portada: imagen', 'segunda-vida' ), 'image', '' ),
		'story_title'   => array( 'sv_home', __( 'Bloque editorial: título', 'segunda-vida' ), 'text', '' ),
		'story_text'    => array( 'sv_home', __( 'Bloque editorial: texto', 'segunda-vida' ), 'textarea', '' ),
		'budget_price'  => array( 'sv_home', __( 'Fila «Hasta X €»: importe', 'segunda-vida' ), 'number', __( 'Pon 0 para ocultar la fila.', 'segunda-vida' ) ),
		'trust_1_title' => array( 'sv_trust', __( 'Mensaje 1: título', 'segunda-vida' ), 'text', '' ),
		'trust_1_text'  => array( 'sv_trust', __( 'Mensaje 1: texto', 'segunda-vida' ), 'text', '' ),
		'trust_2_title' => array( 'sv_trust', __( 'Mensaje 2: título', 'segunda-vida' ), 'text', '' ),
		'trust_2_text'  => array( 'sv_trust', __( 'Mensaje 2: texto', 'segunda-vida' ), 'text', '' ),
		'trust_3_title' => array( 'sv_trust', __( 'Mensaje 3: título', 'segunda-vida' ), 'text', '' ),
		'trust_3_text'  => array( 'sv_trust', __( 'Mensaje 3: texto', 'segunda-vida' ), 'text', '' ),
		'vinted_url'    => array( 'sv_channels', __( 'Enlace a tu perfil de Vinted', 'segunda-vida' ), 'url', __( 'Ejemplo: https://www.vinted.es/member/12345-tunombre', 'segunda-vida' ) ),
		'wallapop_url'  => array( 'sv_channels', __( 'Enlace a tu perfil de Wallapop', 'segunda-vida' ), 'url', '' ),
		'instagram_url' => array( 'sv_channels', __( 'Enlace a Instagram', 'segunda-vida' ), 'url', '' ),
		'whatsapp'      => array( 'sv_channels', __( 'WhatsApp (con prefijo de país)', 'segunda-vida' ), 'text', __( 'Ejemplo: 34600000000. Añade el botón «Preguntar por WhatsApp» en cada artículo.', 'segunda-vida' ) ),
		'catalog_mode'  => array( 'sv_selling', __( 'Modo catálogo (sin carrito)', 'segunda-vida' ), 'checkbox', __( 'Oculta la compra en la web: cada artículo muestra solo los botones de Vinted, Wallapop y WhatsApp. Útil mientras no tengas pasarela de pago.', 'segunda-vida' ) ),
	);

	$sanitizers = array(
		'text'     => 'sanitize_text_field',
		'textarea' => 'sanitize_textarea_field',
		'url'      => 'esc_url_raw',
		'image'    => 'esc_url_raw',
		'number'   => 'absint',
		'checkbox' => 'wp_validate_boolean',
	);

	$defaults = sv_defaults();
	foreach ( $fields as $key => $field ) {
		list( $section, $label, $type, $description ) = $field;
		$wp_customize->add_setting( 'sv_' . $key, array(
			'default'           => $defaults[ $key ],
			'sanitize_callback' => $sanitizers[ $type ],
		) );
		$args = array(
			'label'       => $label,
			'description' => $description,
			'section'     => $section,
		);
		if ( 'image' === $type ) {
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'sv_' . $key, $args ) );
		} else {
			$wp_customize->add_control( 'sv_' . $key, $args + array( 'type' => $type ) );
		}
	}
} );
