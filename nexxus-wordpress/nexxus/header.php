<?php
/**
 * Cabecera.
 *
 * @package Nexxus
 */

$nexxus_phone = nexxus_opt( 'contact_phone' );
$nexxus_nav   = array(
	'quienes-somos' => 'Quiénes somos',
	'modelo'        => 'El modelo',
	'lineas'        => 'Líneas de negocio',
	'ecosistema'    => 'Ecosistema',
	'ventajas'      => 'Por qué NEXXUS',
);
if ( nexxus_get_projects( 1 ) ) {
	$nexxus_nav = array_slice( $nexxus_nav, 0, 4, true ) + array( 'proyectos' => 'Proyectos' ) + array_slice( $nexxus_nav, 4, null, true );
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#contenido">Saltar al contenido</a>

<header class="site-header" id="cabecera">
	<div class="wrap site-header__in">
		<a class="site-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="NEXXUS · Inicio">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo-negativo.svg' ); ?>" alt="NEXXUS" width="701" height="148">
		</a>

		<button class="nav-toggle" type="button" aria-expanded="false" aria-controls="menu-principal">
			<span class="nav-toggle__bars" aria-hidden="true"></span>
			<span class="screen-reader-text">Menú</span>
		</button>

		<nav class="site-nav" id="menu-principal" aria-label="Principal">
			<ul>
				<?php foreach ( $nexxus_nav as $nexxus_id => $nexxus_label ) : ?>
					<li><a href="<?php echo esc_url( nexxus_anchor( $nexxus_id ) ); ?>"><?php echo esc_html( $nexxus_label ); ?></a></li>
				<?php endforeach; ?>
				<li class="site-nav__phone"><a href="<?php echo esc_url( nexxus_tel_href( $nexxus_phone ) ); ?>"><?php echo esc_html( $nexxus_phone ); ?></a></li>
				<li class="site-nav__cta"><a class="btn btn--sm" href="<?php echo esc_url( nexxus_anchor( 'contacto' ) ); ?>">Contacto</a></li>
			</ul>
		</nav>
	</div>
</header>

<main id="contenido">
