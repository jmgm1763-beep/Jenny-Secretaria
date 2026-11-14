<?php
/**
 * Panel «Apariencia → Segunda Vida»: guía de puesta en marcha y contenido de ejemplo.
 */
defined( 'ABSPATH' ) || exit;

add_action( 'admin_menu', function () {
	add_theme_page(
		__( 'Segunda Vida', 'segunda-vida' ),
		__( 'Segunda Vida', 'segunda-vida' ),
		'manage_options',
		'segunda-vida',
		'sv_admin_page'
	);
} );

add_action( 'admin_notices', function () {
	if ( ! class_exists( 'WooCommerce' ) && current_user_can( 'install_plugins' ) ) {
		echo '<div class="notice notice-warning"><p>' . wp_kses_post( sprintf(
			/* translators: %s: enlace a la pantalla de plugins. */
			__( '<strong>Segunda Vida</strong> necesita el plugin gratuito WooCommerce para mostrar el catálogo. <a href="%s">Instalarlo ahora</a>.', 'segunda-vida' ),
			esc_url( admin_url( 'plugin-install.php?s=woocommerce&tab=search&type=term' ) )
		) ) . '</p></div>';
	}
} );

function sv_admin_page() {
	$has_shop = class_exists( 'WooCommerce' );
	$imported = (bool) get_option( 'sv_demo_imported' );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Segunda Vida · Puesta en marcha', 'segunda-vida' ); ?></h1>

		<?php if ( isset( $_GET['sv_done'] ) ) : // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
			<div class="notice notice-success"><p><?php esc_html_e( 'Contenido de ejemplo importado. Ya puedes ver la tienda y sustituir los artículos por los tuyos.', 'segunda-vida' ); ?></p></div>
		<?php endif; ?>

		<ol style="max-width:760px;font-size:14px;line-height:1.7">
			<li>
				<strong><?php esc_html_e( 'Instala y activa WooCommerce', 'segunda-vida' ); ?></strong>
				<?php echo $has_shop ? ' ✓' : ''; ?><br>
				<?php esc_html_e( 'Es el motor de la tienda: catálogo, cesta, pagos y pedidos.', 'segunda-vida' ); ?>
			</li>
			<li>
				<strong><?php esc_html_e( 'Añade tus enlaces de Vinted, Wallapop y WhatsApp', 'segunda-vida' ); ?></strong><br>
				<a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[panel]=sv_panel' ) ); ?>"><?php esc_html_e( 'Abrir los ajustes de la tienda', 'segunda-vida' ); ?></a>
				— <?php esc_html_e( 'ahí también se cambian los textos e imagen de la portada y se activa el modo catálogo.', 'segunda-vida' ); ?>
			</li>
			<li>
				<strong><?php esc_html_e( 'Publica tus artículos', 'segunda-vida' ); ?></strong><br>
				<?php esc_html_e( 'En Productos → Añadir nuevo: fotos, precio, categoría, marca y «Estado». En la pestaña General encontrarás talla/medidas, material y el enlace del mismo artículo en Vinted o Wallapop. Cada artículo se guarda como pieza única (1 unidad) y pasa a «Vendido» al comprarse.', 'segunda-vida' ); ?>
			</li>
			<li>
				<strong><?php esc_html_e( 'Completa pagos, envíos y textos legales', 'segunda-vida' ); ?></strong><br>
				<?php esc_html_e( 'En WooCommerce → Ajustes. Asigna tus páginas de ayuda y avisos legales al «Menú del pie» en Apariencia → Menús.', 'segunda-vida' ); ?>
			</li>
		</ol>

		<h2><?php esc_html_e( 'Contenido de ejemplo', 'segunda-vida' ); ?></h2>
		<p style="max-width:760px">
			<?php esc_html_e( 'Crea categorías, estados y 12 artículos de muestra con ilustraciones para ver la tienda terminada. Después puedes borrarlos desde Productos.', 'segunda-vida' ); ?>
		</p>
		<?php if ( ! $has_shop ) : ?>
			<p><em><?php esc_html_e( 'Activa WooCommerce para poder importarlo.', 'segunda-vida' ); ?></em></p>
		<?php elseif ( $imported ) : ?>
			<p><em><?php esc_html_e( 'El contenido de ejemplo ya está importado.', 'segunda-vida' ); ?></em></p>
		<?php else : ?>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="sv_import_demo">
				<?php wp_nonce_field( 'sv_import_demo' ); ?>
				<?php submit_button( __( 'Importar contenido de ejemplo', 'segunda-vida' ), 'primary', 'submit', false ); ?>
			</form>
		<?php endif; ?>
	</div>
	<?php
}

add_action( 'admin_post_sv_import_demo', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'No tienes permisos para hacer esto.', 'segunda-vida' ) );
	}
	check_admin_referer( 'sv_import_demo' );
	sv_import_demo();
	wp_safe_redirect( admin_url( 'themes.php?page=segunda-vida&sv_done=1' ) );
	exit;
} );

function sv_demo_products() {
	// nombre, imagen, categoría, marca, estado, precio, precio rebajado, talla/medidas, material, color, descripción.
	return array(
		array( 'Sillón tapizado años 60', 'sillon', 'Mobiliario', 'Vintage', 'muy-buen-estado', 240, 195, '78 × 80 × 92 cm', 'Terciopelo y haya', 'Verde botella', 'Sillón de líneas redondeadas retapizado en terciopelo. Estructura firme, muelles revisados y patas de haya originales.' ),
		array( 'Cómoda de roble con tres cajones', 'comoda', 'Mobiliario', 'Vintage', 'buen-estado', 180, 0, '90 × 45 × 85 cm', 'Roble macizo', 'Natural', 'Cómoda de roble con tiradores de latón. Cajones que deslizan bien; pequeñas marcas en la tapa propias de la edad.' ),
		array( 'Mesa auxiliar redonda de nogal', 'mesa', 'Mobiliario', 'Vintage', 'como-nuevo', 68, 0, 'Ø 50 × 55 cm', 'Nogal y metal', 'Nogal', 'Mesa auxiliar con balda inferior. Perfecta junto al sofá o como mesita de noche.' ),
		array( 'Silla de comedor con asiento de enea', 'silla', 'Mobiliario', 'Vintage', 'buen-estado', 45, 0, '42 × 44 × 88 cm', 'Haya y enea', 'Natural', 'Silla clásica con asiento trenzado a mano. Estable y lista para usar.' ),
		array( 'Lámpara de sobremesa con pie de latón', 'lampara', 'Decoración', 'Vintage', 'muy-buen-estado', 39, 0, 'Alto 46 cm', 'Latón y lino', 'Crudo', 'Lámpara con pantalla de lino y pie de latón envejecido. Cableado renovado; funciona perfectamente.' ),
		array( 'Jarrón de cerámica esmaltada', 'jarron', 'Decoración', 'Hecho a mano', 'como-nuevo', 24, 0, 'Alto 28 cm', 'Cerámica', 'Terracota', 'Jarrón torneado a mano con esmalte mate. Sin desconchones.' ),
		array( 'Espejo redondo con marco dorado', 'espejo', 'Decoración', 'Vintage', 'muy-buen-estado', 85, 69, 'Ø 60 cm', 'Metal y vidrio', 'Dorado', 'Espejo de pared con marco fino en acabado latón. Luna en perfecto estado.' ),
		array( 'Lámina enmarcada «Atardecer»', 'lamina', 'Decoración', 'Hecho a mano', 'nuevo-con-etiqueta', 22, 0, '30 × 40 cm', 'Papel y madera', 'Multicolor', 'Lámina abstracta con marco de madera oscura y cristal. Lista para colgar.' ),
		array( 'Juego de dos tazas de gres', 'tazas', 'Decoración', 'Hecho a mano', 'como-nuevo', 18, 0, '300 ml', 'Gres', 'Verde y teja', 'Pareja de tazas de gres esmaltado con su plato. Aptas para lavavajillas.' ),
		array( 'Vestido midi de lino', 'vestido', 'Ropa', 'Massimo Dutti', 'muy-buen-estado', 35, 0, 'M', 'Lino 100 %', 'Teja', 'Vestido midi de tirantes anchos con cintura marcada. Puesto en un par de ocasiones.' ),
		array( 'Jersey de lana trenzado', 'jersey', 'Ropa', 'COS', 'como-nuevo', 42, 0, 'L', 'Lana merino', 'Crudo', 'Jersey de ochos, abrigado y suave. Sin bolitas ni enganchones.' ),
		array( 'Bolso de piel con asa corta', 'bolso', 'Bolsos y accesorios', 'Loewe', 'buen-estado', 320, 0, '26 × 24 × 10 cm', 'Piel', 'Marrón', 'Bolso de mano en piel con cierre metálico. Ligero desgaste en las esquinas, interior impecable.' ),
	);
}

function sv_demo_image( $file, $title ) {
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$source = get_template_directory() . '/assets/demo/' . $file . '.jpg';
	$tmp    = wp_tempnam( $file . '.jpg' );
	if ( ! $tmp || ! copy( $source, $tmp ) ) {
		return 0;
	}
	$id = media_handle_sideload( array( 'name' => 'ejemplo-' . $file . '.jpg', 'tmp_name' => $tmp ), 0, $title );
	if ( is_wp_error( $id ) ) {
		wp_delete_file( $tmp );
		return 0;
	}
	return (int) $id;
}

function sv_demo_term( $name, $taxonomy ) {
	$term = term_exists( $name, $taxonomy );
	if ( ! $term ) {
		$term = wp_insert_term( $name, $taxonomy );
	}
	return is_wp_error( $term ) ? 0 : (int) $term['term_id'];
}

function sv_import_demo() {
	if ( ! class_exists( 'WooCommerce' ) || get_option( 'sv_demo_imported' ) ) {
		return;
	}
	sv_install_defaults();

	$cat_thumbs = array();
	foreach ( sv_demo_products() as $i => $row ) {
		list( $name, $image, $cat, $brand, $estado, $price, $sale, $talla, $material, $color, $desc ) = $row;

		$image_id = sv_demo_image( $image, $name );
		$cat_id   = sv_demo_term( $cat, 'product_cat' );

		$product = new WC_Product_Simple();
		$product->set_name( $name );
		$product->set_status( 'publish' );
		$product->set_description( $desc );
		$product->set_regular_price( (string) $price );
		if ( $sale ) {
			$product->set_sale_price( (string) $sale );
		}
		$product->set_sku( sprintf( 'SV-%03d', $i + 1 ) );
		$product->set_manage_stock( true );
		$product->set_stock_quantity( 1 );
		$product->set_sold_individually( true );
		$product->set_category_ids( array( $cat_id ) );
		if ( $image_id ) {
			$product->set_image_id( $image_id );
		}
		$product->update_meta_data( '_sv_talla', $talla );
		$product->update_meta_data( '_sv_material', $material );
		$product->update_meta_data( '_sv_color', $color );
		$product->update_meta_data( '_sv_unique_init', '1' );
		$product->update_meta_data( '_sv_demo', '1' );
		$id = $product->save();

		wp_set_object_terms( $id, $estado, 'sv_estado' );
		if ( taxonomy_exists( 'product_brand' ) ) {
			wp_set_object_terms( $id, array( sv_demo_term( $brand, 'product_brand' ) ), 'product_brand' );
		}
		// Escalona las fechas para que «Recién llegados» tenga un orden estable.
		wp_update_post( array(
			'ID'            => $id,
			'post_date'     => gmdate( 'Y-m-d H:i:s', time() - $i * HOUR_IN_SECONDS ),
			'post_date_gmt' => gmdate( 'Y-m-d H:i:s', time() - $i * HOUR_IN_SECONDS ),
		) );

		if ( $image_id && ! isset( $cat_thumbs[ $cat_id ] ) ) {
			$cat_thumbs[ $cat_id ] = $image_id;
			if ( ! get_term_meta( $cat_id, 'thumbnail_id', true ) ) {
				update_term_meta( $cat_id, 'thumbnail_id', $image_id );
			}
		}
	}

	update_option( 'sv_demo_imported', 1 );
}
