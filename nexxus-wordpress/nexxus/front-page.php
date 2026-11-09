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

<section class="hero" aria-labelledby="hero-t">
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
		<div class="hero__art">
			<?php echo nexxus_art_alzado(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
	</div>

	<div class="wrap">
		<ul class="hero__partners" aria-label="Empresas que coordina NEXXUS">
			<li><span>Real Estate</span><strong>Trading Habitat</strong></li>
			<li><span>Subvenciones y gestión técnica</span><strong>DS Consultores</strong></li>
			<li><span>Sistema en altura</span><strong>REMAGIN by Etex</strong></li>
			<li><span>Montaje Steel Frame</span><strong>DhHouse</strong></li>
			<li><span>Sistemas industriales</span><strong>CUALIMETAL</strong></li>
		</ul>
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
				<p class="lead">NEXXUS es una marca de consultoría especializada en activos terciarios e industriales y en construcción industrializada. Coordina a cinco empresas líderes en su especialidad para que promotores, inversores y administraciones trabajen con un único responsable durante todo el ciclo del proyecto.</p>
				<p>Cada partner mantiene su empresa, su equipo y su experiencia. NEXXUS aporta la dirección estratégica, la captación de oportunidades y la coordinación entre todos ellos. El cliente gana certeza de plazo, de coste y de resultado. Los partners ganan acceso a proyectos que por separado no alcanzarían.</p>
			</div>
		</div>

		<ul class="pillars">
			<?php foreach ( nexxus_pillars() as $nexxus_p ) : ?>
				<li class="pillar reveal">
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
			<p class="lead">El proyecto avanza en cinco fases. En cada una interviene el partner especialista, siempre bajo la coordinación de NEXXUS.</p>
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
					<div class="line__art"><?php echo nexxus_art_line( $nexxus_l['art'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
					<p class="line__tag"><?php echo esc_html( $nexxus_l['tag'] ); ?></p>
					<h3><span class="line__letter">Línea <?php echo esc_html( $nexxus_l['letter'] ); ?></span><?php echo esc_html( $nexxus_l['title'] ); ?></h3>
					<ul class="checks">
						<?php foreach ( $nexxus_l['items'] as $nexxus_item ) : ?>
							<li><?php echo esc_html( $nexxus_item ); ?></li>
						<?php endforeach; ?>
					</ul>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section" id="ecosistema" aria-labelledby="eco-t">
	<div class="wrap">
		<div class="split split--center">
			<div class="split__head reveal">
				<p class="eyebrow">Ecosistema</p>
				<h2 id="eco-t">Cinco especialistas. Una dirección.</h2>
				<p class="lead">NEXXUS ocupa el centro: capta la oportunidad, define el equipo para cada proyecto y responde ante el cliente. Cada partner trabaja en lo que mejor sabe hacer.</p>
			</div>
			<div class="split__body hub reveal">
				<?php echo nexxus_art_hub(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		</div>

		<div class="partners">
			<?php foreach ( nexxus_partners() as $nexxus_pt ) : ?>
				<article class="partner reveal" id="<?php echo esc_attr( $nexxus_pt['id'] ); ?>">
					<header class="partner__head">
						<p class="partner__kind"><?php echo esc_html( $nexxus_pt['kind'] ); ?></p>
						<h3><?php echo esc_html( $nexxus_pt['name'] ); ?></h3>
						<p class="partner__meta"><?php echo esc_html( $nexxus_pt['meta'] ); ?> <span class="partner__line"><?php echo esc_html( $nexxus_pt['lines'] ); ?></span></p>
					</header>

					<div class="partner__body">
						<p><?php echo esc_html( $nexxus_pt['intro'] ); ?></p>
						<div class="partner__role">
							<p class="partner__role-label">Papel en NEXXUS</p>
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
			<p class="eyebrow">Por qué NEXXUS</p>
			<h2 id="ventajas-t">Lo que gana el cliente.</h2>
		</div>

		<ul class="advantages">
			<?php foreach ( nexxus_advantages() as $nexxus_i => $nexxus_a ) : ?>
				<li class="advantage reveal">
					<span class="advantage__num" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $nexxus_i + 1 ) ); ?></span>
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

<section class="section" id="como-trabajamos" aria-labelledby="reglas-t">
	<div class="wrap">
		<div class="split">
			<div class="split__head reveal">
				<p class="eyebrow">Cómo trabajamos</p>
				<h2 id="reglas-t">Reglas claras entre partners.</h2>
			</div>
			<div class="split__body reveal">
				<p class="lead">NEXXUS es una marca titularidad de <?php echo esc_html( $nexxus_owner['name'] ); ?>. Cada partner se vincula mediante un acuerdo marco propio, sin participación en el capital y con las mismas reglas para todos.</p>
			</div>
		</div>

		<ul class="rules">
			<?php foreach ( nexxus_rules() as $nexxus_r ) : ?>
				<li class="rule reveal">
					<h3><?php echo esc_html( $nexxus_r[0] ); ?></h3>
					<p><?php echo esc_html( $nexxus_r[1] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ul>

		<div class="table-wrap reveal">
			<table class="agreements">
				<caption class="screen-reader-text">Vínculo de cada partner con NEXXUS</caption>
				<thead>
					<tr>
						<th scope="col">Partner</th>
						<th scope="col">Vínculo con NEXXUS</th>
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
	</div>
</section>

<section class="section section--dark contact" id="contacto" aria-labelledby="contacto-t">
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
					Acepto que <?php echo esc_html( $nexxus_owner['name'] ); ?> trate mis datos para responder a esta consulta.
					<?php if ( nexxus_privacy_url() ) : ?>
						<a href="<?php echo esc_url( nexxus_privacy_url() ); ?>">Política de privacidad</a>.
					<?php endif; ?>
				</label>
			</div>
			<p class="form-legal">Responsable: <?php echo esc_html( $nexxus_owner['name'] ); ?>. Finalidad: atender su consulta. Puede ejercer sus derechos de acceso, rectificación y supresión escribiendo a <?php echo esc_html( antispambot( $nexxus_email ) ); ?>.</p>
			<button class="btn" type="submit">Enviar consulta</button>
		</form>
	</div>
</section>

<?php
get_footer();
