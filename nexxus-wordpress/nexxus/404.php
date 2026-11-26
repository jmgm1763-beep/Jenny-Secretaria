<?php
/**
 * Página no encontrada.
 *
 * @package Nexxus
 */

get_header();
?>

<div class="page-head">
	<div class="wrap">
		<h1>Página no encontrada</h1>
	</div>
</div>

<div class="wrap page-body">
	<p>La dirección que busca no existe o ha cambiado.</p>
	<p><a class="btn" href="<?php echo esc_url( home_url( '/' ) ); ?>">Volver al inicio</a></p>
</div>

<?php
get_footer();
