<?php
/**
 * Template for pages and destination landing pages.
 *
 * @package Me_Transfers
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php
	while ( have_posts() ) :
		the_post();

		$current_post        = get_post();
		$current_destination = me_transfers_get_current_destination( $current_post );
		$hub_content_plain   = trim( wp_strip_all_tags( strip_shortcodes( get_the_content() ) ) );

		if ( me_transfers_is_destinations_hub( $current_post ) ) :
			$destinations = me_transfers_get_destination_catalog();
			?>
			<section class="destinations-hub-hero">
				<div class="container destinations-hub-hero__inner gs-reveal-up">
					<span class="destinations-hub-eyebrow"><?php esc_html_e( 'Destinos mÃ¡s solicitados', 'me-transfers' ); ?></span>
					<h1 class="destinations-hub-title"><?php esc_html_e( 'Destinos', 'me-transfers' ); ?></h1>
					<p class="destinations-hub-intro">
						<?php
						if ( $hub_content_plain ) {
							echo esc_html( $hub_content_plain );
						} else {
							esc_html_e( 'Explora los destinos mÃ¡s solicitados y accede a una ficha rÃ¡pida para pedir informaciÃ³n de traslados privados, recogidas en aeropuerto, hoteles, puertos y rutas personalizadas.', 'me-transfers' );
						}
						?>
					</p>
				</div>
			</section>

			<section class="destinations-directory section">
				<div class="container">
					<div class="destinations-directory-grid">
						<?php foreach ( $destinations as $destination ) : ?>
							<article class="destination-card gs-stagger">
								<span class="destination-card-index"><?php echo esc_html( str_pad( (string) $destination['order'], 2, '0', STR_PAD_LEFT ) ); ?></span>
								<h2 class="destination-card-title"><?php echo esc_html( $destination['title'] ); ?></h2>
								<p class="destination-card-copy">
									<?php
									echo esc_html(
										sprintf(
											/* translators: %s: destination title. */
											__( 'Consulta disponibilidad y presupuesto para traslados privados hacia %s.', 'me-transfers' ),
											$destination['title']
										)
									);
									?>
								</p>
								<a href="<?php echo esc_url( me_transfers_get_destination_url( $destination, true ) ); ?>" class="destination-card-link">
									<?php esc_html_e( 'Solicitar informaciÃ³n', 'me-transfers' ); ?>
								</a>
							</article>
						<?php endforeach; ?>
					</div>
				</div>
			</section>
			<?php
		elseif ( me_transfers_is_faq_page( $current_post ) ) :
			$faq_items        = me_transfers_get_faq_items();
			$privacy_url      = get_privacy_policy_url();
			$cancellation_url = '';
			$cancellation_slugs = array( 'politica-de-cancelacion', 'cancelacion', 'politica-cancelacion' );

			foreach ( $cancellation_slugs as $slug ) {
				$cancellation_page = get_page_by_path( $slug, OBJECT, 'page' );

				if ( $cancellation_page instanceof WP_Post ) {
					$cancellation_url = get_permalink( $cancellation_page );
					break;
				}
			}

			$faq_schema = array(
				'@context'   => 'https://schema.org',
				'@type'      => 'FAQPage',
				'mainEntity' => array_map(
					static function( $item ) {
						return array(
							'@type'          => 'Question',
							'name'           => $item['question'],
							'acceptedAnswer' => array(
								'@type' => 'Answer',
								'text'  => implode( ' ', $item['answer'] ),
							),
						);
					},
					$faq_items
				),
			);
			?>
			<script type="application/ld+json"><?php echo wp_json_encode( $faq_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ); ?></script>

			<section class="faq-page-hero">
				<div class="container faq-page-hero__inner">
					<span class="faq-page-kicker"><?php esc_html_e( 'Centro de ayuda', 'me-transfers' ); ?></span>
					<h1 class="faq-page-title">Preguntas Frecuentes</h1>
					<p class="faq-page-summary">
						Encuentra respuestas claras y rÃ¡pidas a las dudas mÃ¡s comunes sobre nuestros servicios de transporte privado. Desde reservas y tarifas hasta detalles sobre nuestras rutas y vehÃ­culos, aquÃ­ encontrarÃ¡s toda la informaciÃ³n que necesitas para planificar tu traslado con metransfers.es. Â¿Tienes mÃ¡s preguntas frecuentes? ContÃ¡ctanos y estaremos encantados de ayudarte.
					</p>
				</div>
			</section>

			<section class="faq-page-section section">
				<div class="container faq-page-shell">
					<div class="faq-page-intro">
						<h2>Todo lo que necesitas saber antes de reservar</h2>
						<p>Hemos reunido las consultas mÃ¡s habituales sobre reservas, vehÃ­culos, aeropuertos, pagos, cancelaciones y atenciÃ³n al cliente para que encuentres la informaciÃ³n de forma rÃ¡pida y ordenada.</p>
					</div>

					<div class="faq-accordion">
						<?php foreach ( $faq_items as $index => $faq_item ) : ?>
							<details class="faq-item" <?php echo 0 === $index ? 'open' : ''; ?>>
								<summary class="faq-item__summary">
									<span class="faq-item__number"><?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
									<span class="faq-item__question"><?php echo esc_html( $faq_item['question'] ); ?></span>
									<span class="faq-item__icon" aria-hidden="true"></span>
								</summary>
								<div class="faq-item__content">
									<?php foreach ( $faq_item['answer'] as $paragraph ) : ?>
										<p><?php echo esc_html( $paragraph ); ?></p>
									<?php endforeach; ?>

									<?php if ( 2 === $index ) : ?>
										<p>
											<?php if ( $cancellation_url ) : ?>
												Puedes acceder a nuestra polÃ­tica de cancelaciÃ³n completa <a href="<?php echo esc_url( $cancellation_url ); ?>">haciendo clic aquÃ­</a>.
											<?php else : ?>
												Puedes consultar nuestra polÃ­tica de cancelaciÃ³n completa contactando con nuestro equipo.
											<?php endif; ?>
										</p>
									<?php endif; ?>

									<?php if ( 10 === $index && $privacy_url ) : ?>
										<p>Puedes acceder a nuestra polÃ­tica de privacidad completa <a href="<?php echo esc_url( $privacy_url ); ?>">haciendo clic aquÃ­</a>.</p>
									<?php endif; ?>
								</div>
							</details>
						<?php endforeach; ?>
					</div>

					<div class="faq-page-cta">
						<span class="faq-page-cta__kicker">Reserva Ahora</span>
						<h2>Reserva online, rÃ¡pido y con pago seguro</h2>
						<p>metransfers.es es una de las principales agencias de transporte privado en Barcelona. Reserva online, rÃ¡pido y con pago seguro. Ofrecemos alquiler de coches con conductor, visitas guiadas y servicio de chofer 24/7.</p>
						<a href="<?php echo esc_url( me_transfers_get_section_url( 'search' ) ); ?>" class="btn btn-primary">Reservar ahora</a>
					</div>
				</div>
			</section>
			<?php
		elseif ( 'legal' === get_post_meta( $current_post->ID, '_me_transfers_page_role', true ) || is_page( array( 'privacidad', 'politica-de-privacidad', 'cookie', 'cookies', 'terminos-y-condiciones', 'aviso-legal' ) ) ) :
			$updated_date = get_the_modified_date();
			?>
			<header class="page-banner">
				<div class="container banner-content gs-reveal-up">
					<h1 class="page-banner__title">
						<?php the_title(); ?>
					</h1>
					<p class="page-banner__meta">
						METRANSFERS GESTION SL &middot; &Uacute;ltima actualizaci&oacute;n: <?php echo esc_html( $updated_date ); ?>
					</p>
				</div>
			</header>

			<section class="page-content-wrapper legal-page__content section">
				<div class="container page-content-shell">
					<div class="entry-content legal-prose">
						<?php the_content(); ?>
					</div>
				</div>
			</section>
			<?php
		elseif ( $current_destination ) :
			$page_content = trim( wp_strip_all_tags( strip_shortcodes( get_the_content() ) ) );
			$other_destinations = array_filter(
				me_transfers_get_destination_catalog(),
				static function( $item ) use ( $current_destination ) {
					return $item['slug'] !== $current_destination['slug'];
				}
			);
			$other_destinations = array_slice( array_values( $other_destinations ), 0, 6 );
			$destination_service_cards = array(
				array(
					'title' => 'Recogida personalizada',
					'text'  => sprintf( 'Coordinamos salidas desde Barcelona, aeropuerto, hotel o puerto para traslados hacia %s con una operativa clara desde el primer contacto.', $current_destination['title'] ),
				),
				array(
					'title' => 'Vehiculo adecuado',
					'text'  => 'Asignamos sedan, minivan o vehiculo premium segun pasajeros, equipaje, horario y nivel de servicio que necesites.',
				),
				array(
					'title' => 'Precio y tiempos claros',
					'text'  => sprintf( 'Recibes una propuesta cerrada, con respuesta agil y todos los detalles del recorrido hacia %s antes de confirmar.', $current_destination['title'] ),
				),
			);
			$destination_use_cases = array(
				'Aeropuerto y estaciones',
				'Hoteles y apartamentos',
				'Viajes corporativos',
				'Familias y grupos',
				'Eventos privados',
				'Servicio por horas',
			);
			$destination_steps = array(
				array(
					'step'  => '01',
					'title' => 'Cuentanos tu ruta',
					'text'  => sprintf( 'Indicanos origen, destino %s, fecha, pasajeros y cualquier detalle relevante para preparar el servicio.', $current_destination['title'] ),
				),
				array(
					'step'  => '02',
					'title' => 'Preparamos la propuesta',
					'text'  => 'Te enviamos disponibilidad, tipo de vehiculo recomendado y condiciones del traslado con precio claro.',
				),
				array(
					'step'  => '03',
					'title' => 'Confirmamos la recogida',
					'text'  => sprintf( 'Una vez aceptado, dejamos coordinado el punto de encuentro y el trayecto hacia %s para que viajes sin friccion.', $current_destination['title'] ),
				),
			);
			$destination_routes = array(
				sprintf( 'Barcelona centro - %s', $current_destination['title'] ),
				sprintf( 'Aeropuerto de Barcelona - %s', $current_destination['title'] ),
				sprintf( 'Puerto de Barcelona - %s', $current_destination['title'] ),
				sprintf( 'Hotel, apartamento o evento - %s', $current_destination['title'] ),
			);
			?>
			<section class="destination-page-hero">
				<div class="container destination-page-hero__inner">
					<nav class="destination-breadcrumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'me-transfers' ); ?>">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Inicio', 'me-transfers' ); ?></a>
						<span aria-hidden="true">/</span>
						<a href="<?php echo esc_url( me_transfers_get_destinations_hub_url() ); ?>"><?php esc_html_e( 'Destinos', 'me-transfers' ); ?></a>
						<span aria-hidden="true">/</span>
						<span aria-current="page"><?php echo esc_html( $current_destination['title'] ); ?></span>
					</nav>

					<span class="destination-page-kicker"><?php esc_html_e( 'Solicitud de traslado premium', 'me-transfers' ); ?></span>
					<h1 class="destination-page-title"><?php echo esc_html( $current_destination['title'] ); ?></h1>
					<p class="destination-page-summary"><?php echo esc_html( $current_destination['summary'] ); ?></p>

					<div class="destination-page-pills">
						<span><?php esc_html_e( 'Puerta a puerta', 'me-transfers' ); ?></span>
						<span><?php esc_html_e( 'ChÃ³fer profesional', 'me-transfers' ); ?></span>
						<span><?php esc_html_e( 'Respuesta rÃ¡pida', 'me-transfers' ); ?></span>
					</div>
				</div>
			</section>

			<section class="destination-page-section section">
				<div class="container destination-page-layout">
					<div class="destination-page-copy">
						<div class="destination-copy-card">
							<h2><?php echo esc_html( sprintf( __( 'InformaciÃ³n para traslados a %s', 'me-transfers' ), $current_destination['title'] ) ); ?></h2>

							<?php if ( $page_content ) : ?>
								<div class="entry-content luxury-prose">
									<?php the_content(); ?>
								</div>
							<?php else : ?>
								<div class="destination-copy-prose">
									<p><?php echo esc_html( $current_destination['travel_note'] ); ?></p>
									<p>
										<?php
										echo esc_html(
											sprintf(
												/* translators: %s: destination title. */
												__( 'Si estÃ¡s organizando un traslado hacia %s, podemos prepararte una propuesta adaptada al punto de recogida, nÃºmero de pasajeros, fecha estimada y tipo de servicio que necesites.', 'me-transfers' ),
												$current_destination['title']
											)
										);
										?>
									</p>

									<ul class="destination-highlights">
										<?php foreach ( $current_destination['highlights'] as $highlight ) : ?>
											<li><?php echo esc_html( $highlight ); ?></li>
										<?php endforeach; ?>
									</ul>
								</div>
							<?php endif; ?>
						</div>

						<div class="destination-extra-card">
							<div class="destination-extra-header">
								<span class="destination-extra-kicker">Servicio premium</span>
								<h3>Un traslado mejor organizado y con mas contexto</h3>
								<p>Esta pagina te ayuda a entender mejor como trabajamos los traslados privados hacia <?php echo esc_html( $current_destination['title'] ); ?> y que puedes esperar antes de solicitar informacion.</p>
							</div>

							<div class="destination-use-cases">
								<?php foreach ( $destination_use_cases as $use_case ) : ?>
									<span><?php echo esc_html( $use_case ); ?></span>
								<?php endforeach; ?>
							</div>

							<div class="destination-mini-grid">
								<?php foreach ( $destination_service_cards as $service_card ) : ?>
									<article class="destination-mini-card">
										<h3><?php echo esc_html( $service_card['title'] ); ?></h3>
										<p><?php echo esc_html( $service_card['text'] ); ?></p>
									</article>
								<?php endforeach; ?>
							</div>
						</div>
					</div>

					<aside id="destination-request" class="destination-page-sidebar">
						<div class="destination-form-card">
							<span class="destination-form-card__eyebrow"><?php esc_html_e( 'Formulario de contacto', 'me-transfers' ); ?></span>
							<h2><?php echo esc_html( sprintf( __( 'Pide informaciÃ³n para %s', 'me-transfers' ), $current_destination['title'] ) ); ?></h2>
							<p><?php esc_html_e( 'CuÃ©ntanos origen, fechas y necesidades del servicio. Te responderemos con disponibilidad y propuesta personalizada.', 'me-transfers' ); ?></p>
							<?php echo me_transfers_render_destination_request_form( $current_destination ); ?>
						</div>
					</aside>
				</div>
			</section>

			<section class="destination-process-section">
				<div class="container">
					<div class="destination-section-heading">
						<span class="destination-section-kicker">Proceso de reserva</span>
						<h2>Como organizamos tu traslado a <?php echo esc_html( $current_destination['title'] ); ?></h2>
						<p>Definimos ruta, horario, tipo de vehiculo y recogida con antelacion para que el trayecto sea claro, comodo y previsible.</p>
					</div>

					<div class="destination-process-grid">
						<?php foreach ( $destination_steps as $destination_step ) : ?>
							<article class="destination-process-card">
								<span class="destination-process-step"><?php echo esc_html( $destination_step['step'] ); ?></span>
								<h3><?php echo esc_html( $destination_step['title'] ); ?></h3>
								<p><?php echo esc_html( $destination_step['text'] ); ?></p>
							</article>
						<?php endforeach; ?>
					</div>
				</div>
			</section>

			<section class="destination-routes-section">
				<div class="container">
					<div class="destination-routes-card">
						<div class="destination-routes-copy">
							<span class="destination-section-kicker">Trayectos habituales</span>
							<h2>Rutas frecuentes hacia <?php echo esc_html( $current_destination['title'] ); ?></h2>
							<p>Trabajamos traslados privados desde diferentes puntos de Barcelona para adaptarnos a llegadas, salidas, hoteles, eventos y viajes de negocio.</p>
						</div>

						<ul class="destination-routes-list">
							<?php foreach ( $destination_routes as $destination_route ) : ?>
								<li><?php echo esc_html( $destination_route ); ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</section>

			<section class="destination-benefits-section">
				<div class="container">
					<div class="destination-benefits-grid">
						<article class="destination-benefit-card destination-benefit-card--pricing">
							<div class="destination-benefit-icon" aria-hidden="true">
								<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
									<path d="M20.59 13.41 11 3.83a2 2 0 0 0-1.41-.58H4a2 2 0 0 0-2 2v5.59a2 2 0 0 0 .58 1.41L12.17 22a2 2 0 0 0 2.83 0l5.59-5.59a2 2 0 0 0 0-2.83Z"/>
									<path d="M7 7h.01"/>
									<path d="M10 14c.5.55 1.22 1 2 1 1.1 0 2-.9 2-2 0-2-3-1-3-3 0-1.1.9-2 2-2 .78 0 1.5.45 2 1"/>
									<path d="M12 7v10"/>
								</svg>
							</div>
							<h2>Precios Cerrados</h2>
							<p>Contrata uno de nuestros servicios y paga lo que realmente contratas, sin pagos posteriores ni recargos sorpresivos.</p>
						</article>

						<article class="destination-benefit-card destination-benefit-card--private">
							<div class="destination-benefit-icon" aria-hidden="true">
								<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
									<path d="M5 12h14"/>
									<path d="m12 5 7 7-7 7"/>
									<path d="M5 5v5"/>
									<path d="M3 7h4"/>
								</svg>
							</div>
							<h2>Traslados Privados</h2>
							<p>Traslado Privado en Barcelona o Madrid desde el Aeropuerto o cualquier punto de la ciudad hacia cualquier punto.</p>
						</article>

						<article class="destination-benefit-card destination-benefit-card--flex">
							<div class="destination-benefit-icon" aria-hidden="true">
								<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
									<rect x="3" y="4" width="14" height="14" rx="2"/>
									<path d="M7 2v4M13 2v4M3 10h14"/>
									<circle cx="19" cy="17" r="4"/>
									<path d="M19 15v2l1.5 1.5"/>
								</svg>
							</div>
							<h2>Reservas Flexibles</h2>
							<p>Metransfers Barcelona ofrece una cancelaciÃ³n gratuita hasta 24 horas antes de su actividad, siempre hay espacio para un cambio de planes.</p>
						</article>

						<article class="destination-benefit-card destination-benefit-card--support">
							<div class="destination-benefit-icon" aria-hidden="true">
								<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
									<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.62 2h3A2 2 0 0 1 8.6 3.72c.12.92.34 1.82.67 2.69a2 2 0 0 1-.45 2.11L7.73 9.61a16 16 0 0 0 6.66 6.66l1.09-1.09a2 2 0 0 1 2.11-.45c.87.33 1.77.55 2.69.67A2 2 0 0 1 22 16.92z"/>
									<path d="M15 7a5 5 0 0 1 5 5"/>
									<path d="M15 3a9 9 0 0 1 9 9"/>
								</svg>
							</div>
							<h2>Soporte TelefÃ³nico 24 Horas</h2>
							<p>Servicio 24/7 para que tu experiencia sea inolvidable, ya sea por telÃ©fono, email o WhatsApp.</p>
						</article>
					</div>
				</div>
			</section>

			<?php if ( $other_destinations ) : ?>
				<section class="destination-other-section">
					<div class="container">
						<div class="destination-other-header">
							<h2><?php esc_html_e( 'Otros destinos destacados', 'me-transfers' ); ?></h2>
							<a href="<?php echo esc_url( me_transfers_get_destinations_hub_url() ); ?>" class="destination-other-link"><?php esc_html_e( 'Ver todos los destinos', 'me-transfers' ); ?></a>
						</div>

						<div class="destination-other-grid">
							<?php foreach ( $other_destinations as $destination ) : ?>
								<a href="<?php echo esc_url( me_transfers_get_destination_url( $destination, true ) ); ?>" class="destination-other-card">
									<span class="destination-other-card__title"><?php echo esc_html( $destination['title'] ); ?></span>
									<span class="destination-other-card__link"><?php esc_html_e( 'Solicitar info', 'me-transfers' ); ?></span>
								</a>
							<?php endforeach; ?>
						</div>
					</div>
				</section>
			<?php endif; ?>
			<?php
		elseif ( $tour = me_transfers_get_current_tour( $current_post ) ) :
			$other_tours = array_filter(
				me_transfers_get_tour_catalog(),
				static function( $item ) use ( $tour ) {
					return $item['slug'] !== $tour['slug'];
				}
			);
			?>
			<!-- TOUR HERO -->
			<section class="destination-page-hero">
				<div class="container destination-page-hero__inner">
					<nav class="destination-breadcrumbs" aria-label="Breadcrumb">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Inicio</a>
						<span aria-hidden="true">/</span>
						<a href="<?php echo esc_url( home_url( '/#tours' ) ); ?>">Tours</a>
						<span aria-hidden="true">/</span>
						<span aria-current="page"><?php echo esc_html( $tour['title'] ); ?></span>
					</nav>
					<span class="destination-page-kicker">Tour Privado Premium</span>
					<h1 class="destination-page-title"><?php echo esc_html( $tour['title'] ); ?></h1>
					<p class="destination-page-summary"><?php echo esc_html( $tour['desc'] ); ?></p>
					<div class="destination-page-pills">
						<span><?php echo esc_html( $tour['duration'] ); ?></span>
						<span><?php echo esc_html( $tour['group_size'] ); ?></span>
						<span><?php echo esc_html( $tour['price'] ); ?></span>
						<span>Chofer privado</span>
					</div>
				</div>
			</section>

			<!-- TOUR CONTENT + BOOKING -->
			<section class="destination-page-section section">
				<div class="container destination-page-layout">
					<div class="destination-page-copy">
						<div class="destination-copy-card">
							<img src="<?php echo esc_url( $tour['img'] ); ?>" alt="<?php echo esc_attr( $tour['title'] ); ?>" style="width:100%;border-radius:16px;margin-bottom:1.5rem;object-fit:cover;max-height:420px;">
							<h2>Sobre este tour</h2>
							<div class="destination-copy-prose">
								<?php
								$tour_page_content = trim( wp_strip_all_tags( strip_shortcodes( get_the_content() ) ) );
								if ( $tour_page_content ) {
									echo '<div class="entry-content luxury-prose">';
									the_content();
									echo '</div>';
								} else {
									$paragraphs = isset( $tour['full_desc'] ) ? explode( "\n\n", $tour['full_desc'] ) : array( $tour['desc'] );
									foreach ( $paragraphs as $p ) :
										$p = trim( $p );
										if ( $p ) : ?>
										<p><?php echo esc_html( $p ); ?></p>
									<?php endif; endforeach;
								}
								?>
							</div>
						</div>
						<?php if ( ! empty( $tour['itinerary'] ) ) : ?>
						<div class="destination-extra-card">
							<div class="destination-extra-header">
								<span class="destination-extra-kicker">Itinerario del dia</span>
								<h3>Recorrido paso a paso</h3>
								<p>Itinerario sugerido, completamente flexible y personalizable.</p>
							</div>
							<div style="display:grid;gap:0.8rem;">
							<?php foreach ( $tour['itinerary'] as $idx => $step ) : ?>
								<div style="display:flex;align-items:flex-start;gap:0.85rem;">
									<span class="destination-process-step" style="flex-shrink:0;width:2.2rem;height:2.2rem;font-size:0.72rem;"><?php echo esc_html( str_pad( (string) ( $idx + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
									<p style="margin:0;padding-top:0.3rem;"><?php echo esc_html( $step ); ?></p>
								</div>
							<?php endforeach; ?>
							</div>
						</div>
						<?php endif; ?>
						<?php if ( ! empty( $tour['includes'] ) ) : ?>
						<div class="destination-extra-card">
							<div class="destination-extra-header">
								<span class="destination-extra-kicker">Todo incluido</span>
								<h3>Que incluye el tour</h3>
							</div>
							<ul style="list-style:none;padding:0;margin:0;display:grid;gap:0.75rem;">
							<?php foreach ( $tour['includes'] as $inc ) : ?>
								<li style="display:flex;align-items:center;gap:0.65rem;">
									<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent-primary)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
									<span><?php echo esc_html( $inc ); ?></span>
								</li>
							<?php endforeach; ?>
							</ul>
						</div>
						<?php endif; ?>
						<?php if ( ! empty( $tour['highlights'] ) ) : ?>
						<div class="destination-extra-card">
							<div class="destination-extra-header">
								<span class="destination-extra-kicker">Puntos destacados</span>
								<h3>Lugares que visitaras</h3>
							</div>
							<div class="destination-use-cases">
							<?php foreach ( $tour['highlights'] as $hl ) : ?>
								<span><?php echo esc_html( $hl ); ?></span>
							<?php endforeach; ?>
							</div>
						</div>
						<?php endif; ?>
					</div>

					<!-- Booking Form Sidebar -->
					<aside id="tour-booking" class="destination-page-sidebar">
						<div class="destination-form-card">
							<span class="destination-form-card__eyebrow">Reserva este tour</span>
							<h2><?php echo esc_html( $tour['title'] ); ?></h2>
							<p style="margin-bottom:1.2rem;">Completa tus datos y te contactamos por WhatsApp para confirmar disponibilidad.</p>
							<form id="mt-tour-booking-form" class="destination-request-grid" novalidate>
								<input type="hidden" name="action" value="me_transfers_tour_booking">
								<input type="hidden" name="security" value="">
								<input type="hidden" name="tour_name" value="<?php echo esc_attr( $tour['title'] ); ?>">
								<div style="position:absolute;left:-9999px;" aria-hidden="true"><input type="text" name="mt_website" tabindex="-1" autocomplete="off"></div>
								<div class="destination-request-field"><label for="tb-name">Nombre completo *</label><input type="text" id="tb-name" name="name" required placeholder="Tu nombre"></div>
								<div class="destination-request-field"><label for="tb-country">Pais</label><input type="text" id="tb-country" name="country" placeholder="Ej: Espana, Colombia..."></div>
								<div class="destination-request-field"><label for="tb-phone">Telefono *</label><input type="tel" id="tb-phone" name="phone" required placeholder="+34 600 000 000"></div>
								<div class="destination-request-field"><label for="tb-email">Correo electronico *</label><input type="email" id="tb-email" name="email" required placeholder="tu@email.com"></div>
								<div class="destination-request-field"><label for="tb-date">Fecha del tour</label><input type="date" id="tb-date" name="tour_date"></div>
								<div class="destination-request-field destination-request-field--full" style="padding-top:0.5rem;">
									<button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;gap:0.5rem;">
										<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2 22l4.832-1.438A9.955 9.955 0 0 0 12 22c5.523 0 10-4.477 10-10S17.523 2 12 2z"/></svg>
										Reservar por WhatsApp
									</button>
								</div>
							</form>
							<div id="mt-tour-booking-msg" style="display:none;margin-top:1rem;padding:1rem;border-radius:12px;text-align:center;font-weight:600;"></div>
							<p style="text-align:center;font-size:0.78rem;color:var(--text-muted);margin-top:1rem;">Tu informacion se guarda de forma segura.</p>
						</div>
					</aside>
				</div>
			</section>

			<!-- Benefits -->
			<section class="destination-benefits-section">
				<div class="container">
					<div class="destination-benefits-grid">
						<article class="destination-benefit-card"><div class="destination-benefit-icon" aria-hidden="true"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41 11 3.83a2 2 0 0 0-1.41-.58H4a2 2 0 0 0-2 2v5.59a2 2 0 0 0 .58 1.41L12.17 22a2 2 0 0 0 2.83 0l5.59-5.59a2 2 0 0 0 0-2.83Z"/><path d="M7 7h.01"/></svg></div><h2>Precios Cerrados</h2><p>Paga lo que contratas, sin recargos sorpresivos.</p></article>
						<article class="destination-benefit-card"><div class="destination-benefit-icon" aria-hidden="true"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="14" height="14" rx="2"/><path d="M7 2v4M13 2v4M3 10h14"/><circle cx="19" cy="17" r="4"/><path d="M19 15v2l1.5 1.5"/></svg></div><h2>Cancelacion Flexible</h2><p>Cancelacion gratuita hasta 24 horas antes del tour.</p></article>
						<article class="destination-benefit-card"><div class="destination-benefit-icon" aria-hidden="true"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg></div><h2>Tour 100% Privado</h2><p>Sin otros grupos. Solo tu con chofer privado y vehiculo Mercedes.</p></article>
						<article class="destination-benefit-card"><div class="destination-benefit-icon" aria-hidden="true"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.62 2h3A2 2 0 0 1 8.6 3.72c.12.92.34 1.82.67 2.69a2 2 0 0 1-.45 2.11L7.73 9.61a16 16 0 0 0 6.66 6.66l1.09-1.09a2 2 0 0 1 2.11-.45c.87.33 1.77.55 2.69.67A2 2 0 0 1 22 16.92z"/></svg></div><h2>Soporte 24/7</h2><p>Atencion por telefono, email o WhatsApp las 24 horas.</p></article>
					</div>
				</div>
			</section>

			<!-- Other Tours -->
			<?php if ( $other_tours ) : ?>
			<section class="destination-other-section">
				<div class="container">
					<div class="destination-other-header">
						<h2>Otros tours disponibles</h2>
						<a href="<?php echo esc_url( home_url( '/#tours' ) ); ?>" class="destination-other-link">Ver todos los tours</a>
					</div>
					<div class="destination-other-grid">
						<?php foreach ( $other_tours as $ot ) : ?>
							<a href="<?php echo esc_url( me_transfers_get_tour_url( $ot['slug'] ) ); ?>" class="destination-other-card">
								<span class="destination-other-card__title"><?php echo esc_html( $ot['title'] ); ?></span>
								<span class="destination-other-card__link"><?php echo esc_html( $ot['price'] ); ?></span>
							</a>
						<?php endforeach; ?>
					</div>
				</div>
			</section>
			<?php endif; ?>

			<script>
			(function(){
				var form = document.getElementById('mt-tour-booking-form');
				if (!form) return;
				var nf = form.querySelector('input[name="security"]');
				if (nf && typeof meTransfers !== 'undefined') nf.value = meTransfers.tourBookingNonce;
				form.addEventListener('submit', function(e) {
					e.preventDefault();
					var btn = form.querySelector('button[type="submit"]');
					var msg = document.getElementById('mt-tour-booking-msg');
					var orig = btn.innerHTML;
					var n = form.querySelector('[name="name"]').value.trim();
					var p = form.querySelector('[name="phone"]').value.trim();
					var em = form.querySelector('[name="email"]').value.trim();
					if (!n||!p||!em) { msg.style.display='block'; msg.style.background='rgba(220,38,38,0.08)'; msg.style.color='#991b1b'; msg.textContent='Por favor, completa los campos obligatorios.'; return; }
					btn.disabled=true; btn.textContent='Enviando...';
					fetch(meTransfers.ajaxUrl,{method:'POST',body:new FormData(form)})
					.then(function(r){return r.json()})
					.then(function(res){
						msg.style.display='block';
						if(res.success){msg.style.background='rgba(22,163,74,0.08)';msg.style.color='#166534';msg.textContent=res.data.message;form.reset();if(res.data.whatsapp_url)setTimeout(function(){window.open(res.data.whatsapp_url,'_blank')},800);}
						else{msg.style.background='rgba(220,38,38,0.08)';msg.style.color='#991b1b';msg.textContent=res.data&&res.data.message?res.data.message:'Error al enviar.';}
						btn.disabled=false;btn.innerHTML=orig;
					}).catch(function(){msg.style.display='block';msg.style.background='rgba(220,38,38,0.08)';msg.style.color='#991b1b';msg.textContent='Error de conexion.';btn.disabled=false;btn.innerHTML=orig;});
				});
			})();
			</script>
			<?php		elseif ( $service = me_transfers_get_current_service( $current_post ) ) :
			?>
			<section class="banner-section page-banner" style="background: linear-gradient(135deg, #050d21 0%, #03143a 100%);">
				<div class="container banner-content gs-reveal-up" style="text-align: left;">
					<h1 class="text-gradient page-banner-title" style="margin-bottom: 0.5rem;"><?php echo esc_html( $service['title'] ); ?></h1>
					<p style="margin: 0; color: rgba(255,255,255,0.7); max-width: 600px; font-size: 1.1rem; line-height: 1.6;"><?php echo esc_html( $service['desc'] ); ?></p>
				</div>
			</section>

			<section class="page-content-wrapper section bg-dark" style="background: var(--bg-dark); padding-top: 4rem;">
				<div class="container">
					<div class="service-detail-grid" style="display: grid; grid-template-columns: 1fr 380px; gap: 3rem; align-items: start;">
						
						<!-- Left Column: Image and Description -->
						<article class="service-main-content">

							
							<div class="luxury-prose" style="font-size: 1.15rem; line-height: 1.8; color: var(--text-on-dark-2);">
								<h2 style="color: #ffffff; margin-bottom: 1.25rem;">Sobre el Servicio</h2>
								<?php
								$content_to_show = apply_filters( 'the_content', $current_post->post_content );
								if ( ! empty( trim( $current_post->post_content ) ) ) {
									echo $content_to_show;
								} else {
									echo '<p>' . esc_html( $service['full_desc'] ) . '</p>';
								}
								?>
								<?php if ( ! empty( $service['features'] ) ) : ?>
								<h3 style="color: #ffffff; margin-top: 3rem; margin-bottom: 1.25rem;">CaracterÃ­sticas Destacadas</h3>
								<ul style="list-style: none; padding: 0; margin: 0; display: grid; gap: 1rem;">
									<?php foreach ( $service['features'] as $feature ) : ?>
									<li style="display: flex; align-items: flex-start; gap: 0.75rem; color: #ffffff !important;">
										<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0; margin-top:0.2rem;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
										<span style="color: #ffffff !important;"><?php echo esc_html( $feature ); ?></span>
									</li>
									<?php endforeach; ?>
								</ul>
								<?php endif; ?>
							</div>
						</article>

						<!-- Right Column: Sidebar -->
						<aside class="service-sidebar" style="position: sticky; top: 100px;">
							<div class="service-sidebar-card" style="background: rgba(4, 16, 45, 0.6); border: 1px solid rgba(255,255,255,0.08); border-radius: 24px; padding: 2.5rem; box-shadow: 0 15px 35px rgba(0,0,0,0.2);">
								
								<div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.1);">
									<img src="<?php echo esc_url( $service['icon'] ); ?>" alt="Icono" width="48" height="48" style="filter: drop-shadow(0 2px 8px rgba(0,0,0,0.5));">
									<h3 style="margin: 0; font-size: 1.4rem; color: #fff;">Resumen</h3>
								</div>

								<h4 style="font-size: 1.1rem; color: #fff; margin-bottom: 1rem;">Â¿QuÃ© incluye?</h4>
								<ul style="list-style: none; padding: 0; margin: 0 0 2.5rem 0; display: grid; gap: 0.85rem; color: var(--text-on-dark-2); font-size: 0.95rem;">
									<?php foreach ( $service['bullets'] as $b ) : ?>
										<li style="display: flex; align-items: center; gap: 0.5rem;">
											<span style="width:6px; height:6px; border-radius:50%; background:var(--accent-blue); display:inline-block;"></span>
											<?php echo esc_html( $b ); ?>
										</li>
									<?php endforeach; ?>
								</ul>

								<?php $wa_text = urlencode('Hola, quiero informaciÃ³n sobre el servicio de ' . $service['title']); ?>
								<a href="https://wa.me/34662024136?text=<?php echo esc_attr( $wa_text ); ?>" target="_blank" rel="noopener" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 1.1rem;">Reservar Servicio <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-left: 0.5rem;"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
								
								<p style="text-align: center; font-size: 0.8rem; color: rgba(255,255,255,0.4); margin: 1rem 0 0 0;">ConfirmaciÃ³n inmediata. Pago seguro.</p>
							</div>
						</aside>

					</div>
					
					<!-- Responsive fix inside the template -->
					<style>
					@media (max-width: 992px) {
						.service-detail-grid { grid-template-columns: 1fr !important; }
						.service-sidebar { position: static !important; margin-top: 2rem; }
					}
					</style>
				</div>
			</section>
			<?php
		else :
			?>
			<section class="banner-section page-banner">
				<div class="container banner-content gs-reveal-up">
					<?php the_title( '<h1 class="text-gradient page-banner-title">', '</h1>' ); ?>
				</div>
			</section>

			<?php
			$booking_page_slugs = array( 'seleccionar-vehiculo', 'reservas-metransfers', 'finalizar-pago' );
			$is_booking_page    = is_page( $booking_page_slugs );
			?>
			<section class="page-content-wrapper section<?php echo $is_booking_page ? ' page-content-wrapper--booking' : ''; ?>">
				<div class="container <?php echo $is_booking_page ? 'page-content-shell-booking' : 'page-content-shell'; ?>">
					<?php the_content(); ?>
				</div>
			</section>
			<?php
		endif;
	endwhile;
	?>
</main>

<?php get_footer(); ?>
