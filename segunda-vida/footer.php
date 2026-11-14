<?php defined( 'ABSPATH' ) || exit; ?>
<footer class="sv-footer">
	<div class="sv-container sv-footer__grid">
		<div class="sv-footer__about">
			<p class="sv-footer__brand"><?php bloginfo( 'name' ); ?></p>
			<p><?php echo esc_html( get_bloginfo( 'description' ) ? get_bloginfo( 'description' ) : __( 'Artículos de segunda mano seleccionados con cariño.', 'segunda-vida' ) ); ?></p>
		</div>

		<?php
		$sv_cats = taxonomy_exists( 'product_cat' ) ? get_terms( array(
			'taxonomy'   => 'product_cat',
			'parent'     => 0,
			'hide_empty' => true,
			'exclude'    => array( (int) get_option( 'default_product_cat' ) ),
			'number'     => 6,
		) ) : array();
		if ( $sv_cats && ! is_wp_error( $sv_cats ) ) :
			?>
			<div>
				<h2 class="sv-footer__title"><?php esc_html_e( 'Comprar', 'segunda-vida' ); ?></h2>
				<ul>
					<?php foreach ( $sv_cats as $sv_cat ) : ?>
						<li><a href="<?php echo esc_url( get_term_link( $sv_cat ) ); ?>"><?php echo esc_html( $sv_cat->name ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>

		<?php if ( has_nav_menu( 'footer' ) ) : ?>
			<div>
				<h2 class="sv-footer__title"><?php esc_html_e( 'Ayuda', 'segunda-vida' ); ?></h2>
				<?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'depth' => 1 ) ); ?>
			</div>
		<?php endif; ?>

		<?php
		$sv_links = sv_shop_profiles();
		if ( sv_opt( 'instagram_url' ) ) {
			$sv_links['Instagram'] = sv_opt( 'instagram_url' );
		}
		if ( sv_whatsapp_url() ) {
			$sv_links['WhatsApp'] = sv_whatsapp_url();
		}
		if ( $sv_links ) :
			?>
			<div>
				<h2 class="sv-footer__title"><?php esc_html_e( 'Encuéntranos también en', 'segunda-vida' ); ?></h2>
				<ul>
					<?php foreach ( $sv_links as $sv_name => $sv_url ) : ?>
						<li><a href="<?php echo esc_url( $sv_url ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $sv_name ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>
	</div>
	<div class="sv-container sv-footer__legal">
		<p>&copy; <?php echo esc_html( gmdate( 'Y' ) . ' ' . get_bloginfo( 'name' ) ); ?></p>
		<?php if ( function_exists( 'the_privacy_policy_link' ) ) { the_privacy_policy_link(); } ?>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
