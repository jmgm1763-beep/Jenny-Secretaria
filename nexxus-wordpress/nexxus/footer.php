<?php
/**
 * Pie de página.
 *
 * @package Nexxus
 */

$nexxus_owner = nexxus_owner();
$nexxus_phone = nexxus_opt( 'contact_phone' );
$nexxus_email = nexxus_opt( 'contact_email' );
?>
</main>

<footer class="site-footer">
	<div class="wrap site-footer__in">
		<div class="site-footer__brand">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo-negativo.svg' ); ?>" alt="NEXXUS" width="701" height="148" loading="lazy">
			<p>Real Estate y construcción industrializada.<br>Un solo interlocutor desde el suelo hasta la entrega.</p>
		</div>

		<div class="site-footer__contact">
			<p class="site-footer__label">Dirección</p>
			<p>
				<strong><?php echo esc_html( nexxus_opt( 'contact_name' ) ); ?></strong><br>
				<?php echo esc_html( nexxus_opt( 'contact_role' ) ); ?><br>
				<a href="<?php echo esc_url( nexxus_tel_href( $nexxus_phone ) ); ?>"><?php echo esc_html( $nexxus_phone ); ?></a><br>
				<a href="<?php echo esc_attr( 'mailto:' . antispambot( $nexxus_email ) ); ?>"><?php echo esc_html( antispambot( $nexxus_email ) ); ?></a>
			</p>
		</div>

		<div class="site-footer__legal">
			<p class="site-footer__label">La marca</p>
			<p><?php echo esc_html( nexxus_brand_line() ); ?></p>
		</div>
	</div>

	<div class="wrap site-footer__base">
		<p>© <?php echo esc_html( gmdate( 'Y' ) ); ?> NEXXUS. Los nombres y marcas de los partners pertenecen a sus respectivos titulares. Datos de los partners según su información pública, noviembre 2026.</p>
		<?php nexxus_legal_links(); ?>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
