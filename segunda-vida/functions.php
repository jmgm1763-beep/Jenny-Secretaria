<?php
/**
 * Segunda Vida — tema para tiendas de artículos de segunda mano.
 */

defined( 'ABSPATH' ) || exit;

define( 'SV_VERSION', '1.0.0' );

require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/setup.php';
require get_template_directory() . '/inc/customizer.php';

if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/product-fields.php';
	require get_template_directory() . '/inc/woocommerce.php';
}

if ( is_admin() ) {
	require get_template_directory() . '/inc/demo.php';
}
