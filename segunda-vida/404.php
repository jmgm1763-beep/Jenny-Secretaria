<?php
defined( 'ABSPATH' ) || exit;
get_header();
?>
<main id="contenido" class="sv-main sv-container sv-empty">
	<h1><?php esc_html_e( 'Esta página ya no está disponible', 'segunda-vida' ); ?></h1>
	<p><?php esc_html_e( 'Puede que el artículo se haya vendido. Echa un vistazo a lo último que ha llegado.', 'segunda-vida' ); ?></p>
	<a class="sv-btn sv-btn--primary" href="<?php echo esc_url( sv_shop_url() ); ?>"><?php esc_html_e( 'Ver el catálogo', 'segunda-vida' ); ?></a>
</main>
<?php
get_footer();
