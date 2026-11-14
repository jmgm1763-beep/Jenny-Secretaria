<?php
/**
 * Tarjeta de artículo del catálogo.
 *
 * @version 9.4.0
 */
defined( 'ABSPATH' ) || exit;

global $product;

if ( ! is_a( $product, WC_Product::class ) || ! $product->is_visible() ) {
	return;
}

$sv_brand = sv_term_name( $product->get_id(), 'product_brand' );
$sv_meta  = sv_product_meta_line( $product );
?>
<li <?php wc_product_class( 'sv-card', $product ); ?>>
	<div class="sv-card__media">
		<a href="<?php echo esc_url( $product->get_permalink() ); ?>" tabindex="-1" aria-hidden="true">
			<?php echo $product->get_image( 'woocommerce_thumbnail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</a>
		<?php if ( ! $product->is_in_stock() ) : ?>
			<span class="sv-badge sv-badge--sold"><?php esc_html_e( 'Vendido', 'segunda-vida' ); ?></span>
		<?php elseif ( $product->is_on_sale() ) : ?>
			<?php woocommerce_show_product_loop_sale_flash(); ?>
		<?php endif; ?>
		<button class="sv-fav" type="button" data-sv-fav="<?php echo esc_attr( $product->get_id() ); ?>" aria-pressed="false" aria-label="<?php esc_attr_e( 'Guardar en favoritos', 'segunda-vida' ); ?>">
			<?php echo sv_icon( 'heart' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</button>
	</div>
	<div class="sv-card__body">
		<?php if ( $sv_brand ) : ?>
			<p class="sv-card__brand"><?php echo esc_html( $sv_brand ); ?></p>
		<?php endif; ?>
		<h3 class="sv-card__title"><a href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a></h3>
		<?php if ( $sv_meta ) : ?>
			<p class="sv-card__meta"><?php echo esc_html( $sv_meta ); ?></p>
		<?php endif; ?>
		<p class="sv-card__price price"><?php echo wp_kses_post( $product->get_price_html() ); ?></p>
	</div>
</li>
