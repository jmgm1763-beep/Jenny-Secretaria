<?php
/**
 * Contenido de la web, tomado del Dossier Corporativo NEXXUS (Ed. 01 · noviembre 2026).
 * Para cambiar un texto, basta con editarlo aquí.
 *
 * @package Nexxus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Los tres pilares de NEXXUS.
 */
function nexxus_pillars() {
	return array(
		array( 'Activo', 'Suelo y producto terciario', 'Parques de medianas, naves industriales y logísticas, y suelos para su desarrollo. Captación, valoración y comercialización.' ),
		array( 'Capital', 'Financiación y ayudas', 'Acceso a subvenciones y programas públicos, y relación directa con ayuntamientos de toda España.' ),
		array( 'Sistema', 'Construcción industrializada', 'Steel Frame en altura y estructuras metálicas industriales, con ingeniería, fabricación en taller y montaje especializado.' ),
	);
}

/**
 * Las cinco fases del modelo.
 */
function nexxus_phases() {
	return array(
		array( 'Origen del activo', 'Búsqueda y captación de suelo, naves y activos terciarios. Valoración y análisis urbanístico.', array( 'Trading Habitat' ) ),
		array( 'Viabilidad y financiación', 'Estudio económico, programas de ayudas, convenios municipales y tramitación.', array( 'DS Consultores', 'NEXXUS' ) ),
		array( 'Ingeniería y sistema', 'Elección del sistema industrializado según el uso: residencial en altura o industrial.', array( 'REMAGIN', 'CUALIMETAL' ) ),
		array( 'Fabricación y montaje', 'Producción en taller y montaje en obra con equipos formados y acreditados.', array( 'DhHouse', 'CUALIMETAL' ) ),
		array( 'Comercialización y salida', 'Venta o alquiler del producto terminado y gestión de la salida del inversor.', array( 'Trading Habitat' ) ),
	);
}

/**
 * Líneas de negocio.
 */
function nexxus_lines() {
	return array(
		array(
			'letter' => 'A',
			'tag'    => 'Línea prioritaria',
			'title'  => 'Activos terciarios e industriales',
			'art'    => 'nave',
			'items'  => array(
				'Parques de medianas y retail',
				'Naves industriales y logísticas',
				'Suelo industrial, terciario y logístico',
				'Promoción llave en mano con sistema CUALIMETAL',
			),
		),
		array(
			'letter' => 'B',
			'tag'    => 'LGSF hasta 15 plantas',
			'title'  => 'Edificación residencial en altura',
			'art'    => 'torre',
			'items'  => array(
				'Vivienda plurifamiliar y build to rent',
				'Residencias, hoteles y equipamientos',
				'Sistema REMAGIN con montaje DhHouse',
				'Plazos de ejecución hasta un 50 % menores',
			),
		),
		array(
			'letter' => 'C',
			'tag'    => 'Plan Estatal de Vivienda · Ayuntamientos',
			'title'  => 'Vivienda pública y municipios',
			'art'    => 'vivienda',
			'items'  => array(
				'Vivienda asequible y protegida',
				'Proyectos municipales y licitaciones',
				'Gestión de ayudas con DS Consultores',
				'Red comercial con presencia nacional',
			),
		),
	);
}

/**
 * Los cinco partners del ecosistema.
 */
function nexxus_partners() {
	return array(
		array(
			'id'       => 'trading-habitat',
			'name'     => 'Trading Habitat',
			'kind'     => 'Real Estate terciario',
			'meta'     => 'Global Real Estate · Amposta (Tarragona)',
			'lines'    => 'Línea A',
			'intro'    => 'Consultora inmobiliaria con sede en Amposta, especializada en activos terciarios e industriales y en captación de suelo para desarrollo. Opera en Terres de l\'Ebre y Costa Daurada y llega a todo el mercado nacional a través de su red de colaboración.',
			'role'     => 'Origina los activos y cierra la salida. Detecta suelos y producto terciario, y comercializa el resultado una vez construido.',
			'figures'  => array(
				array( '+500', 'agencias en la red Agora MLS' ),
				array( '3', 'tipos de activo: medianas, naves y suelo' ),
			),
			'services' => array(
				array( 'Parques de medianas', 'Comercialización, alquiler y búsqueda de operadores retail.' ),
				array( 'Naves industriales y logísticas', 'Venta, alquiler y operaciones de compraventa con arrendamiento posterior.' ),
				array( 'Suelo', 'Captación de suelo industrial, terciario y logístico, con análisis urbanístico.' ),
				array( 'Valoración e inversión', 'Valoraciones, estudios de mercado y asesoría a inversores.' ),
			),
		),
		array(
			'id'       => 'ds-consultores',
			'name'     => 'DS Consultores',
			'kind'     => 'Subvenciones y gestión técnica',
			'meta'     => 'Ayudas públicas · Administración local',
			'lines'    => 'Línea C',
			'intro'    => 'Consultora especializada en ayudas y subvenciones públicas para entidades locales y empresas. Acompaña a cada proyecto desde la búsqueda de la convocatoria hasta su justificación final.',
			'role'     => 'Abre la puerta de la vivienda pública. Identifica la financiación y conecta los proyectos de los ayuntamientos con el sistema industrializado.',
			'figures'  => array(
				array( '14', 'comerciales repartidos por España' ),
				array( '360°', 'de la convocatoria a la justificación final' ),
			),
			'services' => array(
				array( 'Ayudas y subvenciones', 'Detección de convocatorias, redacción de solicitudes y tramitación.' ),
				array( 'Justificación y asesoría jurídica', 'Seguimiento administrativo y justificación ante el organismo que concede la ayuda.' ),
				array( 'Relación con ayuntamientos', 'Convenios con entidades locales para impulsar proyectos de vivienda.' ),
				array( 'Consultoría ambiental y digital', 'Proyectos de sostenibilidad y transformación digital.' ),
			),
		),
		array(
			'id'       => 'remagin',
			'name'     => 'REMAGIN',
			'kind'     => 'Sistema industrializado en altura',
			'meta'     => 'By Etex · Light Gauge Steel Frame',
			'lines'    => 'Línea B',
			'intro'    => 'Diseña, calcula y fabrica superestructuras de acero ligero galvanizado para edificios de hasta 15 plantas. Forma parte del Grupo Etex, multinacional belga de materiales de construcción, y suma más de dos décadas de experiencia en Reino Unido e Irlanda.',
			'role'     => 'Aporta el sistema constructivo para vivienda plurifamiliar, build to rent y equipamientos públicos. Referencias en España: Estepona, Fuengirola, Sevilla, Badajoz y Castellón.',
			'figures'  => array(
				array( '+50.000', 'viviendas ejecutadas en Reino Unido e Irlanda' ),
				array( '−50 %', 'de plazo de ejecución, hasta' ),
				array( '15', 'plantas de altura máxima' ),
				array( '45', 'países con presencia del Grupo Etex' ),
			),
			'services' => array(
				array( 'Estructura portante LGSF', 'Muros portantes y forjados patentados fabricados fuera de obra.' ),
				array( 'Fachadas SFS', 'Sistema de perfilería para cerramientos no portantes.' ),
				array( 'Sistema completo ensayado', 'Integra componentes del grupo (Pladur, URSA, Promat, Equitone) para fuego, acústica y térmica.' ),
				array( 'Ingeniería propia', 'Un único proveedor desde el cálculo hasta la entrega en obra. Sistema con DAU 26/163 del ITeC.' ),
			),
		),
		array(
			'id'       => 'dhhouse',
			'name'     => 'DhHouse',
			'kind'     => 'Montaje Steel Frame',
			'meta'     => 'DomusHouse Ibérica · Girona · Amposta',
			'lines'    => 'Líneas B y C',
			'intro'    => 'Especialistas en montaje de estructuras de acero galvanizado. Ofrecen un servicio completo: cálculo, fabricación y premontaje en taller, y montaje en obra con equipos propios formados en el sistema.',
			'role'     => 'Garantiza la ejecución. Monta el sistema en altura y forma y acredita, junto a REMAGIN, a los equipos y constructoras locales que trabajarán con NEXXUS.',
			'figures'  => array(
				array( '3', 'servicios: cálculo, taller y obra' ),
				array( '3', 'líneas: dhhouse, dhkube y dhlogic' ),
			),
			'services' => array(
				array( 'Ingeniería', 'Análisis y cálculo estructural conforme a la normativa española.' ),
				array( 'Fabricación y premontaje 2D', 'Paneles de muro y cerchas ensamblados en taller.' ),
				array( 'Montaje estructural', 'Montaje ligero en obra, sin necesidad de maquinaria pesada.' ),
				array( 'Escuela de Montaje', 'Formación y acreditación de nuevos equipos para crecer en todo el territorio.' ),
			),
		),
		array(
			'id'       => 'cualimetal',
			'name'     => 'CUALIMETAL',
			'kind'     => 'Sistemas industriales',
			'meta'     => 'Zaragoza · Desde 1993',
			'lines'    => 'Línea A',
			'intro'    => 'Fabricante zaragozano de edificios industriales de estructura metálica. Diseña, fabrica, suministra y monta naves completas con sistemas propios registrados y patentados, y ha llevado sus estructuras a los cinco continentes.',
			'role'     => 'Construye el producto de la línea terciaria e industrial: naves logísticas y de producción, cubiertas para medianas, pabellones y estructuras fotovoltaicas. Plazos cortos y precio cerrado desde fábrica.',
			'figures'  => array(
				array( '2.783', 'proyectos ejecutados' ),
				array( '53', 'países con estructuras CUALIMETAL' ),
				array( '7', 'sistemas propios registrados' ),
				array( '40 m', 'de luz libre máxima' ),
			),
			'services' => array(
				array( 'Ingeniería', 'Cálculo estructural, modelado 3D e ingeniería de fabricación y montaje.' ),
				array( 'Fabricación propia', 'Estructura metálica y perfiles galvanizados conformados en frío.' ),
				array( 'Montaje o supervisión', 'Montaje en obra o supervisión del montaje realizado por el cliente.' ),
				array( 'Suministro en kit', 'Envío con documentación técnica y manual de montaje.' ),
				array( 'Sistemas propios', 'ECORAPID®, MECARAPID®, NAVERAPID®, PLENAVE®, MARQUISOL®, RAPIDSOL® y nave a medida.' ),
			),
		),
	);
}

/**
 * Lo que gana el cliente.
 */
function nexxus_advantages() {
	return array(
		array( 'Un único interlocutor', 'Un solo responsable coordina suelo, ingeniería, fabricación, montaje y venta. Sin huecos entre empresas.' ),
		array( 'Sistemas certificados', 'Sistemas ensayados y con evaluación técnica, fabricados por empresas con trayectoria internacional.' ),
		array( 'Acceso a financiación', 'Ayudas públicas y convenios con ayuntamientos gestionados por especialistas.' ),
		array( 'Plazo y coste cerrados', 'La fabricación en taller fija el precio y acorta la obra. Menos tiempo de obra significa menos coste financiero.' ),
		array( 'Alcance nacional', 'Red comercial en toda España y equipos de montaje acreditados que crecen con la demanda.' ),
		array( 'Salida asegurada', 'Comercialización del activo terminado con la misma estructura que lo originó.' ),
	);
}

/**
 * A quién se dirige NEXXUS.
 */
function nexxus_audiences() {
	return array(
		'Promotores',
		'Fondos y family offices',
		'Operadores logísticos',
		'Operadores retail',
		'Propietarios de suelo',
		'Ayuntamientos',
		'Empresas industriales',
		'Inversores build to rent',
	);
}

/**
 * Vínculo de cada partner con la marca.
 */
function nexxus_agreements() {
	return array(
		array( 'Trading Habitat', 'Acuerdo marco de colaboración comercial', 'Activos, suelo y comercialización', 'Proyectos de construcción y clientes inversores' ),
		array( 'DS Consultores', 'Acuerdo marco de colaboración y prescripción', 'Ayudas públicas y red municipal', 'Sistema industrializado y equipo técnico para sus proyectos' ),
		array( 'REMAGIN', 'Acuerdo marco de prescripción y agencia', 'Sistema en altura e ingeniería', 'Proyectos y clientes prescritos' ),
		array( 'CUALIMETAL', 'Acuerdo marco de prescripción y agencia', 'Sistemas industriales e ingeniería', 'Proyectos terciarios e industriales' ),
		array( 'DhHouse', 'Acuerdo marco de montaje preferente', 'Montaje y formación de equipos', 'Carga de trabajo estable' ),
	);
}

/**
 * Reglas entre partners.
 */
function nexxus_rules() {
	return array(
		array( 'Registro único', 'registro' ),
		array( 'No elusión', 'no-elusion' ),
		array( 'Confidencialidad', 'confidencialidad' ),
		array( 'Soporte técnico', 'soporte' ),
		array( 'Formación de equipos', 'formacion' ),
		array( 'Alcance internacional', 'internacional' ),
	);
}

/**
 * Tipos de proyecto del formulario.
 */
function nexxus_project_types() {
	return array(
		'terciario'   => 'Activo terciario o industrial',
		'residencial' => 'Edificación residencial en altura',
		'publica'     => 'Vivienda pública o proyecto municipal',
		'suelo'       => 'Suelo por desarrollar',
		'otro'        => 'Otra consulta',
	);
}

/**
 * Datos del titular de la marca.
 */
function nexxus_owner() {
	return array(
		'name'    => 'Projectes Immobiliaris Montsià SL',
		'cif'     => 'B43605989',
		'address' => 'C/ Llorer, 29 · 43870 Amposta (Tarragona)',
	);
}

/**
 * Borrador de aviso legal (se crea como borrador al activar el tema).
 */
function nexxus_legal_notice_draft() {
	$o = nexxus_owner();
	return '<!-- wp:paragraph --><p><strong>BORRADOR PENDIENTE DE REVISIÓN.</strong> Revise este texto con su asesor legal antes de publicarlo.</p><!-- /wp:paragraph -->'
		. '<!-- wp:heading --><h2 class="wp-block-heading">Titular del sitio web</h2><!-- /wp:heading -->'
		. '<!-- wp:paragraph --><p>NEXXUS es una marca de ' . esc_html( $o['name'] ) . ', con CIF ' . esc_html( $o['cif'] ) . ' y domicilio en ' . esc_html( $o['address'] ) . '.</p><!-- /wp:paragraph -->'
		. '<!-- wp:paragraph --><p>Contacto: ' . esc_html( nexxus_opt( 'contact_phone' ) ) . ' · ' . esc_html( nexxus_opt( 'contact_email' ) ) . '</p><!-- /wp:paragraph -->'
		. '<!-- wp:paragraph --><p>[Añadir datos de inscripción en el Registro Mercantil.]</p><!-- /wp:paragraph -->'
		. '<!-- wp:heading --><h2 class="wp-block-heading">Propiedad intelectual e industrial</h2><!-- /wp:heading -->'
		. '<!-- wp:paragraph --><p>Los nombres y marcas de los partners pertenecen a sus respectivos titulares. Los datos de los partners proceden de su información pública.</p><!-- /wp:paragraph -->';
}

/**
 * Borrador de política de privacidad (se crea como borrador al activar el tema).
 */
function nexxus_privacy_draft() {
	$o = nexxus_owner();
	return '<!-- wp:paragraph --><p><strong>BORRADOR PENDIENTE DE REVISIÓN.</strong> Revise este texto con su asesor legal antes de publicarlo.</p><!-- /wp:paragraph -->'
		. '<!-- wp:heading --><h2 class="wp-block-heading">Responsable del tratamiento</h2><!-- /wp:heading -->'
		. '<!-- wp:paragraph --><p>' . esc_html( $o['name'] ) . ' · CIF ' . esc_html( $o['cif'] ) . ' · ' . esc_html( $o['address'] ) . ' · ' . esc_html( nexxus_opt( 'contact_email' ) ) . '</p><!-- /wp:paragraph -->'
		. '<!-- wp:heading --><h2 class="wp-block-heading">Finalidad</h2><!-- /wp:heading -->'
		. '<!-- wp:paragraph --><p>Atender las consultas recibidas a través del formulario de contacto de esta web.</p><!-- /wp:paragraph -->'
		. '<!-- wp:heading --><h2 class="wp-block-heading">Legitimación, conservación y destinatarios</h2><!-- /wp:heading -->'
		. '<!-- wp:paragraph --><p>[Completar con su asesor legal: base jurídica, plazo de conservación y, en su caso, comunicación de datos a los partners que intervengan en el proyecto.]</p><!-- /wp:paragraph -->'
		. '<!-- wp:heading --><h2 class="wp-block-heading">Derechos</h2><!-- /wp:heading -->'
		. '<!-- wp:paragraph --><p>Puede ejercer sus derechos de acceso, rectificación, supresión, oposición, limitación y portabilidad escribiendo a ' . esc_html( nexxus_opt( 'contact_email' ) ) . '. También puede presentar una reclamación ante la Agencia Española de Protección de Datos (www.aepd.es).</p><!-- /wp:paragraph -->';
}

/**
 * Cifras destacadas bajo la portada (datos del dossier).
 */
function nexxus_stats() {
	return array(
		array( 'n' => 5, 'pre' => '', 'suf' => '', 'text' => '5', 'label' => 'empresas especialistas bajo una sola dirección' ),
		array( 'n' => 50000, 'pre' => '+', 'suf' => '', 'text' => '+50.000', 'label' => 'viviendas ejecutadas por REMAGIN en Reino Unido e Irlanda' ),
		array( 'n' => 2783, 'pre' => '', 'suf' => '', 'text' => '2.783', 'label' => 'proyectos industriales ejecutados por CUALIMETAL' ),
		array( 'n' => 50, 'pre' => '−', 'suf' => ' %', 'text' => '−50 %', 'label' => 'de plazo de ejecución, hasta' ),
	);
}

/**
 * Descripción breve de la marca.
 */
function nexxus_brand_line() {
	return 'NEXXUS Advisor es una marca de consultoría inmobiliaria y de construcción industrializada.';
}

/**
 * Especialistas vinculados a cada línea de negocio (identificadores de nexxus_partners).
 */
function nexxus_line_partners() {
	return array(
		'A' => array( 'cualimetal', 'trading-habitat' ),
		'B' => array( 'remagin', 'dhhouse' ),
		'C' => array( 'ds-consultores' ),
	);
}
