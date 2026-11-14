<?php
/**
 * Portada de la tienda.
 */
defined( 'ABSPATH' ) || exit;
get_header();

$sv_has_shop = class_exists( 'WooCommerce' );
$sv_hero_img = sv_opt( 'hero_image' ) ? sv_opt( 'hero_image' ) : get_template_directory_uri() . '/assets/demo/hero.jpg';
$sv_profiles = sv_shop_profiles();
?>
<main id="contenido" class="sv-home">

	<section class="sv-hero">
		<div class="sv-container sv-hero__grid">
			<div class="sv-hero__copy">
				<?php if ( sv_opt( 'hero_eyebrow' ) ) : ?>
					<p class="sv-eyebrow"><?php echo esc_html( sv_opt( 'hero_eyebrow' ) ); ?></p>
				<?php endif; ?>
				<h1><?php echo esc_html( sv_opt( 'hero_title' ) ); ?></h1>
				<p class="sv-hero__text"><?php echo esc_html( sv_opt( 'hero_text' ) ); ?></p>
				<div class="sv-hero__actions">
					<a class="sv-btn sv-btn--primary" href="<?php echo esc_url( sv_shop_url() ); ?>"><?php echo esc_html( sv_opt( 'hero_cta' ) ); ?></a>
					<?php foreach ( $sv_profiles as $sv_name => $sv_url ) : ?>
						<a class="sv-btn sv-btn--ghost" href="<?php echo esc_url( $sv_url ); ?>" target="_blank" rel="noopener">
							<?php
							/* translators: %s: nombre de la plataforma. */
							echo esc_html( sprintf( __( 'Ver en %s', 'segunda-vida' ), $sv_name ) );
							?>
						</a>
						<?php break; // Solo el primer perfil; el resto aparece en la banda inferior. ?>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="sv-hero__media">
				<img src="<?php echo esc_url( $sv_hero_img ); ?>" alt="" width="1200" height="900" fetchpriority="high">
			</div>
		</div>
	</section>

	<section class="sv-trust" aria-label="<?php esc_attr_e( 'Garantías', 'segunda-vida' ); ?>">
		<ul class="sv-container sv-trust__list">
			<?php foreach ( array( 1 => 'check', 2 => 'lock', 3 => 'box' ) as $sv_i => $sv_icon ) : ?>
				<?php if ( sv_opt( "trust_{$sv_i}_title" ) ) : ?>
					<li>
						<?php echo sv_icon( $sv_icon ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<div>
							<strong><?php echo esc_html( sv_opt( "trust_{$sv_i}_title" ) ); ?></strong>
							<span><?php echo esc_html( sv_opt( "trust_{$sv_i}_text" ) ); ?></span>
						</div>
					</li>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
	</section>

	<?php if ( $sv_has_shop ) : ?>

		<?php
		$sv_cats = get_terms( array(
			'taxonomy'   => 'product_cat',
			'parent'     => 0,
			'hide_empty' => true,
			'exclude'    => array( (int) get_option( 'default_product_cat' ) ),
			'number'     => 6,
		) );
		if ( $sv_cats && ! is_wp_error( $sv_cats ) ) :
			?>
			<section class="sv-section sv-container">
				<header class="sv-section__head">
					<h2><?php esc_html_e( 'Compra por categoría', 'segunda-vida' ); ?></h2>
				</header>
				<ul class="sv-cats">
					<?php foreach ( $sv_cats as $sv_cat ) : ?>
						<?php $sv_thumb = (int) get_term_meta( $sv_cat->term_id, 'thumbnail_id', true ); ?>
						<li>
							<a class="sv-cat" href="<?php echo esc_url( get_term_link( $sv_cat ) ); ?>">
								<span class="sv-cat__media">
									<?php
									if ( $sv_thumb ) {
										echo wp_get_attachment_image( $sv_thumb, 'woocommerce_thumbnail', false, array( 'alt' => '' ) );
									}
									?>
								</span>
								<span class="sv-cat__name"><?php echo esc_html( $sv_cat->name ); ?></span>
								<span class="sv-cat__count">
									<?php
									/* translators: %d: número de artículos. */
									echo esc_html( sprintf( _n( '%d artículo', '%d artículos', $sv_cat->count, 'segunda-vida' ), $sv_cat->count ) );
									?>
								</span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</section>
		<?php endif; ?>

		<?php
		$sv_latest = wc_get_products( array(
			'status'       => 'publish',
			'limit'        => 8,
			'orderby'      => 'date',
			'order'        => 'DESC',
			'stock_status' => 'instock',
			'return'       => 'ids',
		) );
		?>
		<section class="sv-section sv-container woocommerce">
			<header class="sv-section__head">
				<h2><?php esc_html_e( 'Recién llegados', 'segunda-vida' ); ?></h2>
				<a class="sv-link" href="<?php echo esc_url( add_query_arg( 'orderby', 'date', sv_shop_url() ) ); ?>"><?php esc_html_e( 'Ver todo', 'segunda-vida' ); ?> <?php echo sv_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
			</header>
			<?php if ( $sv_latest ) : ?>
				<?php sv_render_products( $sv_latest ); ?>
			<?php else : ?>
				<p class="sv-empty">
					<?php esc_html_e( 'Aquí aparecerán tus artículos en cuanto publiques el primero.', 'segunda-vida' ); ?>
					<?php if ( current_user_can( 'edit_products' ) ) : ?>
						<a href="<?php echo esc_url( admin_url( 'themes.php?page=segunda-vida' ) ); ?>"><?php esc_html_e( 'Abrir la guía de puesta en marcha', 'segunda-vida' ); ?></a>
					<?php endif; ?>
				</p>
			<?php endif; ?>
		</section>

	<?php endif; ?>

	<section class="sv-story">
		<div class="sv-container sv-story__inner">
			<h2><?php echo esc_html( sv_opt( 'story_title' ) ); ?></h2>
			<p><?php echo esc_html( sv_opt( 'story_text' ) ); ?></p>
		</div>
	</section>

	<?php
	$sv_budget = (int) sv_opt( 'budget_price' );
	$sv_cheap  = array();
	if ( $sv_has_shop && $sv_budget > 0 ) {
		$sv_cheap = get_posts( array(
			'post_type'   => 'product',
			'post_status' => 'publish',
			'numberposts' => 4,
			'fields'      => 'ids',
			'orderby'     => 'rand',
			'meta_query'  => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
				array( 'key' => '_price', 'value' => $sv_budget, 'compare' => '<=', 'type' => 'NUMERIC' ),
				array( 'key' => '_stock_status', 'value' => 'instock' ),
			),
		) );
	}
	if ( $sv_cheap ) :
		?>
		<section class="sv-section sv-container woocommerce">
			<header class="sv-section__head">
				<h2>
					<?php
					/* translators: %s: precio. */
					echo wp_kses_post( sprintf( __( 'Hallazgos hasta %s', 'segunda-vida' ), wc_price( $sv_budget, array( 'decimals' => 0 ) ) ) );
					?>
				</h2>
				<a class="sv-link" href="<?php echo esc_url( add_query_arg( 'max_price', $sv_budget, sv_shop_url() ) ); ?>"><?php esc_html_e( 'Ver todo', 'segunda-vida' ); ?> <?php echo sv_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
			</header>
			<?php sv_render_products( $sv_cheap ); ?>
		</section>
	<?php endif; ?>

	<section class="sv-section sv-container">
		<header class="sv-section__head sv-section__head--center">
			<h2><?php esc_html_e( 'Comprar es así de fácil', 'segunda-vida' ); ?></h2>
		</header>
		<ol class="sv-steps">
			<li>
				<h3><?php esc_html_e( 'Elige tu pieza', 'segunda-vida' ); ?></h3>
				<p><?php esc_html_e( 'Filtra por categoría, estado y precio. Cada ficha detalla medidas, material y cualquier señal de uso.', 'segunda-vida' ); ?></p>
			</li>
			<li>
				<h3><?php esc_html_e( 'Compra como prefieras', 'segunda-vida' ); ?></h3>
				<p><?php esc_html_e( 'Directamente en la web o, si lo prefieres, a través de nuestro perfil en tu plataforma habitual.', 'segunda-vida' ); ?></p>
			</li>
			<li>
				<h3><?php esc_html_e( 'Recíbelo en casa', 'segunda-vida' ); ?></h3>
				<p><?php esc_html_e( 'Lo preparamos con cuidado y te avisamos en cuanto sale. ¿Dudas? Escríbenos y te respondemos en el día.', 'segunda-vida' ); ?></p>
			</li>
		</ol>
	</section>

	<?php if ( $sv_profiles ) : ?>
		<section class="sv-market">
			<div class="sv-container sv-market__inner">
				<div>
					<h2><?php esc_html_e( '¿Prefieres comprar en tu app de siempre?', 'segunda-vida' ); ?></h2>
					<p><?php esc_html_e( 'Nuestro armario también está en estas plataformas, con las mismas piezas y sus sistemas de envío y protección al comprador.', 'segunda-vida' ); ?></p>
				</div>
				<div class="sv-market__actions">
					<?php foreach ( $sv_profiles as $sv_name => $sv_url ) : ?>
						<a class="sv-btn sv-btn--light" href="<?php echo esc_url( $sv_url ); ?>" target="_blank" rel="noopener">
							<?php
							/* translators: %s: nombre de la plataforma. */
							echo esc_html( sprintf( __( 'Nuestro perfil en %s', 'segunda-vida' ), $sv_name ) );
							?>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

</main>
<?php
get_footer();
