<?php
defined( 'ABSPATH' ) || exit;
get_header();
?>
<main id="contenido" class="sv-main sv-container sv-prose">
	<?php if ( is_home() || is_archive() || is_search() ) : ?>
		<header class="sv-pagehead">
			<h1>
				<?php
				if ( is_search() ) {
					/* translators: %s: término buscado. */
					printf( esc_html__( 'Resultados para «%s»', 'segunda-vida' ), esc_html( get_search_query() ) );
				} elseif ( is_archive() ) {
					the_archive_title();
				} else {
					echo esc_html( get_the_title( (int) get_option( 'page_for_posts' ) ) ?: __( 'Blog', 'segunda-vida' ) );
				}
				?>
			</h1>
		</header>
	<?php endif; ?>

	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<article <?php post_class( 'sv-entry' ); ?>>
				<?php if ( is_singular() ) : ?>
					<header class="sv-pagehead"><h1><?php the_title(); ?></h1></header>
					<div class="sv-entry__content"><?php the_content(); ?></div>
					<?php wp_link_pages(); ?>
				<?php else : ?>
					<h2 class="sv-entry__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="sv-entry__content"><?php the_excerpt(); ?></div>
				<?php endif; ?>
			</article>
		<?php endwhile; ?>
		<?php the_posts_pagination(); ?>
		<?php if ( is_singular() && ( comments_open() || get_comments_number() ) ) { comments_template(); } ?>
	<?php else : ?>
		<p><?php esc_html_e( 'No hemos encontrado nada con esa búsqueda.', 'segunda-vida' ); ?></p>
	<?php endif; ?>
</main>
<?php
get_footer();
