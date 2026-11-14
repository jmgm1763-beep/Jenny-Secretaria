<?php
/**
 * Template Name: Favoritos
 *
 * Los favoritos se guardan en el navegador del visitante (sin registro).
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>
<main id="contenido" class="sv-main sv-container woocommerce">
	<header class="sv-pagehead"><h1><?php the_title(); ?></h1></header>
	<ul class="products sv-favorites" data-sv-favorites aria-live="polite"></ul>
	<p class="sv-favorites__empty" hidden></p>
	<noscript><p><?php esc_html_e( 'Activa JavaScript para ver tus favoritos.', 'segunda-vida' ); ?></p></noscript>
</main>
<?php
get_footer();
