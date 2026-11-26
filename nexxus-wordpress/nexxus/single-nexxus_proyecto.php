<?php
/**
 * Ficha de un proyecto.
 *
 * @package Nexxus
 */

get_header();

while ( have_posts() ) :
	the_post();

	$nexxus_id      = get_the_ID();
	$nexxus_st      = nexxus_project_status( $nexxus_id );
	$nexxus_ln      = nexxus_project_line( $nexxus_id );
	$nexxus_partner = nexxus_project_partner( $nexxus_id );
	$nexxus_facts   = nexxus_project_facts( $nexxus_id );
	$nexxus_labels  = array(
		'ejecutado'  => 'Ejecutado',
		'en-proceso' => 'En proceso',
	);
	?>

	<article <?php post_class( 'pficha' ); ?>>
		<header class="phero<?php echo has_post_thumbnail() ? ' phero--photo' : ''; ?>">
			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="phero__bg">
					<a class="zoom" href="<?php echo esc_url( get_the_post_thumbnail_url( $nexxus_id, 'full' ) ); ?>" data-caption="<?php echo esc_attr( get_the_title() ); ?>" aria-label="Ampliar imagen principal">
						<?php the_post_thumbnail( 'nexxus-hero', array( 'loading' => 'eager', 'fetchpriority' => 'high', 'sizes' => '100vw' ) ); ?>
					</a>
				</figure>
			<?php endif; ?>
			<div class="wrap phero__in">
				<p class="phero__back"><a href="<?php echo esc_url( home_url( '/#proyectos' ) ); ?>">Todos los proyectos</a></p>
				<p class="phero__tags">
					<span class="project__status project__status--<?php echo esc_attr( $nexxus_st ); ?>"><?php echo esc_html( $nexxus_labels[ $nexxus_st ] ); ?></span>
					<?php if ( $nexxus_ln ) : ?>
						<span class="phero__line">Línea <?php echo esc_html( strtoupper( $nexxus_ln ) ); ?></span>
					<?php endif; ?>
				</p>
				<h1><?php the_title(); ?></h1>
				<?php if ( has_excerpt() ) : ?>
					<p class="phero__lead"><?php echo esc_html( get_the_excerpt() ); ?></p>
				<?php endif; ?>
			</div>
		</header>

		<div class="wrap pficha__grid">
			<aside class="pfacts" aria-label="Datos del proyecto">
				<dl>
					<?php if ( $nexxus_partner ) : ?>
						<div>
							<dt>Especialista</dt>
							<dd><?php echo esc_html( $nexxus_partner ); ?></dd>
						</div>
					<?php endif; ?>
					<?php foreach ( $nexxus_facts as $nexxus_label => $nexxus_value ) : ?>
						<div>
							<dt><?php echo esc_html( $nexxus_label ); ?></dt>
							<dd><?php echo esc_html( $nexxus_value ); ?></dd>
						</div>
					<?php endforeach; ?>
				</dl>
				<a class="btn" href="<?php echo esc_url( home_url( '/#contacto' ) ); ?>">Consultar un proyecto similar</a>
			</aside>

			<div class="entry__content project-body">
				<?php the_content(); ?>
			</div>
		</div>
	</article>

	<?php
	$nexxus_others = array_filter(
		nexxus_get_projects( 4 ),
		function ( $p ) use ( $nexxus_id ) {
			return $p->ID !== $nexxus_id;
		}
	);
	$nexxus_others = array_slice( $nexxus_others, 0, 3 );
	?>
	<?php if ( $nexxus_others ) : ?>
		<section class="section section--tint" aria-labelledby="otros-t">
			<div class="wrap">
				<div class="section__head">
					<p class="eyebrow">Proyectos</p>
					<h2 id="otros-t">Otros proyectos.</h2>
				</div>
				<div class="projects">
					<?php foreach ( $nexxus_others as $nexxus_pr ) : ?>
						<?php $nexxus_ost = nexxus_project_status( $nexxus_pr->ID ); ?>
						<article class="project">
							<?php if ( has_post_thumbnail( $nexxus_pr ) ) : ?>
								<figure class="photo project__img">
									<a class="zoom" href="<?php echo esc_url( get_the_post_thumbnail_url( $nexxus_pr, 'full' ) ); ?>" data-caption="<?php echo esc_attr( get_the_title( $nexxus_pr ) ); ?>" aria-label="<?php echo esc_attr( 'Ampliar imagen: ' . get_the_title( $nexxus_pr ) ); ?>"><?php echo get_the_post_thumbnail( $nexxus_pr, 'nexxus-card', array( 'loading' => 'lazy' ) ); ?></a>
									<span class="project__status project__status--<?php echo esc_attr( $nexxus_ost ); ?>"><?php echo esc_html( $nexxus_labels[ $nexxus_ost ] ); ?></span>
								</figure>
							<?php else : ?>
								<div class="project__img project__img--empty"><?php echo nexxus_isotipo(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
							<?php endif; ?>
							<?php if ( nexxus_project_partner( $nexxus_pr->ID ) ) : ?>
								<p class="project__partner"><?php echo esc_html( nexxus_project_partner( $nexxus_pr->ID ) ); ?></p>
							<?php endif; ?>
							<?php if ( nexxus_project_has_detail( $nexxus_pr ) ) : ?>
								<h3><a class="project__link" href="<?php echo esc_url( get_permalink( $nexxus_pr ) ); ?>"><?php echo esc_html( get_the_title( $nexxus_pr ) ); ?></a></h3>
							<?php else : ?>
								<h3><?php echo esc_html( get_the_title( $nexxus_pr ) ); ?></h3>
							<?php endif; ?>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php
endwhile;

get_footer();
