<?php
/**
 * Ilustraciones técnicas en línea (SVG), en el estilo de los esquemas del dossier.
 * Son vectoriales: no pesan y se ven nítidas en cualquier pantalla.
 *
 * @package Nexxus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Alzado tipo de un edificio LGSF de PB+6 (portada).
 */
function nexxus_art_alzado() {
	$x0     = 120;
	$x1     = 440;
	$ground = 500;
	$floor  = 60;
	$floors = 7;
	$top    = $ground - $floor * $floors;

	$o  = '<svg class="art art--alzado" viewBox="0 0 540 580" role="img" aria-labelledby="alzado-t" xmlns="http://www.w3.org/2000/svg">';
	$o .= '<title id="alzado-t">Alzado tipo de un edificio de planta baja más seis con estructura de acero ligero, de 21 metros de altura y 16 de ancho</title>';
	$o .= '<g fill="none" stroke="currentColor" stroke-linecap="square">';

	// Montantes cada 600 mm.
	$o .= '<g stroke-width="1" opacity=".28">';
	for ( $x = $x0 + 20; $x < $x1; $x += 20 ) {
		$o .= '<path d="M' . $x . ' ' . $top . 'V' . $ground . '"/>';
	}
	$o .= '</g>';

	// Huecos de ventana.
	$o .= '<g class="art-fill" stroke-width="1.5">';
	for ( $f = 0; $f < $floors; $f++ ) {
		$y = $ground - $floor * ( $f + 1 ) + 16;
		foreach ( array( 140, 220, 300, 380 ) as $wx ) {
			if ( 0 === $f && 220 === $wx ) {
				// Acceso en planta baja.
				$o .= '<rect x="' . $wx . '" y="' . ( $y - 4 ) . '" width="40" height="48"/>';
				continue;
			}
			$o .= '<rect x="' . $wx . '" y="' . $y . '" width="40" height="28"/>';
		}
	}
	$o .= '</g>';

	// Forjados y contorno.
	$o .= '<g stroke-width="2">';
	for ( $f = 1; $f < $floors; $f++ ) {
		$y  = $ground - $floor * $f;
		$o .= '<path d="M' . $x0 . ' ' . $y . 'H' . $x1 . '"/>';
	}
	$o .= '</g>';
	$o .= '<rect x="' . $x0 . '" y="' . $top . '" width="' . ( $x1 - $x0 ) . '" height="' . ( $ground - $top ) . '" stroke-width="3"/>';

	// Terreno.
	$o .= '<path d="M60 ' . $ground . 'H500" stroke-width="3"/>';
	$o .= '<g stroke-width="1" opacity=".5">';
	for ( $x = 70; $x < 500; $x += 16 ) {
		$o .= '<path d="M' . $x . ' ' . ( $ground + 12 ) . 'l10 -10"/>';
	}
	$o .= '</g>';

	// Cotas.
	$o .= '<g stroke-width="1" opacity=".75">';
	$o .= '<path d="M80 ' . $top . 'V' . $ground . 'M72 ' . $top . 'h16M72 ' . $ground . 'h16"/>';
	$o .= '<path d="M' . $x0 . ' 540H' . $x1 . 'M' . $x0 . ' 532v16M' . $x1 . ' 532v16"/>';
	$o .= '</g>';
	$o .= '</g>';

	// Panel en montaje (acento).
	$o .= '<g class="art-accent" fill="none" stroke-width="2.5" stroke-linecap="square">';
	$o .= '<rect x="300" y="' . $top . '" width="140" height="' . $floor . '"/>';
	$o .= '<path d="M300 ' . $top . 'L440 ' . ( $top + $floor ) . 'M440 ' . $top . 'L300 ' . ( $top + $floor ) . '"/>';
	$o .= '<path d="M370 ' . $top . 'V28" stroke-dasharray="5 6" stroke-width="1.5"/>';
	$o .= '</g>';

	// Rótulos.
	$o .= '<g class="art-text" fill="currentColor">';
	$o .= '<text x="120" y="24">ALZADO TIPO · LGSF · PB+6</text>';
	$o .= '<text x="66" y="' . ( ( $top + $ground ) / 2 ) . '" transform="rotate(-90 66 ' . ( ( $top + $ground ) / 2 ) . ')" text-anchor="middle">h = 21,00 m</text>';
	$o .= '<text x="280" y="566" text-anchor="middle">16,00</text>';
	$o .= '<text x="452" y="' . ( $top + 34 ) . '" class="art-accent-text">PANEL 2D</text>';
	$o .= '</g>';
	$o .= '</svg>';

	return $o;
}

/**
 * Ilustración de cada línea de negocio.
 */
function nexxus_art_line( $type ) {
	$o = '<svg class="art art--line" viewBox="0 0 280 130" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg"><g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="square" stroke-linejoin="miter">';

	if ( 'nave' === $type ) {
		// Nave de pórticos a dos aguas.
		$o .= '<path d="M30 110V58L140 22L250 58V110"/>';
		$o .= '<g stroke-width="1" opacity=".45"><path d="M74 110V44M118 110V29M162 110V29M206 110V44"/></g>';
		$o .= '<g class="art-accent"><rect x="118" y="70" width="44" height="40"/></g>';
		$o .= '<path d="M10 110H270" stroke-width="3"/>';
	} elseif ( 'torre' === $type ) {
		// Edificio en altura.
		$o .= '<rect x="104" y="12" width="72" height="98"/>';
		$o .= '<g stroke-width="1" opacity=".45"><path d="M104 26h72M104 40h72M104 54h72M104 68h72M104 82h72M104 96h72"/></g>';
		$o .= '<g class="art-accent"><path d="M104 12L176 40M176 12L104 40"/></g>';
		$o .= '<path d="M40 110V70h44v40M196 110V56h44v54" opacity=".6"/>';
		$o .= '<path d="M10 110H270" stroke-width="3"/>';
	} else {
		// Conjunto de vivienda.
		$o .= '<path d="M34 110V62L70 38L106 62V110M106 62L140 38L174 62V110M174 62L210 38L246 62V110"/>';
		$o .= '<g stroke-width="1" opacity=".45"><rect x="56" y="72" width="28" height="18"/><rect x="196" y="72" width="28" height="18"/></g>';
		$o .= '<g class="art-accent"><rect x="128" y="76" width="24" height="34"/></g>';
		$o .= '<path d="M10 110H270" stroke-width="3"/>';
	}

	$o .= '</g></svg>';
	return $o;
}

/**
 * Esquema del ecosistema: NEXXUS en el centro y los cinco partners alrededor.
 */
function nexxus_art_hub() {
	$cx    = 380;
	$cy    = 240;
	$r     = 160;
	$nodes = array(
		array( 'TRADING HABITAT', 'Real Estate terciario' ),
		array( 'DS CONSULTORES', 'Subvenciones · Gestión' ),
		array( 'REMAGIN', 'Sistema en altura' ),
		array( 'DHHOUSE', 'Montaje Steel Frame' ),
		array( 'CUALIMETAL', 'Sistemas industriales' ),
	);

	$o  = '<svg class="art art--hub" viewBox="0 0 760 480" role="img" aria-labelledby="hub-t" xmlns="http://www.w3.org/2000/svg">';
	$o .= '<title id="hub-t">NEXXUS en el centro, conectada con Trading Habitat, DS Consultores, REMAGIN, DhHouse y CUALIMETAL</title>';
	$o .= '<circle cx="' . $cx . '" cy="' . $cy . '" r="' . $r . '" fill="none" stroke="currentColor" stroke-width="1" stroke-dasharray="3 7" opacity=".4"/>';

	$count = count( $nodes );
	$lines = '';
	$dots  = '';
	foreach ( $nodes as $i => $n ) {
		$a  = deg2rad( -90 + 360 / $count * $i );
		$x  = round( $cx + $r * cos( $a ), 1 );
		$y  = round( $cy + $r * sin( $a ), 1 );
		// Rótulo hacia fuera del círculo, para que no pise líneas ni nodos.
		$cos    = cos( $a );
		$sin    = sin( $a );
		$anchor = $cos > 0.3 ? 'start' : ( $cos < -0.3 ? 'end' : 'middle' );
		$tx     = round( $x + 22 * $cos, 1 );
		$ty     = round( $y + 30 * $sin, 1 ) + ( 'middle' === $anchor ? ( $sin < 0 ? -14 : 8 ) : -2 );

		$lines .= '<path d="M' . $cx . ' ' . $cy . 'L' . $x . ' ' . $y . '"/>';
		$dots  .= '<circle cx="' . $x . '" cy="' . $y . '" r="9" class="hub-dot"/>';
		$dots  .= '<text x="' . $tx . '" y="' . $ty . '" text-anchor="' . $anchor . '" class="hub-name">' . esc_html( $n[0] ) . '</text>';
		$dots  .= '<text x="' . $tx . '" y="' . ( $ty + 17 ) . '" text-anchor="' . $anchor . '" class="hub-kind">' . esc_html( $n[1] ) . '</text>';
	}

	$o .= '<g fill="none" stroke="currentColor" stroke-width="1.5" opacity=".55">' . $lines . '</g>';
	$o .= $dots;

	// Núcleo con el isotipo.
	$o .= '<rect x="' . ( $cx - 58 ) . '" y="' . ( $cy - 58 ) . '" width="116" height="116" class="hub-core"/>';
	$o .= '<g transform="translate(' . ( $cx - 33 ) . ' ' . ( $cy - 33 ) . ') scale(.5)"><path d="M0 0H42L132 132H90Z" fill="#C0C6D4"/><path d="M90 0H132L42 132H0Z" fill="#00AEEF"/></g>';
	$o .= '</svg>';

	return $o;
}

/**
 * Isotipo (la X) para usos decorativos.
 */
function nexxus_isotipo( $class = 'isotipo' ) {
	return '<svg class="' . esc_attr( $class ) . '" viewBox="0 0 132 132" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg"><path d="M0 0H42L132 132H90Z" fill="#C0C6D4"/><path d="M90 0H132L42 132H0Z" fill="#00AEEF"/></svg>';
}
