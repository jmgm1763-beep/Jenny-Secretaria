<?php
/**
 * Plantilla general: páginas interiores, entradas y listados.
 *
 * @package Nexxus
 */

get_header();
?>

<div class="page-head">
	<div class="wrap">
		<?php if ( is_singular() ) : ?>
			<h1><?php single_post_title(); ?></h1>
		<?php elseif ( is_search() ) : ?>
			<h1>Resultados de la búsqueda</h1>
		<?php elseif ( is_archive() ) : ?>
			<h1><?php the_archive_title(); ?></h1>
		<?php else : ?>
			<h1>Actualidad</h1>
		<?php endif; ?>
	</div>
</div>

<div class="wrap page-body">
	<?php if ( have_posts() ) : ?>
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article <?php post_class( 'entry' ); ?>>
				<?php if ( ! is_singular() ) : ?>
					<h2 class="entry__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<p class="entry__date"><?php echo esc_html( get_the_date() ); ?></p>
					<div class="entry__content"><?php the_excerpt(); ?></div>
				<?php else : ?>
					<div class="entry__content">
						<?php
						the_content();
						wp_link_pages();
						?>
					</div>
				<?php endif; ?>
			</article>
		<?php endwhile; ?>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<p>No hay contenido disponible.</p>
	<?php endif; ?>

	<?php
	if ( is_singular() && ( comments_open() || get_comments_number() ) ) {
		comments_template();
	}
	?>
</div>

<?php
get_footer();
