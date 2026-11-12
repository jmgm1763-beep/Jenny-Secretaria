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
function nexxus_form_redirect( $status ) {
	$back = wp_get_referer();
	if ( ! $back ) {
		$back = home_url( '/' );
	}
	$back = remove_query_arg( 'contacto', $back );
	wp_safe_redirect( add_query_arg( 'contacto', $status, $back ) . '#contacto' );
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
function nexxus_form_notice() {
	if ( empty( $_GET['contacto'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return;
	}
	$status   = sanitize_key( wp_unslash( $_GET['contacto'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$messages = array(
		'ok'     => array( 'ok', 'Gracias. Hemos recibido su consulta y le responderemos en breve.' ),
		'error'  => array( 'ko', 'Revise el formulario: nombre, correo, mensaje y aceptación de la política de privacidad son obligatorios.' ),
		'limite' => array( 'ko', 'Ha alcanzado el máximo de envíos por hora. Puede escribirnos o llamarnos directamente.' ),
		'fallo'  => array( 'ko', 'No hemos podido enviar su consulta. Por favor, escríbanos o llámenos directamente.' ),
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
