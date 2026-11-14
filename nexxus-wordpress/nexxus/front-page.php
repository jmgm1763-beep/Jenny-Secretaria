<?php
/**
 * Portada: página única con todas las secciones del dossier corporativo.
 *
 * @package Nexxus
 */

get_header();

$nexxus_phone = nexxus_opt( 'contact_phone' );
$nexxus_email = nexxus_opt( 'contact_email' );
$nexxus_owner = nexxus_owner();
?>

<?php
$nexxus_slides = nexxus_hero_slides();
$nexxus_video  = nexxus_hero_video();
$nexxus_poster = absint( get_theme_mod( 'nexxus_img_hero', 0 ) ) ? wp_get_attachment_image_url( absint( get_theme_mod( 'nexxus_img_hero', 0 ) ), 'nexxus-hero' ) : '';
?>
<section class="hero<?php echo ( $nexxus_slides || $nexxus_video ) ? ' hero--photo' : ''; ?>" aria-labelledby="hero-t">
	<?php if ( $nexxus_slides || $nexxus_video ) : ?>
		<div class="hero__bg" aria-hidden="true">
			<?php foreach ( $nexxus_slides as $nexxus_i => $nexxus_slide ) : ?>
				<figure class="hero__slide<?php echo 0 === $nexxus_i ? ' is-active' : ''; ?>"><?php echo $nexxus_slide; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></figure>
			<?php endforeach; ?>
			<?php if ( $nexxus_video ) : ?>
				<video class="hero__video" autoplay muted loop playsinline preload="metadata"<?php echo $nexxus_poster ? ' poster="' . esc_url( $nexxus_poster ) . '"' : ''; ?>>
					<source src="<?php echo esc_url( $nexxus_video['url'] ); ?>" type="<?php echo esc_attr( $nexxus_video['type'] ); ?>">
				</video>
			<?php endif; ?>
		</div>
		<?php if ( $nexxus_video ) : ?>
			<button class="hero__pause" type="button" aria-pressed="false">Pausar vídeo</button>
		<?php endif; ?>
	<?php endif; ?>
	<div class="wrap hero__in">
		<div class="hero__text">
			<p class="eyebrow">Real Estate &amp; construcción industrializada</p>
			<h1 id="hero-t"><?php echo esc_html( nexxus_opt( 'hero_title' ) ); ?></h1>
			<p class="hero__lead"><?php echo esc_html( nexxus_opt( 'hero_text' ) ); ?></p>
			<div class="hero__actions">
				<a class="btn" href="#contacto">Hablemos de su proyecto</a>
				<a class="btn btn--ghost" href="#modelo">Cómo trabajamos</a>
			</div>
		</div>
		<?php if ( ! $nexxus_slides && ! $nexxus_video ) : ?>
			<div class="hero__art">
				<?php echo nexxus_art_alzado(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		<?php endif; ?>
	</div>

</section>

<section class="stats" aria-label="NEXXUS Advisor en cifras">
	<div class="wrap">
		<dl class="stats__list">
			<?php foreach ( nexxus_stats() as $nexxus_st ) : ?>
				<div class="stat reveal">
					<dt><span class="count" data-count="<?php echo esc_attr( $nexxus_st['n'] ); ?>" data-prefix="<?php echo esc_attr( $nexxus_st['pre'] ); ?>" data-suffix="<?php echo esc_attr( $nexxus_st['suf'] ); ?>"><?php echo esc_html( $nexxus_st['text'] ); ?></span></dt>
					<dd><?php echo esc_html( $nexxus_st['label'] ); ?></dd>
				</div>
			<?php endforeach; ?>
		</dl>
	</div>
</section>

<section class="section" id="quienes-somos" aria-labelledby="quienes-t">
	<div class="wrap">
		<div class="split">
			<div class="split__head reveal">
				<p class="eyebrow">Quiénes somos</p>
				<h2 id="quienes-t">El nodo donde el activo se conecta con el sistema que lo construye.</h2>
			</div>
			<div class="split__body reveal">
				<p class="lead">NEXXUS Advisor es una marca de consultoría especializada en activos terciarios e industriales y en construcción industrializada. Coordina a cinco empresas líderes en su especialidad para que promotores, inversores y administraciones trabajen con un único responsable durante todo el ciclo del proyecto.</p>
				<p>Cada partner mantiene su empresa, su equipo y su experiencia. NEXXUS Advisor aporta la dirección estratégica, la captación de oportunidades y la coordinación entre todos ellos. El cliente gana certeza de plazo, de coste y de resultado. Los partners ganan acceso a proyectos que por separado no alcanzarían.</p>
			</div>
		</div>

		<?php echo nexxus_photo( 'img_quienes', 'nexxus-wide', 'band reveal', 'NEXXUS Advisor' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

		<ul class="pillars">
			<?php $nexxus_pillar_icons = array( 'activo', 'capital', 'sistema' ); ?>
			<?php foreach ( nexxus_pillars() as $nexxus_i => $nexxus_p ) : ?>
				<li class="pillar reveal">
					<?php echo nexxus_icon( $nexxus_pillar_icons[ $nexxus_i ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<p class="pillar__name"><?php echo esc_html( $nexxus_p[0] ); ?></p>
					<h3><?php echo esc_html( $nexxus_p[1] ); ?></h3>
					<p><?php echo esc_html( $nexxus_p[2] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<section class="section section--tint" id="modelo" aria-labelledby="modelo-t">
	<div class="wrap">
		<div class="section__head reveal">
			<p class="eyebrow">El modelo</p>
			<h2 id="modelo-t">Todo el ciclo del activo. Un solo responsable.</h2>
			<p class="lead">El proyecto avanza en cinco fases. En cada una interviene el partner especialista, siempre bajo la coordinación de NEXXUS Advisor.</p>
		</div>

		<ol class="phases">
			<?php foreach ( nexxus_phases() as $nexxus_i => $nexxus_f ) : ?>
				<li class="phase reveal">
					<span class="phase__num" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $nexxus_i + 1 ) ); ?></span>
					<h3><?php echo esc_html( $nexxus_f[0] ); ?></h3>
					<p><?php echo esc_html( $nexxus_f[1] ); ?></p>
					<ul class="tags" aria-label="Interviene">
						<?php foreach ( $nexxus_f[2] as $nexxus_tag ) : ?>
							<li><?php echo esc_html( $nexxus_tag ); ?></li>
						<?php endforeach; ?>
					</ul>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<section class="section section--dark" id="lineas" aria-labelledby="lineas-t">
	<div class="wrap">
		<div class="section__head reveal">
			<p class="eyebrow">Líneas de negocio</p>
			<h2 id="lineas-t">Tres mercados, una marca.</h2>
		</div>

		<div class="lines">
			<?php foreach ( nexxus_lines() as $nexxus_l ) : ?>
				<article class="line reveal<?php echo 'A' === $nexxus_l['letter'] ? ' line--main' : ''; ?>">
					<?php $nexxus_line_img = nexxus_img( 'img_linea_' . strtolower( $nexxus_l['letter'] ) ); ?>
					<?php if ( $nexxus_line_img ) : ?>
						<?php echo nexxus_photo( 'img_linea_' . strtolower( $nexxus_l['letter'] ), 'nexxus-card', 'line__photo', $nexxus_l['title'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php else : ?>
						<div class="line__art"><?php echo nexxus_art_line( $nexxus_l['art'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
					<?php endif; ?>
					<p class="line__tag"><?php echo esc_html( $nexxus_l['tag'] ); ?></p>
					<h3><span class="line__letter">Línea <?php echo esc_html( $nexxus_l['letter'] ); ?></span><?php echo esc_html( $nexxus_l['title'] ); ?></h3>
					<ul class="checks">
						<?php foreach ( $nexxus_l['items'] as $nexxus_item ) : ?>
							<li><?php echo esc_html( $nexxus_item ); ?></li>
						<?php endforeach; ?>
					</ul>
					<?php
					$nexxus_dossier = nexxus_dossier_url( $nexxus_l['letter'] );
					$nexxus_lp      = nexxus_line_partners();
					$nexxus_links   = array();
					foreach ( nexxus_partners() as $nexxus_pt ) {
						if ( in_array( $nexxus_pt['id'], $nexxus_lp[ $nexxus_l['letter'] ], true ) && nexxus_partner_url( $nexxus_pt['id'] ) ) {
							$nexxus_links[ $nexxus_pt['name'] ] = nexxus_partner_url( $nexxus_pt['id'] );
						}
					}
					?>
					<?php if ( $nexxus_dossier || $nexxus_links ) : ?>
						<div class="line__actions">
							<?php if ( $nexxus_dossier ) : ?>
								<a class="btn btn--sm line__download" href="<?php echo esc_url( $nexxus_dossier ); ?>" download>Descargar dossier <span>PDF</span></a>
							<?php endif; ?>
							<?php if ( $nexxus_links ) : ?>
								<p class="line__webs">
									<span>Web del especialista</span>
									<?php foreach ( $nexxus_links as $nexxus_name => $nexxus_href ) : ?>
										<a href="<?php echo esc_url( $nexxus_href ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $nexxus_name ); ?><span class="screen-reader-text"> (se abre en una pestaña nueva)</span></a>
									<?php endforeach; ?>
								</p>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php $nexxus_projects = nexxus_get_projects(); ?>
<?php if ( $nexxus_projects ) : ?>
<?php
$nexxus_counts = array(
	'ejecutado'  => 0,
	'en-proceso' => 0,
);
foreach ( $nexxus_projects as $nexxus_pr ) {
	$nexxus_counts[ nexxus_project_status( $nexxus_pr->ID ) ]++;
}
$nexxus_status_labels = array(
	'ejecutado'  => 'Ejecutado',
	'en-proceso' => 'En proceso',
);
?>
<section class="section section--tint" id="proyectos" aria-labelledby="proyectos-t">
	<div class="wrap">
		<div class="section__head section__head--row reveal">
			<div>
				<p class="eyebrow">Proyectos</p>
				<h2 id="proyectos-t">Ejecutados y en proceso.</h2>
			</div>
			<?php
			$nexxus_line_counts = array();
			foreach ( $nexxus_projects as $nexxus_pr ) {
				$nexxus_ln = nexxus_project_line( $nexxus_pr->ID );
				if ( $nexxus_ln ) {
					$nexxus_line_counts[ $nexxus_ln ] = isset( $nexxus_line_counts[ $nexxus_ln ] ) ? $nexxus_line_counts[ $nexxus_ln ] + 1 : 1;
				}
			}
			ksort( $nexxus_line_counts );
			$nexxus_show_status = $nexxus_counts['ejecutado'] && $nexxus_counts['en-proceso'];
			$nexxus_show_lines  = count( $nexxus_line_counts ) > 1;
			?>
			<?php if ( $nexxus_show_status || $nexxus_show_lines ) : ?>
				<div class="pfilters">
					<?php if ( $nexxus_show_status ) : ?>
						<div class="pfilter" role="group" aria-label="Filtrar proyectos por estado">
							<button type="button" class="pfilter__btn is-on" data-group="status" data-filter="todos" aria-pressed="true">Todos <span><?php echo esc_html( count( $nexxus_projects ) ); ?></span></button>
							<button type="button" class="pfilter__btn" data-group="status" data-filter="ejecutado" aria-pressed="false">Ejecutados <span><?php echo esc_html( $nexxus_counts['ejecutado'] ); ?></span></button>
							<button type="button" class="pfilter__btn" data-group="status" data-filter="en-proceso" aria-pressed="false">En proceso <span><?php echo esc_html( $nexxus_counts['en-proceso'] ); ?></span></button>
						</div>
					<?php endif; ?>
					<?php if ( $nexxus_show_lines ) : ?>
						<div class="pfilter pfilter--line" role="group" aria-label="Filtrar proyectos por línea de negocio">
							<button type="button" class="pfilter__btn is-on" data-group="line" data-filter="todos" aria-pressed="true">Todas las líneas</button>
							<?php foreach ( $nexxus_line_counts as $nexxus_ln => $nexxus_n ) : ?>
								<button type="button" class="pfilter__btn" data-group="line" data-filter="<?php echo esc_attr( $nexxus_ln ); ?>" aria-pressed="false">Línea <?php echo esc_html( strtoupper( $nexxus_ln ) ); ?> <span><?php echo esc_html( $nexxus_n ); ?></span></button>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>

		<div class="projects">
			<?php foreach ( $nexxus_projects as $nexxus_pr ) : ?>
				<?php
				$nexxus_st      = nexxus_project_status( $nexxus_pr->ID );
				$nexxus_caption = get_the_title( $nexxus_pr ) . ( has_excerpt( $nexxus_pr ) ? ' · ' . get_the_excerpt( $nexxus_pr ) : '' );
				?>
				<article class="project reveal" data-status="<?php echo esc_attr( $nexxus_st ); ?>" data-line="<?php echo esc_attr( nexxus_project_line( $nexxus_pr->ID ) ); ?>">
					<?php if ( has_post_thumbnail( $nexxus_pr ) ) : ?>
						<figure class="photo project__img">
							<a class="zoom" href="<?php echo esc_url( get_the_post_thumbnail_url( $nexxus_pr, 'full' ) ); ?>" data-caption="<?php echo esc_attr( $nexxus_caption ); ?>" aria-label="<?php echo esc_attr( 'Ampliar imagen: ' . get_the_title( $nexxus_pr ) ); ?>"><?php echo get_the_post_thumbnail( $nexxus_pr, 'nexxus-card', array( 'loading' => 'lazy' ) ); ?></a>
							<span class="project__status project__status--<?php echo esc_attr( $nexxus_st ); ?>"><?php echo esc_html( $nexxus_status_labels[ $nexxus_st ] ); ?></span>
						</figure>
					<?php else : ?>
						<div class="project__img project__img--empty">
							<?php echo nexxus_isotipo(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<span class="project__status project__status--<?php echo esc_attr( $nexxus_st ); ?>"><?php echo esc_html( $nexxus_status_labels[ $nexxus_st ] ); ?></span>
						</div>
					<?php endif; ?>
					<?php if ( nexxus_project_partner( $nexxus_pr->ID ) ) : ?>
						<p class="project__partner"><?php echo esc_html( nexxus_project_partner( $nexxus_pr->ID ) ); ?></p>
					<?php endif; ?>
					<?php if ( nexxus_project_has_detail( $nexxus_pr ) ) : ?>
						<h3><a class="project__link" href="<?php echo esc_url( get_permalink( $nexxus_pr ) ); ?>"><?php echo esc_html( get_the_title( $nexxus_pr ) ); ?></a></h3>
					<?php else : ?>
						<h3><?php echo esc_html( get_the_title( $nexxus_pr ) ); ?></h3>
					<?php endif; ?>
					<?php if ( has_excerpt( $nexxus_pr ) ) : ?>
						<p><?php echo esc_html( get_the_excerpt( $nexxus_pr ) ); ?></p>
					<?php endif; ?>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<section class="section" id="ecosistema" aria-labelledby="eco-t">
	<div class="wrap">
		<div class="split split--center">
			<div class="split__head reveal">
				<p class="eyebrow">Ecosistema</p>
				<h2 id="eco-t">Cinco especialistas. Una dirección.</h2>
				<p class="lead">NEXXUS Advisor ocupa el centro: capta la oportunidad, define el equipo para cada proyecto y responde ante el cliente. Cada partner trabaja en lo que mejor sabe hacer.</p>
			</div>
			<div class="split__body hub reveal">
				<?php echo nexxus_art_hub(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		</div>

		<div class="ptabs" role="tablist" aria-label="Partners del ecosistema">
			<?php foreach ( nexxus_partners() as $nexxus_pt ) : ?>
				<button class="ptab" type="button" role="tab" id="tab-<?php echo esc_attr( $nexxus_pt['id'] ); ?>" aria-controls="<?php echo esc_attr( $nexxus_pt['id'] ); ?>" aria-selected="false">
					<span><?php echo esc_html( $nexxus_pt['kind'] ); ?></span>
					<?php echo nexxus_partner_mark( $nexxus_pt ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</button>
			<?php endforeach; ?>
		</div>

		<div class="partners">
			<?php foreach ( nexxus_partners() as $nexxus_pt ) : ?>
				<article class="partner" id="<?php echo esc_attr( $nexxus_pt['id'] ); ?>" role="tabpanel" aria-labelledby="tab-<?php echo esc_attr( $nexxus_pt['id'] ); ?>">
					<header class="partner__head">
						<p class="partner__kind"><?php echo esc_html( $nexxus_pt['kind'] ); ?></p>
						<h3><?php echo nexxus_partner_mark( $nexxus_pt, 'plogo plogo--lg' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h3>
						<p class="partner__meta"><?php echo esc_html( $nexxus_pt['meta'] ); ?> <span class="partner__line"><?php echo esc_html( $nexxus_pt['lines'] ); ?></span></p>
					</header>

					<div class="partner__body">
						<p><?php echo esc_html( $nexxus_pt['intro'] ); ?></p>
						<div class="partner__role">
							<p class="partner__role-label">Papel en NEXXUS Advisor</p>
							<p><?php echo esc_html( $nexxus_pt['role'] ); ?></p>
						</div>
						<details>
							<summary>Servicios</summary>
							<dl class="services">
								<?php foreach ( $nexxus_pt['services'] as $nexxus_s ) : ?>
									<div>
										<dt><?php echo esc_html( $nexxus_s[0] ); ?></dt>
										<dd><?php echo esc_html( $nexxus_s[1] ); ?></dd>
									</div>
								<?php endforeach; ?>
							</dl>
						</details>
					</div>

					<dl class="figures">
						<?php foreach ( $nexxus_pt['figures'] as $nexxus_fig ) : ?>
							<div>
								<dt><?php echo esc_html( $nexxus_fig[0] ); ?></dt>
								<dd><?php echo esc_html( $nexxus_fig[1] ); ?></dd>
							</div>
						<?php endforeach; ?>
					</dl>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section section--tint" id="ventajas" aria-labelledby="ventajas-t">
	<div class="wrap">
		<div class="section__head reveal">
			<p class="eyebrow">Por qué NEXXUS Advisor</p>
			<h2 id="ventajas-t">Lo que gana el cliente.</h2>
		</div>

		<?php $nexxus_adv_icons = array( 'interlocutor', 'certificados', 'financiacion', 'plazo', 'nacional', 'salida' ); ?>
		<ul class="advantages">
			<?php foreach ( nexxus_advantages() as $nexxus_i => $nexxus_a ) : ?>
				<li class="advantage reveal">
					<div class="advantage__head">
						<span class="advantage__num" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $nexxus_i + 1 ) ); ?></span>
						<?php echo nexxus_icon( $nexxus_adv_icons[ $nexxus_i ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
					<h3><?php echo esc_html( $nexxus_a[0] ); ?></h3>
					<p><?php echo esc_html( $nexxus_a[1] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ul>

		<div class="audiences reveal">
			<h3>A quién nos dirigimos</h3>
			<ul class="chips">
				<?php foreach ( nexxus_audiences() as $nexxus_aud ) : ?>
					<li><?php echo esc_html( $nexxus_aud ); ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</section>

<?php if ( get_theme_mod( 'nexxus_club_show', true ) ) : ?>
<section class="section section--dark club" id="club-deal" aria-labelledby="club-t">
	<div class="wrap">
		<div class="club__in">
			<div class="club__info">
				<p class="eyebrow">Club Deal Inmobiliario</p>
				<h2 id="club-t"><?php echo esc_html( nexxus_opt( 'club_title' ) ); ?></h2>
				<p class="lead"><?php echo esc_html( nexxus_opt( 'club_text' ) ); ?></p>

				<ol class="club__steps">
					<?php foreach ( nexxus_club_steps() as $nexxus_i => $nexxus_cs ) : ?>
						<li class="reveal">
							<span class="club__num" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $nexxus_i + 1 ) ); ?></span>
							<div>
								<h3><?php echo esc_html( $nexxus_cs[0] ); ?></h3>
								<p><?php echo esc_html( $nexxus_cs[1] ); ?></p>
							</div>
						</li>
					<?php endforeach; ?>
				</ol>
			</div>

			<form class="contact__form club__form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="nexxus_club">
				<p class="club__form-title">Solicitar información</p>
				<?php nexxus_form_notice( 'club' ); ?>

				<div class="field">
					<label for="cd-nombre">Nombre y apellidos <span aria-hidden="true">*</span></label>
					<input id="cd-nombre" name="nombre" type="text" autocomplete="name" required>
				</div>
				<div class="field">
					<label for="cd-empresa">Empresa u organización</label>
					<input id="cd-empresa" name="empresa" type="text" autocomplete="organization">
				</div>
				<div class="field field--half">
					<label for="cd-email">Correo electrónico <span aria-hidden="true">*</span></label>
					<input id="cd-email" name="email" type="email" autocomplete="email" required>
				</div>
				<div class="field field--half">
					<label for="cd-telefono">Teléfono</label>
					<input id="cd-telefono" name="telefono" type="tel" autocomplete="tel">
				</div>
				<div class="field">
					<label for="cd-perfil">Perfil</label>
					<select id="cd-perfil" name="perfil">
						<?php foreach ( nexxus_club_profiles() as $nexxus_k => $nexxus_v ) : ?>
							<option value="<?php echo esc_attr( $nexxus_k ); ?>"><?php echo esc_html( $nexxus_v ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<fieldset class="field field--set">
					<legend>Operaciones que le interesan</legend>
					<?php foreach ( nexxus_club_interests() as $nexxus_k => $nexxus_v ) : ?>
						<label class="check"><input type="checkbox" name="interes[]" value="<?php echo esc_attr( $nexxus_k ); ?>"> <?php echo esc_html( $nexxus_v ); ?></label>
					<?php endforeach; ?>
				</fieldset>
				<div class="field">
					<label for="cd-mensaje">Comentarios</label>
					<textarea id="cd-mensaje" name="mensaje" rows="3"></textarea>
				</div>
				<div class="field field--trap" aria-hidden="true">
					<label for="cd-web">No rellene este campo</label>
					<input id="cd-web" name="web" type="text" tabindex="-1" autocomplete="off">
				</div>
				<div class="field field--check">
					<input id="cd-privacidad" name="privacidad" type="checkbox" value="1" required>
					<label for="cd-privacidad">
						Acepto que NEXXUS Advisor trate mis datos para atender esta solicitud.
						<?php if ( nexxus_privacy_url() ) : ?>
							<a href="<?php echo esc_url( nexxus_privacy_url() ); ?>">Política de privacidad</a>.
						<?php endif; ?>
					</label>
				</div>
				<button class="btn" type="submit">Solicitar información</button>
			</form>
		</div>

		<p class="club__legal"><?php echo esc_html( nexxus_opt( 'club_legal' ) ); ?></p>
	</div>
</section>
<?php endif; ?>

<section class="section" id="como-trabajamos" aria-labelledby="reglas-t">
	<div class="wrap">
		<div class="split">
			<div class="split__head reveal">
				<p class="eyebrow">Cómo trabajamos</p>
				<h2 id="reglas-t">Reglas claras entre partners.</h2>
			</div>
			<div class="split__body reveal">
				<p class="lead"><?php echo esc_html( nexxus_brand_line() ); ?> Cada partner se vincula mediante un acuerdo marco propio, sin participación en el capital y con las mismas reglas para todos.</p>
			</div>
		</div>

		<ul class="rules">
			<?php foreach ( nexxus_rules() as $nexxus_r ) : ?>
				<li class="rule reveal">
					<?php echo nexxus_icon( $nexxus_r[1] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<h3><?php echo esc_html( $nexxus_r[0] ); ?></h3>
				</li>
			<?php endforeach; ?>
		</ul>

		<details class="more reveal">
			<summary>Ver el vínculo de cada partner con NEXXUS Advisor</summary>
		<div class="table-wrap">
			<table class="agreements">
				<caption class="screen-reader-text">Vínculo de cada partner con NEXXUS Advisor</caption>
				<thead>
					<tr>
						<th scope="col">Partner</th>
						<th scope="col">Vínculo con NEXXUS Advisor</th>
						<th scope="col">Aporta</th>
						<th scope="col">Recibe</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( nexxus_agreements() as $nexxus_ag ) : ?>
						<tr>
							<th scope="row"><?php echo esc_html( $nexxus_ag[0] ); ?></th>
							<td data-label="Vínculo"><?php echo esc_html( $nexxus_ag[1] ); ?></td>
							<td data-label="Aporta"><?php echo esc_html( $nexxus_ag[2] ); ?></td>
							<td data-label="Recibe"><?php echo esc_html( $nexxus_ag[3] ); ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		</details>
	</div>
</section>

<?php $nexxus_contact_bg = nexxus_img( 'img_contact', 'nexxus-wide' ); ?>
<section class="section section--dark contact<?php echo $nexxus_contact_bg ? ' contact--photo' : ''; ?>" id="contacto" aria-labelledby="contacto-t">
	<?php if ( $nexxus_contact_bg ) : ?>
		<figure class="contact__bg" aria-hidden="true"><?php echo $nexxus_contact_bg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></figure>
	<?php endif; ?>
	<div class="wrap contact__in">
		<div class="contact__info">
			<p class="eyebrow">Contacto</p>
			<h2 id="contacto-t">Hablemos de su próximo activo.</h2>
			<p class="lead">Un suelo por desarrollar, una nave logística o un edificio de viviendas.</p>

			<div class="contact__card">
				<p class="contact__label">Dirección</p>
				<p class="contact__name"><?php echo esc_html( nexxus_opt( 'contact_name' ) ); ?></p>
				<p class="contact__role"><?php echo esc_html( nexxus_opt( 'contact_role' ) ); ?></p>
				<p class="contact__links">
					<a class="contact__phone" href="<?php echo esc_url( nexxus_tel_href( $nexxus_phone ) ); ?>"><?php echo esc_html( $nexxus_phone ); ?></a>
					<a href="<?php echo esc_attr( 'mailto:' . antispambot( $nexxus_email ) ); ?>"><?php echo esc_html( antispambot( $nexxus_email ) ); ?></a>
				</p>
			</div>
		</div>

		<form class="contact__form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="nexxus_contact">
			<?php nexxus_form_notice(); ?>

			<div class="field">
				<label for="cf-nombre">Nombre y apellidos <span aria-hidden="true">*</span></label>
				<input id="cf-nombre" name="nombre" type="text" autocomplete="name" required>
			</div>
			<div class="field">
				<label for="cf-empresa">Empresa u organismo</label>
				<input id="cf-empresa" name="empresa" type="text" autocomplete="organization">
			</div>
			<div class="field field--half">
				<label for="cf-email">Correo electrónico <span aria-hidden="true">*</span></label>
				<input id="cf-email" name="email" type="email" autocomplete="email" required>
			</div>
			<div class="field field--half">
				<label for="cf-telefono">Teléfono</label>
				<input id="cf-telefono" name="telefono" type="tel" autocomplete="tel">
			</div>
			<div class="field">
				<label for="cf-tipo">Tipo de proyecto</label>
				<select id="cf-tipo" name="tipo">
					<?php foreach ( nexxus_project_types() as $nexxus_k => $nexxus_v ) : ?>
						<option value="<?php echo esc_attr( $nexxus_k ); ?>"><?php echo esc_html( $nexxus_v ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="field">
				<label for="cf-mensaje">Cuéntenos su proyecto <span aria-hidden="true">*</span></label>
				<textarea id="cf-mensaje" name="mensaje" rows="5" required></textarea>
			</div>
			<div class="field field--trap" aria-hidden="true">
				<label for="cf-web">No rellene este campo</label>
				<input id="cf-web" name="web" type="text" tabindex="-1" autocomplete="off">
			</div>
			<div class="field field--check">
				<input id="cf-privacidad" name="privacidad" type="checkbox" value="1" required>
				<label for="cf-privacidad">
					Acepto que NEXXUS Advisor trate mis datos para responder a esta consulta.
					<?php if ( nexxus_privacy_url() ) : ?>
						<a href="<?php echo esc_url( nexxus_privacy_url() ); ?>">Política de privacidad</a>.
					<?php endif; ?>
				</label>
			</div>
			<p class="form-legal">Responsable: NEXXUS Advisor. Finalidad: atender su consulta. Puede ejercer sus derechos de acceso, rectificación y supresión escribiendo a <?php echo esc_html( antispambot( $nexxus_email ) ); ?>.</p>
			<button class="btn" type="submit">Enviar consulta</button>
		</form>
	</div>
</section>

<?php
get_footer();
