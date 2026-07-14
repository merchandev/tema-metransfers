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
					<span class="destinations-hub-eyebrow"><?php esc_html_e( 'Destinos más solicitados', 'me-transfers' ); ?></span>
					<h1 class="destinations-hub-title"><?php esc_html_e( 'Destinos', 'me-transfers' ); ?></h1>
					<p class="destinations-hub-intro">
						<?php
						if ( $hub_content_plain ) {
							echo esc_html( $hub_content_plain );
						} else {
							esc_html_e( 'Explora los destinos más solicitados y accede a una ficha rápida para pedir información de traslados privados, recogidas en aeropuerto, hoteles, puertos y rutas personalizadas.', 'me-transfers' );
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
									<?php esc_html_e( 'Solicitar información', 'me-transfers' ); ?>
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
						Encuentra respuestas claras y rápidas a las dudas más comunes sobre nuestros servicios de transporte privado. Desde reservas y tarifas hasta detalles sobre nuestras rutas y vehículos, aquí encontrarás toda la información que necesitas para planificar tu traslado con metransfers.es. ¿Tienes más preguntas frecuentes? Contáctanos y estaremos encantados de ayudarte.
					</p>
				</div>
			</section>

			<section class="faq-page-section section">
				<div class="container faq-page-shell">
					<div class="faq-page-intro">
						<h2>Todo lo que necesitas saber antes de reservar</h2>
						<p>Hemos reunido las consultas más habituales sobre reservas, vehículos, aeropuertos, pagos, cancelaciones y atención al cliente para que encuentres la información de forma rápida y ordenada.</p>
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
												Puedes acceder a nuestra política de cancelación completa <a href="<?php echo esc_url( $cancellation_url ); ?>">haciendo clic aquí</a>.
											<?php else : ?>
												Puedes consultar nuestra política de cancelación completa contactando con nuestro equipo.
											<?php endif; ?>
										</p>
									<?php endif; ?>

									<?php if ( 10 === $index && $privacy_url ) : ?>
										<p>Puedes acceder a nuestra política de privacidad completa <a href="<?php echo esc_url( $privacy_url ); ?>">haciendo clic aquí</a>.</p>
									<?php endif; ?>
								</div>
							</details>
						<?php endforeach; ?>
					</div>

					<div class="faq-page-cta">
						<span class="faq-page-cta__kicker">Reserva Ahora</span>
						<h2>Reserva online, rápido y con pago seguro</h2>
						<p>metransfers.es es una de las principales agencias de transporte privado en Barcelona. Reserva online, rápido y con pago seguro. Ofrecemos alquiler de coches con conductor, visitas guiadas y servicio de chofer 24/7.</p>
						<a href="<?php echo esc_url( me_transfers_get_section_url( 'search' ) ); ?>" class="btn btn-primary">Reservar ahora</a>
					</div>
				</div>
			</section>
			<?php
		elseif ( is_page( array( 'privacidad', 'politica-de-privacidad', 'politicas-de-privacidad', 'privacy-policy' ) ) ) :
			?>
			<section class="banner-section page-banner">
				<div class="container banner-content gs-reveal-up">
					<h1 class="text-gradient page-banner-title">Pol&iacute;ticas de privacidad</h1>
					<p><strong>METRANSFERS GESTION SL</strong> &middot; &Uacute;ltima revisi&oacute;n: 13 de enero de 2026</p>
				</div>
			</section>

			<section class="page-content-wrapper section">
				<div class="container page-content-shell">
					<div class="entry-content luxury-prose">
						<?php
						$content_to_show = apply_filters( 'the_content', $current_post->post_content );
						if ( ! empty( trim( $current_post->post_content ) ) ) {
							echo $content_to_show;
						} else {
						?>
						<p>En cumplimiento del Reglamento (UE) 2016/679 (RGPD) y la Ley Org&aacute;nica 3/2018 (LOPDGDD), se informa a los usuarios que la navegaci&oacute;n por este sitio web y, especialmente, la configuraci&oacute;n y formalizaci&oacute;n de cualquier reserva, implica la aceptaci&oacute;n expresa de la presente Pol&iacute;tica de Privacidad y de nuestros T&eacute;rminos y Condiciones de Uso.</p>

						<h2>1. Identificaci&oacute;n del Responsable del Tratamiento</h2>
						<p><strong>Raz&oacute;n Social:</strong> METRANSFERS GESTION SL</p>
						<p><strong>NIF:</strong> B22522353</p>
						<p><strong>Domicilio Fiscal:</strong> AVDA MARE DE DEU DE MONTSERRAT, NUM 18, PLANTA 5, PUERTA 2, 08970 SANT JOAN DESP&Iacute; &ndash; (BARCELONA)</p>
						<p><strong>Contacto Privacidad:</strong> <a href="mailto:info@metransfers.es">info@metransfers.es</a></p>

						<h2>2. Aceptaci&oacute;n Vinculante</h2>
						<p>Al utilizar nuestros servicios, navegar por nuestra plataforma o completar el proceso de configuraci&oacute;n de una reserva, usted reconoce haber le&iacute;do, comprendido y aceptado sin reservas que sus datos personales sean tratados conforme a los t&eacute;rminos aqu&iacute; expuestos. La formalizaci&oacute;n de una reserva constituye un contrato entre las partes, legitimando el tratamiento de los datos necesarios para la ejecuci&oacute;n del servicio.</p>

						<h2>3. Datos Objeto de Tratamiento</h2>
						<p>Recopilamos los datos estrictamente necesarios para la prestaci&oacute;n del servicio:</p>
						<ul>
							<li><strong>Datos de Reserva:</strong> Nombre, apellidos, tel&eacute;fono, correo electr&oacute;nico y detalles del trayecto/servicio solicitado.</li>
							<li><strong>Datos de Facturaci&oacute;n:</strong> Direcci&oacute;n postal y NIF/DNI (seg&uacute;n los datos de registro fiscal de la entidad).</li>
							<li><strong>Datos de Navegaci&oacute;n:</strong> Direcci&oacute;n IP, cookies y metadatos para garantizar la seguridad del sitio.</li>
						</ul>

						<h2>4. Finalidad del Tratamiento</h2>
						<p>Sus datos ser&aacute;n tratados con el fin de:</p>
						<ul>
							<li><strong>Gesti&oacute;n de Reservas:</strong> Tramitar, confirmar y ejecutar los servicios de transporte o gesti&oacute;n contratados.</li>
							<li><strong>Atenci&oacute;n al Cliente:</strong> Resolver dudas y proporcionar soporte a trav&eacute;s del punto &uacute;nico de contacto <a href="mailto:info@metransfers.es">info@metransfers.es</a>.</li>
							<li><strong>Cumplimiento Legal:</strong> Emitir facturas y cumplir con las obligaciones tributarias ante la AEAT.</li>
							<li><strong>Seguridad:</strong> Prevenir fraudes y usos no autorizados de la plataforma.</li>
						</ul>

						<h2>5. Legitimaci&oacute;n</h2>
						<p>La base legal para el tratamiento es:</p>
						<ul>
							<li><strong>Ejecuci&oacute;n Contractual:</strong> Necesaria para procesar su reserva y prestarle el servicio solicitado.</li>
							<li><strong>Obligaci&oacute;n Legal:</strong> Derivada de la normativa fiscal y mercantil vigente en Espa&ntilde;a.</li>
							<li><strong>Consentimiento:</strong> Otorgado expl&iacute;citamente al marcar la casilla de aceptaci&oacute;n en nuestros formularios.</li>
						</ul>

						<h2>6. Conservaci&oacute;n y Destinatarios</h2>
						<p><strong>Plazos:</strong> Los datos se conservar&aacute;n durante el tiempo que dure la relaci&oacute;n comercial y, posteriormente, durante los plazos legales de prescripci&oacute;n (generalmente 6 a&ntilde;os para documentos contables seg&uacute;n el C&oacute;digo de Comercio).</p>
						<p><strong>Cesiones:</strong> No se ceder&aacute;n datos a terceros ajenos a la operativa del servicio, salvo obligaci&oacute;n legal ante autoridades competentes.</p>

						<h2>7. Derechos del Interesado</h2>
						<p>Usted puede ejercer sus derechos de Acceso, Rectificaci&oacute;n, Supresi&oacute;n, Limitaci&oacute;n, Portabilidad y Oposici&oacute;n enviando una comunicaci&oacute;n escrita acompa&ntilde;ada de copia de su DNI a: <a href="mailto:info@metransfers.es">info@metransfers.es</a>.</p>
						<p>Asimismo, tiene derecho a retirar su consentimiento en cualquier momento y a presentar una reclamaci&oacute;n ante la Agencia Espa&ntilde;ola de Protecci&oacute;n de Datos (AEPD) si considera que sus derechos han sido vulnerados.</p>
						<?php } ?>
					</div>
				</div>
			</section>
			<?php
		elseif ( is_page( array( 'cookie', 'cookies', 'politica-de-cookies', 'cookie-policy' ) ) ) :
			?>
			<section class="banner-section page-banner">
				<div class="container banner-content gs-reveal-up">
					<h1 class="text-gradient page-banner-title">Pol&iacute;tica de Cookies</h1>
					<p><strong>METRANSFERS GESTION SL</strong> &middot; &Uacute;ltima actualizaci&oacute;n: 8 de abril de 2026</p>
				</div>
			</section>

			<section class="page-content-wrapper section">
				<div class="container page-content-shell">
					<div class="entry-content luxury-prose">
						<?php
						$content_to_show = apply_filters( 'the_content', $current_post->post_content );
						if ( ! empty( trim( $current_post->post_content ) ) ) {
							echo $content_to_show;
						} else {
						?>
						<p>La presente Pol&iacute;tica de Cookies explica c&oacute;mo utiliza metransfers.es los dispositivos de almacenamiento y recuperaci&oacute;n de datos en equipos terminales de los usuarios, de conformidad con el art&iacute;culo 22.2 de la Ley 34/2002, de Servicios de la Sociedad de la Informaci&oacute;n y de Comercio Electr&oacute;nico (LSSI-CE), el Reglamento (UE) 2016/679 (RGPD) y los criterios publicados por la Agencia Espa&ntilde;ola de Protecci&oacute;n de Datos (AEPD).</p>

						<h2>1. Responsable del sitio web</h2>
						<p><strong>Raz&oacute;n social:</strong> METRANSFERS GESTION SL</p>
						<p><strong>NIF:</strong> B22522353</p>
						<p><strong>Domicilio:</strong> AVDA MARE DE DEU DE MONTSERRAT, NUM 18, PLANTA 5, PUERTA 2, 08970 SANT JOAN DESP&Iacute; (BARCELONA)</p>
						<p><strong>Correo electr&oacute;nico:</strong> <a href="mailto:info@metransfers.es">info@metransfers.es</a></p>

						<h2>2. Qu&eacute; son las cookies</h2>
						<p>Las cookies son peque&ntilde;os archivos que se descargan en su dispositivo al acceder a determinadas p&aacute;ginas web. Permiten, entre otras cosas, reconocer su navegador, mantener la sesi&oacute;n, recordar preferencias, reforzar la seguridad o facilitar determinadas funcionalidades t&eacute;cnicas del sitio.</p>

						<h2>3. Tipos de cookies</h2>
						<p>Las cookies pueden clasificarse, entre otros criterios, del siguiente modo:</p>
						<ul>
							<li><strong>Seg&uacute;n la entidad que las gestione:</strong> cookies propias y cookies de terceros.</li>
							<li><strong>Seg&uacute;n su finalidad:</strong> cookies t&eacute;cnicas o necesarias, de preferencias o personalizaci&oacute;n, de an&aacute;lisis, y de publicidad o publicidad comportamental.</li>
							<li><strong>Seg&uacute;n el tiempo que permanecen activas:</strong> cookies de sesi&oacute;n y cookies persistentes.</li>
						</ul>

						<h2>4. Cookies utilizadas en metransfers.es</h2>
						<p>Con car&aacute;cter general, este sitio utiliza o puede utilizar cookies t&eacute;cnicas, de sesi&oacute;n y de preferencia estrictamente relacionadas con el funcionamiento de la web y la prestaci&oacute;n del servicio solicitado por el usuario. Entre ellas se incluyen, cuando proceda:</p>
						<ul>
							<li><strong>Cookies t&eacute;cnicas de navegaci&oacute;n y seguridad:</strong> necesarias para cargar la web, proteger formularios, prevenir usos abusivos y garantizar el funcionamiento b&aacute;sico del sitio.</li>
							<li><strong>Cookies asociadas al proceso de reserva o contacto:</strong> necesarias para gestionar solicitudes enviadas por el usuario, mantener datos temporales de sesi&oacute;n y completar procesos esenciales vinculados al servicio contratado.</li>
							<li><strong>Cookies de preferencias:</strong> destinadas a recordar opciones expresamente solicitadas por el usuario, como el idioma o determinadas configuraciones de visualizaci&oacute;n, cuando estas funcionalidades est&eacute;n habilitadas.</li>
							<li><strong>Cookies t&eacute;cnicas de terceros vinculadas al servicio:</strong> determinados proveedores externos integrados en la web, como herramientas de traducci&oacute;n, mapas, contenidos embebidos o pasarelas de pago seguras, pueden instalar sus propias cookies cuando el usuario interact&uacute;a con dichas funcionalidades.</li>
						</ul>
						<p>Este tema no instala por s&iacute; mismo cookies de publicidad comportamental. Si en el futuro se incorporan herramientas anal&iacute;ticas no exentas, servicios de personalizaci&oacute;n avanzada o soluciones publicitarias que requieran consentimiento, se informar&aacute; al usuario de forma previa y se recabar&aacute; la autorizaci&oacute;n correspondiente antes de su activaci&oacute;n.</p>

						<h2>5. Base jur&iacute;dica</h2>
						<p>Las cookies t&eacute;cnicas o estrictamente necesarias pueden utilizarse sin consentimiento previo cuando resultan imprescindibles para prestar el servicio solicitado por el usuario o para posibilitar la navegaci&oacute;n segura por el sitio web. Las cookies no necesarias solo podr&aacute;n utilizarse cuando exista una base jur&iacute;dica adecuada y, en los casos exigidos por la normativa, tras obtener el consentimiento informado del usuario.</p>

						<h2>6. Plazo de conservaci&oacute;n</h2>
						<p>Las cookies de sesi&oacute;n permanecen activas &uacute;nicamente mientras el usuario navega por el sitio y se eliminan al cerrar el navegador. Las cookies persistentes, cuando existan, se conservar&aacute;n durante el tiempo estrictamente necesario para cumplir su finalidad o hasta que el usuario las elimine manualmente desde la configuraci&oacute;n de su navegador o del servicio correspondiente.</p>

						<h2>7. Gesti&oacute;n, configuraci&oacute;n y desactivaci&oacute;n</h2>
						<p>El usuario puede permitir, bloquear o eliminar las cookies instaladas en su dispositivo mediante la configuraci&oacute;n de su navegador. Debe tener en cuenta que la desactivaci&oacute;n de cookies t&eacute;cnicas o necesarias puede afectar al correcto funcionamiento del sitio, del proceso de reserva o de determinadas funcionalidades esenciales.</p>
						<ul>
							<li><a href="https://support.google.com/chrome/answer/95647?hl=es" target="_blank" rel="noopener">Configurar cookies en Google Chrome</a></li>
							<li><a href="https://support.mozilla.org/es/kb/proteccion-antirrastreo-mejorada-firefox-escritorio" target="_blank" rel="noopener">Configurar cookies en Mozilla Firefox</a></li>
							<li><a href="https://support.apple.com/es-es/guide/safari/sfri11471/mac" target="_blank" rel="noopener">Configurar cookies en Safari</a></li>
							<li><a href="https://support.microsoft.com/es-es/microsoft-edge/administrar-cookies-en-microsoft-edge-ver-permitir-bloquear-eliminar-y-usar-168dab11-0753-043d-7c16-ede5947fc64d" target="_blank" rel="noopener">Configurar cookies en Microsoft Edge</a></li>
						</ul>

						<h2>8. Cookies de terceros</h2>
						<p>La aceptaci&oacute;n, configuraci&oacute;n y uso de cookies de terceros se rige por las pol&iacute;ticas propias de dichos proveedores. METRANSFERS GESTION SL no puede controlar en todo momento las actualizaciones que esos terceros realicen en sus pol&iacute;ticas, por lo que se recomienda al usuario revisar directamente sus condiciones cuando interact&uacute;e con herramientas externas integradas o enlazadas desde la web.</p>

						<h2>9. Informaci&oacute;n adicional y contacto</h2>
						<p>Para obtener m&aacute;s informaci&oacute;n sobre el tratamiento de datos personales, puede consultar nuestra <a href="<?php echo esc_url( home_url( '/privacidad' ) ); ?>">Pol&iacute;tica de Privacidad</a>. Si necesita aclaraciones sobre el uso de cookies en este sitio web, puede escribir a <a href="mailto:info@metransfers.es">info@metransfers.es</a>.</p>
						<p>La presente Pol&iacute;tica de Cookies podr&aacute; actualizarse cuando se produzcan cambios normativos, t&eacute;cnicos o funcionales en el sitio web. Se recomienda revisarla peri&oacute;dicamente.</p>
						<?php } ?>
					</div>
				</div>
			</section>
			<?php
		elseif ( is_page( array( 'terminos-y-condiciones', 'terminos-condiciones', 'terminos-y-condiciones-regulan-la-contratacion', 'terms-and-conditions' ) ) ) :
			?>
			<section class="banner-section page-banner">
				<div class="container banner-content gs-reveal-up">
					<h1 class="text-gradient page-banner-title">T&eacute;rminos y Condiciones regulan la contrataci&oacute;n</h1>
					<p>&Uacute;ltima actualizaci&oacute;n: 16 de enero de 2026</p>
				</div>
			</section>

			<section class="page-content-wrapper section">
				<div class="container page-content-shell">
					<div class="entry-content luxury-prose">
						<?php
						$content_to_show = apply_filters( 'the_content', $current_post->post_content );
						if ( ! empty( trim( $current_post->post_content ) ) ) {
							echo $content_to_show;
						} else {
						?>
						<p>El presente documento establece las condiciones contractuales que rigen la relaci&oacute;n entre METRANSFERS GESTION SL (en adelante, &ldquo;EL PRESTADOR&rdquo;) y los usuarios que contraten servicios de transporte a trav&eacute;s del sitio web oficial. La contrataci&oacute;n de cualquier servicio implica la adhesi&oacute;n plena y sin reservas a todas y cada una de las condiciones aqu&iacute; expuestas.</p>

						<h2>1. MARCO LEGAL APLICABLE</h2>
						<p>El presente contrato se rige por lo dispuesto en la legislaci&oacute;n espa&ntilde;ola vigente, espec&iacute;ficamente:</p>
						<ul>
							<li>Ley 16/1987, de 30 de julio, de Ordenaci&oacute;n de los Transportes Terrestres (LOTT) y su Reglamento (ROTT).</li>
							<li>Ley 34/2002 (LSSI-CE) sobre servicios de la sociedad de la informaci&oacute;n.</li>
							<li>Real Decreto Legislativo 1/2007, por el que se aprueba el texto refundido de la Ley General para la Defensa de los Consumidores y Usuarios.</li>
							<li>Reglamento (UE) 2016/679 (RGPD) en materia de protecci&oacute;n de datos.</li>
						</ul>

						<h2>2. IDENTIFICACI&Oacute;N DE LAS PARTES</h2>
						<p><strong>El Prestador:</strong> METRANSFERS GESTION SL, con NIF B22522353 y domicilio social en AVDA MARE DE DEU DE MONTSERRAT, NUM 18, PLANTA 5, PUERTA 2, 08970 SANT JOAN DESP&Iacute; (BARCELONA).</p>
						<p><strong>El Cliente:</strong> Persona f&iacute;sica o jur&iacute;dica que formaliza la reserva y garantiza tener capacidad legal para contratar.</p>

						<h2>3. OBLIGACI&Oacute;N DE NOTIFICACI&Oacute;N Y REQUISITOS DEL SERVICIO</h2>
						<p>Para garantizar la seguridad y legalidad del transporte, el Cliente tiene la obligaci&oacute;n inexcusable de declarar las siguientes necesidades en el formulario de reserva:</p>
						<h3>3.1. Sistemas de Retenci&oacute;n Infantil (SRI)</h3>
						<p>Conforme al Art&iacute;culo 117 del Reglamento General de Circulaci&oacute;n, es obligatorio el uso de sillas homologadas para menores de estatura igual o inferior a 135 cm. El Cliente debe seleccionar el n&uacute;mero y tipo de sillas necesarias en el formulario. La omisi&oacute;n de este dato facultar&aacute; al conductor a denegar el servicio por razones de seguridad, sin derecho a reembolso.</p>
						<h3>3.2. Equipaje Extraordinario</h3>
						<p>La capacidad del veh&iacute;culo est&aacute; limitada por su ficha t&eacute;cnica. El transporte de maletas adicionales, material deportivo (golf, esqu&iacute;) o bultos voluminosos debe ser notificado. EL PRESTADOR se reserva el derecho de cobrar suplementos o denegar el transporte si el volumen excede la capacidad del maletero del veh&iacute;culo contratado.</p>
						<h3>3.3. Transporte de Mascotas</h3>
						<p>El transporte de animales dom&eacute;sticos est&aacute; sujeto a notificaci&oacute;n previa y debe realizarse en trasportines homologados proporcionados por el cliente, salvo acuerdo en contrario. Los perros gu&iacute;a viajar&aacute;n sin coste adicional conforme a la normativa vigente.</p>

						<h2>4. PASARELA DE PAGO Y SEGURIDAD (REDSYS)</h2>
						<p>El pago de los servicios se efectuar&aacute; mediante tarjeta de cr&eacute;dito o d&eacute;bito a trav&eacute;s de la pasarela de pago segura Redsys.</p>
						<ul>
							<li><strong>Seguridad:</strong> El sistema utiliza protocolos de encriptaci&oacute;n SSL y autenticaci&oacute;n 3D Secure (Verified by Visa / Mastercard ID Check).</li>
							<li><strong>Confirmaci&oacute;n:</strong> El contrato se perfecciona en el momento en que EL PRESTADOR recibe la confirmaci&oacute;n de la autorizaci&oacute;n de pago por parte de la entidad bancaria.</li>
							<li><strong>Fraude:</strong> EL PRESTADOR se reserva el derecho de anular cualquier transacci&oacute;n ante sospechas de uso fraudulento de tarjetas.</li>
						</ul>

						<h2>5. DERECHO DE DESISTIMIENTO Y POL&Iacute;TICA DE CANCELACI&Oacute;N</h2>
						<p>En virtud del Art&iacute;culo 103 l) del Real Decreto Legislativo 1/2007, el derecho de desistimiento no ser&aacute; aplicable a los servicios de transporte de pasajeros si el contrato prev&eacute; una fecha o un periodo de ejecuci&oacute;n espec&iacute;ficos. No obstante, EL PRESTADOR ofrece las siguientes condiciones comerciales:</p>
						<ul>
							<li><strong>Cancelaci&oacute;n con &gt;24 horas:</strong> Devoluci&oacute;n del 100% del importe mediante el mismo sistema de pago (Redsys).</li>
							<li><strong>Cancelaci&oacute;n con &lt;24 horas o No-Show:</strong> Penalizaci&oacute;n del 100% del valor de la reserva.</li>
							<li><strong>Retrasos de vuelos:</strong> EL PRESTADOR monitoriza los vuelos. No obstante, si el retraso excede los 90 minutos sobre la hora prevista, el servicio quedar&aacute; sujeto a disponibilidad de flota, pudiendo incurrir en gastos de espera adicionales.</li>
						</ul>

						<h2>6. RESPONSABILIDAD LIMITADA</h2>
						<p>EL PRESTADOR no ser&aacute; responsable por incumplimientos derivados de:</p>
						<ul>
							<li>Fuerza mayor o causas fortuitas (cortes de carretera, condiciones clim&aacute;ticas adversas, huelgas generales).</li>
							<li>Errores en los datos facilitados por el cliente en el formulario de reserva (ej. fecha err&oacute;nea o n&uacute;mero de tel&eacute;fono incorrecto).</li>
							<li>Incumplimiento de las normas de seguridad por parte de los pasajeros (uso de cintur&oacute;n, comportamiento disruptivo).</li>
						</ul>

						<h2>7. JURISDICCI&Oacute;N Y LEY APLICABLE</h2>
						<p>Para la resoluci&oacute;n de cualquier litigio derivado de la interpretaci&oacute;n o ejecuci&oacute;n de este contrato, las partes se someten a la legislaci&oacute;n espa&ntilde;ola. En caso de controversia, se recurrir&aacute; a los Juzgados y Tribunales de Barcelona, salvo que el cliente ostente la condici&oacute;n de consumidor, en cuyo caso se atender&aacute; a la competencia territorial establecida por ley.</p>
						<?php } ?>
					</div>
				</div>
			</section>
			<?php
		elseif ( is_page( array( 'aviso-legal', 'legal-notice' ) ) ) :
			?>
			<section class="banner-section page-banner">
				<div class="container banner-content gs-reveal-up">
					<h1 class="text-gradient page-banner-title">Aviso Legal</h1>
				</div>
			</section>

			<section class="page-content-wrapper section">
				<div class="container page-content-shell">
					<div class="entry-content luxury-prose">
						<?php
						$content_to_show = apply_filters( 'the_content', $current_post->post_content );
						if ( ! empty( trim( $current_post->post_content ) ) ) {
							echo $content_to_show;
						} else {
						?>
						<h2>1. INFORMACI&Oacute;N IDENTIFICATIVA</h2>
						<p>En cumplimiento con el deber de informaci&oacute;n recogido en el art&iacute;culo 10 de la Ley 34/2002, de 11 de julio, de Servicios de la Sociedad de la Informaci&oacute;n y del Comercio Electr&oacute;nico (LSSI-CE), a continuaci&oacute;n se reflejan los siguientes datos:</p>
						<p><strong>Titular del sitio web:</strong> METRANSFERS GESTION SL</p>
						<p><strong>NIF:</strong> B22522353</p>
						<p><strong>Domicilio Social:</strong> AVDA MARE DE DEU DE MONTSERRAT, NUM 18, PLANTA 5, PUERTA 2, 08970 SANT JOAN DESP&Iacute; &ndash; (BARCELONA)</p>
						<p><strong>Correo electr&oacute;nico de contacto:</strong> <a href="mailto:info@metransfers.es">info@metransfers.es</a></p>
						<p><strong>Actividad:</strong> Transporte de viajeros y gesti&oacute;n de servicios tur&iacute;sticos.</p>

						<h2>2. CONDICIONES DE USO</h2>
						<p>El acceso y/o uso de este portal atribuye la condici&oacute;n de USUARIO, que acepta, desde dicho acceso y/o uso, las Condiciones Generales de Uso aqu&iacute; reflejadas.</p>
						<p>El sitio web proporciona acceso a informaciones, servicios o datos (en adelante, &ldquo;los contenidos&rdquo;) en Internet pertenecientes a METRANSFERS GESTION SL. El USUARIO asume la responsabilidad del uso del portal. Dicha responsabilidad se extiende al registro que fuese necesario para acceder a determinados servicios o contenidos (como el formulario de reservas).</p>

						<h2>3. PROPIEDAD INTELECTUAL E INDUSTRIAL</h2>
						<p>METRANSFERS GESTION SL es titular de todos los derechos de propiedad intelectual e industrial de su p&aacute;gina web, as&iacute; como de los elementos contenidos en la misma (a t&iacute;tulo enunciativo: im&aacute;genes, sonido, audio, v&iacute;deo, software o textos; marcas o logotipos, combinaciones de colores, estructura y dise&ntilde;o, selecci&oacute;n de materiales usados, programas de ordenador necesarios para su funcionamiento, acceso y uso, etc.).</p>
						<p>En virtud de lo dispuesto en los art&iacute;culos 8 y 32.1, p&aacute;rrafo segundo, de la Ley de Propiedad Intelectual, quedan expresamente prohibidas la reproducci&oacute;n, la distribuci&oacute;n y la comunicaci&oacute;n p&uacute;blica, incluida su modalidad de puesta a disposici&oacute;n, de la totalidad o parte de los contenidos de esta p&aacute;gina web, con fines comerciales, en cualquier soporte y por cualquier medio t&eacute;cnico, sin la autorizaci&oacute;n de METRANSFERS GESTION SL.</p>

						<h2>4. EXCLUSI&Oacute;N DE GARANT&Iacute;AS Y RESPONSABILIDAD</h2>
						<p>EL PRESTADOR no se hace responsable, en ning&uacute;n caso, de los da&ntilde;os y perjuicios de cualquier naturaleza que pudieran ocasionar, a t&iacute;tulo enunciativo: errores u omisiones en los contenidos, falta de disponibilidad del portal o la transmisi&oacute;n de virus o programas maliciosos o lesivos en los contenidos, a pesar de haber adoptado todas las medidas tecnol&oacute;gicas necesarias para evitarlo.</p>

						<h2>5. MODIFICACIONES</h2>
						<p>METRANSFERS GESTION SL se reserva el derecho de efectuar sin previo aviso las modificaciones que considere oportunas en su portal, pudiendo cambiar, suprimir o a&ntilde;adir tanto los contenidos y servicios que se presten a trav&eacute;s de la misma como la forma en la que &eacute;stos aparezcan presentados o localizados en su portal.</p>

						<h2>6. ENLACES (LINKS)</h2>
						<p>En el caso de que en el sitio web se dispusiesen enlaces o hiperv&iacute;nculos hac&iacute;a otros sitios de Internet, METRANSFERS GESTION SL no ejercer&aacute; ning&uacute;n tipo de control sobre dichos sitios y contenidos. En ning&uacute;n caso asumir&aacute; responsabilidad alguna por los contenidos de alg&uacute;n enlace perteneciente a un sitio web ajeno.</p>

						<h2>7. DERECHO DE EXCLUSI&Oacute;N</h2>
						<p>METRANSFERS GESTION SL se reserva el derecho a denegar o retirar el acceso al portal y/o los servicios ofrecidos sin necesidad de preaviso, a instancia propia o de un tercero, a aquellos usuarios que incumplan las presentes Condiciones Generales de Uso.</p>

						<h2>8. PROTECCI&Oacute;N DE DATOS</h2>
						<p>Todo lo relativo a la pol&iacute;tica de protecci&oacute;n de datos se encuentra recogido en el documento de Pol&iacute;tica de Privacidad de la entidad, conforme al Reglamento (UE) 2016/679 (RGPD) y la Ley Org&aacute;nica 3/2018 (LOPDGDD).</p>

						<h2>9. LEGISLACI&Oacute;N APLICABLE Y JURISDICCI&Oacute;N</h2>
						<p>La relaci&oacute;n entre METRANSFERS GESTION SL y el USUARIO se regir&aacute; por la normativa espa&ntilde;ola vigente y cualquier controversia se someter&aacute; a los Juzgados y Tribunales de la ciudad de Barcelona.</p>
						<?php } ?>
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
						<span><?php esc_html_e( 'Chófer profesional', 'me-transfers' ); ?></span>
						<span><?php esc_html_e( 'Respuesta rápida', 'me-transfers' ); ?></span>
					</div>
				</div>
			</section>

			<section class="destination-page-section section">
				<div class="container destination-page-layout">
					<div class="destination-page-copy">
						<div class="destination-copy-card">
							<h2><?php echo esc_html( sprintf( __( 'Información para traslados a %s', 'me-transfers' ), $current_destination['title'] ) ); ?></h2>

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
												__( 'Si estás organizando un traslado hacia %s, podemos prepararte una propuesta adaptada al punto de recogida, número de pasajeros, fecha estimada y tipo de servicio que necesites.', 'me-transfers' ),
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
							<h2><?php echo esc_html( sprintf( __( 'Pide información para %s', 'me-transfers' ), $current_destination['title'] ) ); ?></h2>
							<p><?php esc_html_e( 'Cuéntanos origen, fechas y necesidades del servicio. Te responderemos con disponibilidad y propuesta personalizada.', 'me-transfers' ); ?></p>
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
							<p>Metransfers Barcelona ofrece una cancelación gratuita hasta 24 horas antes de su actividad, siempre hay espacio para un cambio de planes.</p>
						</article>

						<article class="destination-benefit-card destination-benefit-card--support">
							<div class="destination-benefit-icon" aria-hidden="true">
								<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
									<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.62 2h3A2 2 0 0 1 8.6 3.72c.12.92.34 1.82.67 2.69a2 2 0 0 1-.45 2.11L7.73 9.61a16 16 0 0 0 6.66 6.66l1.09-1.09a2 2 0 0 1 2.11-.45c.87.33 1.77.55 2.69.67A2 2 0 0 1 22 16.92z"/>
									<path d="M15 7a5 5 0 0 1 5 5"/>
									<path d="M15 3a9 9 0 0 1 9 9"/>
								</svg>
							</div>
							<h2>Soporte Telefónico 24 Horas</h2>
							<p>Servicio 24/7 para que tu experiencia sea inolvidable, ya sea por teléfono, email o WhatsApp.</p>
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
								<h3 style="color: #ffffff; margin-top: 3rem; margin-bottom: 1.25rem;">Características Destacadas</h3>
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

								<h4 style="font-size: 1.1rem; color: #fff; margin-bottom: 1rem;">¿Qué incluye?</h4>
								<ul style="list-style: none; padding: 0; margin: 0 0 2.5rem 0; display: grid; gap: 0.85rem; color: var(--text-on-dark-2); font-size: 0.95rem;">
									<?php foreach ( $service['bullets'] as $b ) : ?>
										<li style="display: flex; align-items: center; gap: 0.5rem;">
											<span style="width:6px; height:6px; border-radius:50%; background:var(--accent-blue); display:inline-block;"></span>
											<?php echo esc_html( $b ); ?>
										</li>
									<?php endforeach; ?>
								</ul>

								<?php $wa_text = urlencode('Hola, quiero información sobre el servicio de ' . $service['title']); ?>
								<a href="https://wa.me/34662024136?text=<?php echo esc_attr( $wa_text ); ?>" target="_blank" rel="noopener" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 1.1rem;">Reservar Servicio <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-left: 0.5rem;"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
								
								<p style="text-align: center; font-size: 0.8rem; color: rgba(255,255,255,0.4); margin: 1rem 0 0 0;">Confirmación inmediata. Pago seguro.</p>
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
