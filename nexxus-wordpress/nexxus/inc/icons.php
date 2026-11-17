<?php
/**
 * Símbolos de línea para los apartados, dibujados en el estilo de la marca.
 *
 * @package Nexxus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Devuelve un símbolo SVG por su nombre.
 */
function nexxus_icon( $name ) {
	$icons = array(
		// Pilares.
		'activo'           => '<path d="M16 28s-8-8.500-8-14a8 8 0 0 1 16 0c0 5.500-8 14-8 14z"/><rect class="ic-a" x="13" y="11" width="6" height="6"/>',
		'capital'          => '<path d="M4 27h24M8 27v-8h4v8M14 27V14h4v13"/><path class="ic-a" d="M20 27V7h4v20"/>',
		'sistema'          => '<rect x="5" y="5" width="22" height="22"/><path d="M5 16h22M12 5v22M20 5v22"/><path class="ic-a" d="M12 5l8 11M20 5l-8 11"/>',
		// Ventajas.
		'interlocutor'     => '<path d="M16 4v8M16 20v8M4 16h8M20 16h8"/><rect class="ic-a" x="12" y="12" width="8" height="8"/>',
		'certificados'     => '<path d="M16 4l10 4v7c0 6-4.500 10.500-10 13-5.500-2.500-10-7-10-13V8z"/><path class="ic-a" d="M11 16l4 4 6-7"/>',
		'financiacion'     => '<path d="M4 12l12-7 12 7zM8 14v9M13 14v9M19 14v9M24 14v9"/><path class="ic-a" d="M4 27h24"/>',
		'plazo'            => '<circle cx="16" cy="16" r="11"/><path class="ic-a" d="M16 9v7l5 3"/>',
		'nacional'         => '<path d="M4 9l8-3 8 3 8-3v17l-8 3-8-3-8 3z"/><path class="ic-a" d="M12 6v17M20 9v17"/>',
		'salida'           => '<path d="M14 5H6v22h8"/><path class="ic-a" d="M12 16h15M22 11l5 5-5 5"/>',
		// Reglas.
		'registro'         => '<rect x="7" y="6" width="18" height="22"/><path d="M12 4h8v4h-8z"/><path class="ic-a" d="M11 17l3 3 6-6"/>',
		'no-elusion'       => '<rect x="3" y="11" width="15" height="10" rx="5"/><rect class="ic-a" x="14" y="11" width="15" height="10" rx="5"/>',
		'confidencialidad' => '<rect x="7" y="14" width="18" height="13"/><path d="M11 14v-4a5 5 0 0 1 10 0v4"/><path class="ic-a" d="M16 19v4"/>',
		'soporte'          => '<path d="M7 18v-3a9 9 0 0 1 18 0v3"/><rect x="5" y="17" width="5" height="8"/><rect x="22" y="17" width="5" height="8"/><path class="ic-a" d="M24.500 25v3H18"/>',
		'formacion'        => '<path d="M3 12l13-6 13 6-13 6z"/><path d="M9 15v6c0 2 3.200 4 7 4s7-2 7-4v-6"/><path class="ic-a" d="M29 12v8"/>',
		'internacional'    => '<circle cx="16" cy="16" r="11"/><ellipse cx="16" cy="16" rx="5" ry="11"/><path class="ic-a" d="M5 16h22"/>',
	);

	if ( ! isset( $icons[ $name ] ) ) {
		return '';
	}

	return '<svg class="icon" viewBox="0 0 32 32" width="40" height="40" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg"><g fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="square" stroke-linejoin="miter">' . $icons[ $name ] . '</g></svg>';
}
