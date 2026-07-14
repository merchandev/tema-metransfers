<?php
/**
 * The template for the front page
 *
 * @package Me_Transfers
 */

get_header();

$search_url = esc_url( me_transfers_get_section_url( 'search' ) );
$tours_url  = esc_url( me_transfers_get_section_url( 'tours' ) );
$video_url  = esc_url( 'https://staging2.metransfers.es/wp-content/uploads/2026/06/traslados_privados_en_barcelona__reserva_online_facil_y_rapido_v1-1080p.mp4' );
?>

<main id="primary" class="site-main front-page-main">

	<!-- HERO: Cinematogr&aacute;fico Full-Screen con Video Local -->
	<section class="hero-section">

		<!-- V&iacute;deo de fondo - incrustado desde Vimeo -->
		<iframe 
			class="hero-video-bg" 
			src="https://player.vimeo.com/video/1200289297?background=1&autoplay=1&loop=1&byline=0&title=0&muted=1&quality=1080p,720p,540p" 
			frameborder="0" 
			allow="autoplay; fullscreen; picture-in-picture" 
			allowfullscreen
		></iframe>

		<!-- Overlays atmosf&eacute;ricos -->
		<div class="hero-overlay-dark"></div>
		<div class="hero-overlay-vignette"></div>

		<!-- Contenido principal -->
		<div class="container hero-container">
			<div class="hero-layout">
				<div class="hero-content gs-reveal">

					<!-- Pill badge superior -->
					<div class="hero-badge">
						<span class="hero-badge-dot"></span>
						Traslados Privados &amp; Tours Premium &mdash; Espa&ntilde;a
					</div>

					<!-- Titular -->
					<h1 class="hero-title">
						Traslados y tours en
						<span class="hero-title-highlight">Barcelona</span>
					</h1>

					<!-- Subt&iacute;tulo -->
					<p class="hero-subtitle">
						Tu ch&oacute;fer privado en Barcelona te espera. Veh&iacute;culos de alta gama para traslados al aeropuerto, tours y eventos corporativos. Asegura tu viaje con confirmaci&oacute;n instant&aacute;nea en menos de 2 minutos.
					</p>

					<!-- Botones CTA -->
					<div class="hero-actions">
						<a href="<?php echo $search_url; ?>" class="btn btn-primary hero-btn-main">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
							Buscar Ruta
						</a>
						<a href="<?php echo $tours_url; ?>" class="btn btn-glass">
							Ver Tours
							<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
						</a>
					</div>

					<!-- Stats strip -->
					<div class="hero-stats">
						<div class="hero-stat">
							<span class="hero-stat-number">+5.000</span>
							<span class="hero-stat-label">Traslados</span>
						</div>
						<div class="hero-stat-divider"></div>
						<div class="hero-stat">
							<span class="hero-stat-number">4.9 &#9733;</span>
							<span class="hero-stat-label">GetYourGuide</span>
						</div>
						<div class="hero-stat-divider"></div>
						<div class="hero-stat">
							<span class="hero-stat-number">24/7</span>
							<span class="hero-stat-label">Disponibilidad</span>
						</div>
					</div>

				</div><!-- .hero-content -->

				<div class="hero-booking-column gs-reveal">
					<div class="hero-booking-card">
						<?php if ( shortcode_exists( 'wptb_booking_form' ) ) : ?>
							<?php echo do_shortcode( '[wptb_booking_form]' ); ?>
						<?php else : ?>
							<p class="hero-booking-placeholder">Activa el plugin de reservas para mostrar el formulario.</p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div><!-- .container -->

		<!-- Scroll indicator -->
		<div class="hero-scroll-indicator" aria-hidden="true">
			<span class="hero-scroll-line"></span>
		</div>

	</section>

	<!-- BUSCADOR DE DESTINOS -->
	<section id="search" class="search-plugin-section section">
		<div class="container">
			<header class="section-header section-header--compact gs-reveal">
				<h2 class="section-title">Busca tu <span class="text-gradient">Destino</span></h2>
				<p>Selecciona tu ruta y reserva con confirmaci&oacute;n inmediata y conductor profesional.</p>
			</header>
			<div class="search-plugin-wrapper gs-reveal">
				<?php if ( shortcode_exists( 'premium_transfers_search' ) ) : ?>
					<?php echo do_shortcode( '[premium_transfers_search]' ); ?>
				<?php else : ?>
					<div class="plugin-placeholder-card">
						<h3>Buscador de reservas no activo</h3>
						<p>Instala y activa el plugin independiente <strong>Sistema de reservas Metransfers</strong> para mostrar el buscador.</p>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<!-- SERVICIOS DE ELITE -->
	<section id="services" class="services-section section">
		<div class="container">
			<header class="section-header gs-reveal">
				<h2 class="section-title">Servicios de <span class="text-gradient">&Eacute;lite</span></h2>
				<p>Privacidad, comodidad absoluta y veh&iacute;culos de alta gama listos para llevarte por las mejores rutas y carreteras de Espa&ntilde;a.</p>
			</header>

			<div class="services-grid">
				<?php 
				$services = me_transfers_get_service_catalog();
				foreach ( $services as $service ) : 
				?>
				<div class="service-card gs-stagger">
					<div class="service-icon-wrapper">
						<img class="service-icon-image" src="<?php echo esc_url( add_query_arg( 'v', ME_TRANSFERS_VERSION, $service['icon'] ) ); ?>" alt="" width="40" height="40" decoding="async">
					</div>
					<h3 class="service-title"><?php echo esc_html( $service['title'] ); ?></h3>
					<p class="service-desc"><?php echo esc_html( $service['desc'] ); ?></p>
					<a href="<?php echo esc_url( me_transfers_get_service_url( $service['slug'] ) ); ?>" class="service-link">Consultar <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- BANNER FLOTA -->
	<section class="banner-section road-divider gs-reveal">
		<div class="container banner-content">
			<h2 class="section-title">Nuestra <span class="text-gradient">Flota Elegante</span></h2>
			<p>Gama alta de Mercedes: Clase E, Clase V y la majestuosa Clase S. Perfectamente mantenida para ofrecer la mejor experiencia en carretera.</p>
			<br>
			<a href="<?php echo $search_url; ?>" class="btn btn-primary gs-stagger">Solicitar Veh&iacute;culo</a>
		</div>
	</section>

	<!-- RESE&Ntilde;AS GetYourGuide -->
	<section class="gyg-section section">
		<div class="container">
			<header class="section-header section-header--compact gs-reveal">
				<h2 class="section-title">Confianza de<br><span class="text-gradient">Viajeros Globales</span></h2>
				<p>Conduciendo la excelencia. Lee lo que opinan cientos de clientes de todo el mundo.</p>
				<span class="gyg-badge">&#9733; 4.9 / 5 en GetYourGuide</span>
			</header>
		</div>
		<div class="gs-reveal">
			<?php if ( shortcode_exists( 'gyg_reviews' ) ) : ?>
				<?php echo do_shortcode( '[gyg_reviews count="8"]' ); ?>
			<?php endif; ?>
		</div>
	</section>

	<!-- TOURS Y EXCURSIONES -->
	<section id="tours" class="services-section section road-top">
		<div class="container">
			<header class="section-header gs-reveal">
				<h2 class="section-title">Tours y <span class="text-gradient">Excursiones</span></h2>
				<p>Descubre Barcelona y Catalu&ntilde;a con experiencias privadas dise&ntilde;adas para combinar cultura, paisaje y confort premium.</p>
			</header>

			<?php $tours_catalog = me_transfers_get_tour_catalog(); ?>
			<div class="tours-grid gs-reveal">
				<?php foreach ( $tours_catalog as $tour ) : ?>
					<article class="tour-card gs-stagger">
						<div class="tour-img" style="background-image:url('<?php echo esc_url( $tour['img'] ); ?>');" role="img" aria-label="<?php echo esc_attr( $tour['title'] ); ?>"></div>
						<div class="tour-content">
							<h3><?php echo esc_html( $tour['title'] ); ?></h3>
							<p><?php echo esc_html( $tour['desc'] ); ?></p>
							<a href="<?php echo esc_url( me_transfers_get_tour_url( $tour['slug'] ) ); ?>" class="tour-link">Detalles</a>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- ==========================================
	     BLOG: &Uacute;ltimas Entradas
	     ========================================== -->
	<?php
	$blog_query_args = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 3,
		'ignore_sticky_posts' => false,
		'orderby'             => 'date',
		'order'               => 'DESC',
		'no_found_rows'       => true,
	);

	$blog_posts = new WP_Query( $blog_query_args );

	if ( ! $blog_posts->have_posts() ) {
		$blog_posts = new WP_Query(
			array_merge(
				$blog_query_args,
				array(
					'suppress_filters' => true,
				)
			)
		);
	}

	?>
	<section id="blog" class="fp-blog-section section">
		<div class="container">
			<header class="section-header gs-reveal">
				<h2 class="section-title">Blog &amp; <span class="text-gradient">Gu&iacute;as de Viaje</span></h2>
				<p>Consejos, rutas y todo lo que necesitas saber para viajar en Barcelona y Catalu&ntilde;a con estilo.</p>
			</header>

			<?php if ( $blog_posts->have_posts() ) : ?>
				<div class="fp-blog-grid">
					<?php while ( $blog_posts->have_posts() ) : $blog_posts->the_post(); ?>
					<article class="fp-blog-card gs-stagger">
						<div class="fp-blog-card__body">

							<?php $cats = get_the_category(); if ( $cats ) : ?>
							<a href="<?php echo esc_url( get_category_link( $cats[0]->term_id ) ); ?>" class="fp-blog-card__cat">
								<?php echo esc_html( $cats[0]->name ); ?>
							</a>
							<?php endif; ?>

							<h3 class="fp-blog-card__title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h3>

							<p class="fp-blog-card__excerpt">
								<?php echo wp_trim_words( get_the_excerpt(), 18, '…' ); ?>
							</p>

							<div class="fp-blog-card__meta">
								<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" class="fp-blog-card__date">
									<?php echo get_the_date( 'd M Y' ); ?>
								</time>
								<a href="<?php the_permalink(); ?>" class="fp-blog-card__read-more">
									Leer m&aacute;s
									<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
								</a>
							</div>

						</div>
					</article>
					<?php endwhile; ?>
				</div>
			<?php else : ?>
				<p class="fp-blog-empty">No hay entradas publicadas del blog para mostrar todav&iacute;a.</p>
			<?php endif; ?>

			<?php wp_reset_postdata(); ?>

			<div class="fp-blog-cta gs-reveal">
				<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' ) ); ?>" class="btn btn-outline">
					Ver todos los art&iacute;culos
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
				</a>
			</div>

		</div>
	</section>

<!-- FORMULARIO DE CONTACTO -->
<section id="contacto" class="contact-section section">
<div class="container">
<header class="section-header gs-reveal">
<h2 class="section-title">Cont&aacute;ctanos <span class="text-gradient">Directamente</span></h2>
<p>&iquest;Tienes alguna pregunta sobre nuestros servicios? Env&iacute;anos un mensaje y te responderemos lo antes posible.</p>
</header>

<div class="contact-grid gs-reveal">
<!-- Contact Info -->
<div class="contact-info-card">
<div class="contact-info-item">
<div class="contact-info-icon">
<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.62 2h3A2 2 0 0 1 8.6 3.72c.12.92.34 1.82.67 2.69a2 2 0 0 1-.45 2.11L7.73 9.61a16 16 0 0 0 6.66 6.66l1.09-1.09a2 2 0 0 1 2.11-.45c.87.33 1.77.55 2.69.67A2 2 0 0 1 22 16.92z"/></svg>
</div>
<div>
<h4>Tel&eacute;fono</h4>
<a href="tel:+34662024136">+34 662 024 136</a>
</div>
</div>

<div class="contact-info-item">
<div class="contact-info-icon">
<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
</div>
<div>
<h4>Email</h4>
<a href="mailto:info@metransfers.es">info@metransfers.es</a>
</div>
</div>

<div class="contact-info-item">
<div class="contact-info-icon">
<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
</div>
<div>
<h4>Ubicaci&oacute;n</h4>
<p>Barcelona, Espa&ntilde;a</p>
</div>
</div>

<div class="contact-info-item">
<div class="contact-info-icon">
<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
</div>
<div>
<h4>Horario</h4>
<p>24 horas / 7 d&iacute;as</p>
</div>
</div>

<div class="contact-info-whatsapp">
<a href="https://wa.me/34662024136?text=Hola,%20quiero%20informaci%C3%B3n%20sobre%20los%20servicios%20de%20MeTransfers" target="_blank" rel="noopener" class="btn btn-whatsapp">
<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2 22l4.832-1.438A9.955 9.955 0 0 0 12 22c5.523 0 10-4.477 10-10S17.523 2 12 2z"/></svg>
Escribir por WhatsApp
</a>
</div>
</div>

<!-- Contact Form -->
<div class="contact-form-card">
<style>
.contact-form-field { visibility:visible!important; opacity:1!important; display:flex!important; flex-direction:column!important; gap:6px!important }
.contact-form-field label { color:#0f172a!important; display:block!important; font-weight:600!important; font-size:0.9rem!important; visibility:visible!important; opacity:1!important; margin-bottom:0!important; letter-spacing:0.3px!important; text-transform:none!important }
.contact-form-field input, .contact-form-field textarea { background-color:#ffffff!important; color:#0f172a!important; border:2px solid #e2e8f0!important; visibility:visible!important; opacity:1!important; display:block!important; padding:16px 20px!important; width:100%!important; border-radius:12px!important; min-height:54px!important; font-size:1rem!important; transition:all 0.3s ease!important; box-shadow:0 2px 4px rgba(0,0,0,0.02)!important }
.contact-form-field input:focus, .contact-form-field textarea:focus { border-color:#004E9A!important; box-shadow:0 0 0 4px rgba(0,78,154,0.1)!important; outline:none!important; background-color:#f8fafc!important }
.contact-form-field input::placeholder, .contact-form-field textarea::placeholder { color:#94a3b8!important; opacity:1!important; font-weight:400!important }
.contact-form-submit { font-size:1.05rem!important; font-weight:700!important; letter-spacing:0.5px!important; text-transform:none!important; border-radius:100px!important; padding:16px 36px!important; transition:all 0.3s ease!important; display:flex!important; gap:10px!important; align-items:center!important; justify-content:center!important; width:100%!important; box-shadow:0 8px 20px rgba(0,78,154,0.25)!important; margin-top:0.5rem!important; background-color:#004E9A!important; color:#ffffff!important; border:none!important; cursor:pointer!important; }
.contact-form-submit:hover { transform:translateY(-2px)!important; box-shadow:0 10px 20px rgba(0,78,154,0.35)!important }
</style>
<form id="mt-contact-form" class="contact-form" novalidate>
<input type="hidden" name="action" value="me_transfers_contact_request">
<input type="hidden" name="security" value="">
<div style="position:absolute;left:-9999px;" aria-hidden="true"><input type="text" name="mt_subject" tabindex="-1" autocomplete="off"></div>

<div class="contact-form-field">
<label for="cf-name">Nombre y Apellidos *</label>
<input type="text" id="cf-name" name="name" required placeholder="Ej. Mar&iacute;a Garc&iacute;a">
</div>
<div class="contact-form-field">
<label for="cf-email">Correo electr&oacute;nico *</label>
<input type="email" id="cf-email" name="email" required placeholder="Ej. hola@tuemail.com">
</div>
<div class="contact-form-field">
<label for="cf-phone">Tel&eacute;fono de Contacto (opcional)</label>
<input type="tel" id="cf-phone" name="phone" placeholder="Ej. +34 600 000 000">
</div>
<div class="contact-form-field contact-form-field--full">
<label for="cf-message">&iquest;C&oacute;mo podemos ayudarte? *</label>
<textarea id="cf-message" name="message" required rows="4" placeholder="Ind&iacute;canos los detalles de tu traslado, fechas, rutas o dudas..."></textarea>
</div>
<div class="contact-form-field contact-form-field--full">
<button type="submit" class="btn btn-primary contact-form-submit">
<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2L11 13"></path><path d="M22 2L15 22L11 13L2 9L22 2Z"></path></svg>
Solicitar Presupuesto Gratis
</button>
</div>
</form>
<div id="mt-contact-msg" style="display:none; margin-top:1rem; padding:1rem; border-radius:12px; text-align:center; font-weight:600;"></div>
</div>
</div>
</div>
</section>

<!-- Contact Form JS -->
<script>
(function(){
var form = document.getElementById('mt-contact-form');
if (!form) return;
var nf = form.querySelector('input[name="security"]');
if (nf && typeof meTransfers !== 'undefined') nf.value = meTransfers.contactNonce;
form.addEventListener('submit', function(e) {
e.preventDefault();
var btn = form.querySelector('button[type="submit"]');
var msg = document.getElementById('mt-contact-msg');
var orig = btn.innerHTML;
var n = form.querySelector('[name="name"]').value.trim();
var em = form.querySelector('[name="email"]').value.trim();
var m = form.querySelector('[name="message"]').value.trim();
if (!n||!em||!m) { msg.style.display='block'; msg.style.background='rgba(220,38,38,0.08)'; msg.style.color='#991b1b'; msg.textContent='Por favor, completa los campos obligatorios.'; return; }
btn.disabled=true; btn.textContent='Enviando...';
fetch(meTransfers.ajaxUrl,{method:'POST',body:new FormData(form)})
.then(function(r){return r.json()})
.then(function(res){
msg.style.display='block';
if(res.success){msg.style.background='rgba(22,163,74,0.08)';msg.style.color='#166534';msg.textContent=res.data.message;form.reset();}
else{msg.style.background='rgba(220,38,38,0.08)';msg.style.color='#991b1b';msg.textContent=res.data&&res.data.message?res.data.message:'Error al enviar.';}
btn.disabled=false;btn.innerHTML=orig;
}).catch(function(){msg.style.display='block';msg.style.background='rgba(220,38,38,0.08)';msg.style.color='#991b1b';msg.textContent='Error de conexion.';btn.disabled=false;btn.innerHTML=orig;});
});
})();
</script>
</main>

<?php get_footer(); ?>




