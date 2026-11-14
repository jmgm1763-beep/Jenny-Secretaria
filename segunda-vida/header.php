<?php defined( 'ABSPATH' ) || exit; ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="screen-reader-text sv-skip" href="#contenido"><?php esc_html_e( 'Saltar al contenido', 'segunda-vida' ); ?></a>

<?php if ( sv_opt( 'announcement' ) ) : ?>
	<p class="sv-announce"><?php echo esc_html( sv_opt( 'announcement' ) ); ?></p>
<?php endif; ?>

<header class="sv-header">
	<div class="sv-container sv-header__row">
		<button class="sv-iconbtn sv-header__toggle" type="button" aria-expanded="false" aria-controls="sv-nav">
			<?php echo sv_icon( 'menu' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<span class="screen-reader-text"><?php esc_html_e( 'Menú', 'segunda-vida' ); ?></span>
		</button>

		<div class="sv-logo">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
			<?php endif; ?>
		</div>

		<form class="sv-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<label class="screen-reader-text" for="sv-search-input"><?php esc_html_e( 'Buscar artículos', 'segunda-vida' ); ?></label>
			<?php echo sv_icon( 'search' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<input id="sv-search-input" type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Busca por artículo, marca o estilo', 'segunda-vida' ); ?>">
			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
				<input type="hidden" name="post_type" value="product">
			<?php endif; ?>
		</form>

		<div class="sv-header__actions">
			<?php if ( sv_favorites_url() ) : ?>
				<a class="sv-iconbtn" href="<?php echo esc_url( sv_favorites_url() ); ?>">
					<?php echo sv_icon( 'heart' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<span class="sv-count sv-fav-count" hidden>0</span>
					<span class="screen-reader-text"><?php esc_html_e( 'Favoritos', 'segunda-vida' ); ?></span>
				</a>
			<?php endif; ?>
			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
				<a class="sv-iconbtn sv-header__account" href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>">
					<?php echo sv_icon( 'user' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<span class="screen-reader-text"><?php esc_html_e( 'Mi cuenta', 'segunda-vida' ); ?></span>
				</a>
				<?php if ( ! sv_opt( 'catalog_mode' ) ) : ?>
					<a class="sv-iconbtn" href="<?php echo esc_url( wc_get_cart_url() ); ?>">
						<?php echo sv_icon( 'bag' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php echo sv_cart_count_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<span class="screen-reader-text"><?php esc_html_e( 'Cesta', 'segunda-vida' ); ?></span>
					</a>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>

	<nav id="sv-nav" class="sv-nav" aria-label="<?php esc_attr_e( 'Categorías', 'segunda-vida' ); ?>">
		<div class="sv-container">
			<?php sv_primary_nav(); ?>
		</div>
	</nav>
</header>
