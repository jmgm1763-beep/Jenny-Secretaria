<?php
/**
 * Formulario de contacto propio del tema (sin plugins).
 * Envía un correo al destinatario definido en Apariencia > Personalizar > NEXXUS · Contacto.
 *
 * @package Nexxus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Destinatario del formulario.
 */
function nexxus_form_recipient() {
	$to = sanitize_email( get_theme_mod( 'nexxus_form_recipient', '' ) );
	if ( ! $to ) {
		$to = sanitize_email( nexxus_opt( 'contact_email' ) );
	}
	if ( ! $to ) {
		$to = get_option( 'admin_email' );
	}
	return $to;
}

/**
 * Vuelve a la sección de contacto con el resultado del envío.
 */
function nexxus_form_redirect( $status, $form = 'contacto' ) {
	$anchor = 'club' === $form ? 'club-deal' : 'contacto';
	$back   = wp_get_referer();
	if ( ! $back ) {
		$back = home_url( '/' );
	}
	$back = remove_query_arg( array( 'contacto', 'club' ), $back );
	wp_safe_redirect( add_query_arg( $form, $status, $back ) . '#' . $anchor );
	exit;
}

/**
 * Procesa el envío.
 */
function nexxus_handle_contact() {
	// Trampa para robots: campo oculto que una persona nunca rellena.
	if ( ! empty( $_POST['web'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		nexxus_form_redirect( 'ok' );
	}

	// Límite de envíos por visitante (5 por hora) para frenar abusos.
	$ip    = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	$key   = 'nexxus_cf_' . md5( $ip . wp_salt() );
	$count = (int) get_transient( $key );
	if ( $count >= 5 ) {
		nexxus_form_redirect( 'limite' );
	}

	// phpcs:disable WordPress.Security.NonceVerification.Missing -- formulario público sin sesión; protegido con trampa y límite de envíos.
	$name    = isset( $_POST['nombre'] ) ? sanitize_text_field( wp_unslash( $_POST['nombre'] ) ) : '';
	$company = isset( $_POST['empresa'] ) ? sanitize_text_field( wp_unslash( $_POST['empresa'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone   = isset( $_POST['telefono'] ) ? sanitize_text_field( wp_unslash( $_POST['telefono'] ) ) : '';
	$type    = isset( $_POST['tipo'] ) ? sanitize_key( wp_unslash( $_POST['tipo'] ) ) : '';
	$message = isset( $_POST['mensaje'] ) ? sanitize_textarea_field( wp_unslash( $_POST['mensaje'] ) ) : '';
	$consent = ! empty( $_POST['privacidad'] );
	// phpcs:enable

	if ( '' === $name || ! is_email( $email ) || '' === $message || ! $consent ) {
		nexxus_form_redirect( 'error' );
	}

	$types      = nexxus_project_types();
	$type_label = isset( $types[ $type ] ) ? $types[ $type ] : 'Sin especificar';

	$body  = "Nueva consulta desde la web de NEXXUS Advisor\n\n";
	$body .= 'Nombre: ' . $name . "\n";
	$body .= 'Empresa: ' . ( $company ? $company : '—' ) . "\n";
	$body .= 'Correo: ' . $email . "\n";
	$body .= 'Teléfono: ' . ( $phone ? $phone : '—' ) . "\n";
	$body .= 'Tipo de proyecto: ' . $type_label . "\n\n";
	$body .= "Mensaje:\n" . $message . "\n";

	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		'Reply-To: ' . $name . ' <' . $email . '>',
	);

	$sent = wp_mail( nexxus_form_recipient(), 'NEXXUS Advisor · Consulta web de ' . $name, $body, $headers );

	set_transient( $key, $count + 1, HOUR_IN_SECONDS );
	nexxus_form_redirect( $sent ? 'ok' : 'fallo' );
}
add_action( 'admin_post_nopriv_nexxus_contact', 'nexxus_handle_contact' );
add_action( 'admin_post_nexxus_contact', 'nexxus_handle_contact' );

/**
 * Mensaje de resultado para mostrar sobre el formulario.
 */
function nexxus_form_notice( $form = 'contacto' ) {
	if ( empty( $_GET[ $form ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return;
	}
	$status   = sanitize_key( wp_unslash( $_GET[ $form ] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$messages = array(
		'ok'     => array( 'ok', 'club' === $form ? 'Gracias. Hemos recibido su solicitud y nos pondremos en contacto con usted.' : 'Gracias. Hemos recibido su consulta y le responderemos en breve.' ),
		'error'  => array( 'ko', 'club' === $form ? 'Revise el formulario: nombre, correo y aceptación de la política de privacidad son obligatorios.' : 'Revise el formulario: nombre, correo, mensaje y aceptación de la política de privacidad son obligatorios.' ),
		'limite' => array( 'ko', 'Ha alcanzado el máximo de envíos por hora. Puede escribirnos o llamarnos directamente.' ),
		'fallo'  => array( 'ko', 'No hemos podido enviar su solicitud. Por favor, escríbanos o llámenos directamente.' ),
	);
	if ( ! isset( $messages[ $status ] ) ) {
		return;
	}
	printf(
		'<p class="form-notice form-notice--%1$s" role="status">%2$s</p>',
		esc_attr( $messages[ $status ][0] ),
		esc_html( $messages[ $status ][1] )
	);
}

/**
 * Perfiles de inversor del formulario del Club Deal.
 */
function nexxus_club_profiles() {
	return array(
		'particular'    => 'Inversor particular',
		'family-office' => 'Family office',
		'institucional' => 'Fondo o inversor institucional',
		'propietario'   => 'Promotor o propietario de un activo',
		'otro'          => 'Otro',
	);
}

/**
 * Tipos de operación de interés.
 */
function nexxus_club_interests() {
	return array(
		'terciario'   => 'Terciario e industrial',
		'residencial' => 'Residencial en altura',
		'suelo'       => 'Suelo para desarrollo',
	);
}

/**
 * Destinatario de las solicitudes del Club Deal.
 */
function nexxus_club_recipient() {
	$to = sanitize_email( get_theme_mod( 'nexxus_club_recipient', '' ) );
	return $to ? $to : nexxus_form_recipient();
}

/**
 * Procesa la solicitud de información del Club Deal.
 */
function nexxus_handle_club() {
	if ( ! empty( $_POST['web'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		nexxus_form_redirect( 'ok', 'club' );
	}

	$ip    = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	$key   = 'nexxus_cf_' . md5( $ip . wp_salt() );
	$count = (int) get_transient( $key );
	if ( $count >= 5 ) {
		nexxus_form_redirect( 'limite', 'club' );
	}

	// phpcs:disable WordPress.Security.NonceVerification.Missing -- formulario público sin sesión; protegido con trampa y límite de envíos.
	$name     = isset( $_POST['nombre'] ) ? sanitize_text_field( wp_unslash( $_POST['nombre'] ) ) : '';
	$company  = isset( $_POST['empresa'] ) ? sanitize_text_field( wp_unslash( $_POST['empresa'] ) ) : '';
	$email    = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone    = isset( $_POST['telefono'] ) ? sanitize_text_field( wp_unslash( $_POST['telefono'] ) ) : '';
	$profile  = isset( $_POST['perfil'] ) ? sanitize_key( wp_unslash( $_POST['perfil'] ) ) : '';
	$interest = isset( $_POST['interes'] ) && is_array( $_POST['interes'] ) ? array_map( 'sanitize_key', wp_unslash( $_POST['interes'] ) ) : array();
	$message  = isset( $_POST['mensaje'] ) ? sanitize_textarea_field( wp_unslash( $_POST['mensaje'] ) ) : '';
	$consent  = ! empty( $_POST['privacidad'] );
	// phpcs:enable

	if ( '' === $name || ! is_email( $email ) || ! $consent ) {
		nexxus_form_redirect( 'error', 'club' );
	}

	$profiles  = nexxus_club_profiles();
	$interests = nexxus_club_interests();
	$chosen    = array();
	foreach ( $interest as $slug ) {
		if ( isset( $interests[ $slug ] ) ) {
			$chosen[] = $interests[ $slug ];
		}
	}

	$body  = "Nueva solicitud de información del Club Deal Inmobiliario\n\n";
	$body .= 'Nombre: ' . $name . "\n";
	$body .= 'Empresa u organización: ' . ( $company ? $company : '—' ) . "\n";
	$body .= 'Correo: ' . $email . "\n";
	$body .= 'Teléfono: ' . ( $phone ? $phone : '—' ) . "\n";
	$body .= 'Perfil: ' . ( isset( $profiles[ $profile ] ) ? $profiles[ $profile ] : 'Sin especificar' ) . "\n";
	$body .= 'Operaciones de interés: ' . ( $chosen ? implode( ', ', $chosen ) : 'Sin especificar' ) . "\n\n";
	$body .= "Comentarios:\n" . ( $message ? $message : '—' ) . "\n";

	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		'Reply-To: ' . $name . ' <' . $email . '>',
	);

	$sent = wp_mail( nexxus_club_recipient(), 'NEXXUS Advisor · Club Deal · Solicitud de ' . $name, $body, $headers );

	set_transient( $key, $count + 1, HOUR_IN_SECONDS );
	nexxus_form_redirect( $sent ? 'ok' : 'fallo', 'club' );
}
add_action( 'admin_post_nopriv_nexxus_club', 'nexxus_handle_club' );
add_action( 'admin_post_nexxus_club', 'nexxus_handle_club' );
