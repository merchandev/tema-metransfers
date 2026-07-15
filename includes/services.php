<?php
/**
 * Services Management Logic
 *
 * @package Me_Transfers
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns the catalog of available services.
 *
 * @return array
 */
function me_transfers_get_service_catalog() {
	return array(
		'traslados-aeropuerto' => array(
			'title'      => 'Traslados Aeropuerto',
			'slug'       => 'traslados-aeropuerto',
			'desc'       => 'Seguimiento de vuelo VIP, recibimiento con cartel y espera de cortesÃ­a en la terminal. Tu chÃ³fer experto te estarÃ¡ esperando en el Aeropuerto de Barcelona (El Prat).',
			'icon'       => get_template_directory_uri() . '/assets/icons/service-airport-transfer.svg',
			'image'      => 'https://images.unsplash.com/photo-1549303698-500e2b3db5d2?q=80&w=1200&auto=format&fit=crop',
			'full_desc'  => 'Comience o termine su viaje con la mÃ¡xima tranquilidad. Nuestro servicio de traslado al aeropuerto estÃ¡ diseÃ±ado para cumplir con los estÃ¡ndares mÃ¡s altos de puntualidad y exclusividad. Monitoreamos su vuelo en tiempo real para adaptar la recogida en caso de retrasos o adelantos. A su llegada, un chÃ³fer uniformado le recibirÃ¡ en la zona de llegadas con un cartel a su nombre o el de su empresa, asistiÃ©ndole inmediatamente con su equipaje y acompaÃ±Ã¡ndole a uno de nuestros vehÃ­culos premium estacionados a pie de terminal.',
			'features'   => array( 'Seguimiento inteligente de vuelos', 'Meet & Greet en zona de llegadas', 'VehÃ­culos Mercedes Benz (Clase E, Clase V, Clase S)', 'Conductores uniformados, discretos y bilingÃ¼es' ),
			'bullets'    => array( 'Monitoreo de Vuelo', 'Meet & Greet', '60 minutos de espera gratuita' ),
		),
		'tours-privados' => array(
			'title'      => 'Tours Extraordinarios',
			'slug'       => 'tours-privados',
			'desc'       => 'Viaja por CataluÃ±a en confort total. Montserrat, Costa Brava, Celler de Can Roca y mÃ¡s destinos en vehÃ­culos de lujo con conductores profesionales.',
			'icon'       => get_template_directory_uri() . '/assets/icons/service-private-tours.svg',
			'image'      => 'https://images.unsplash.com/photo-1583422409516-2895a77efded?q=80&w=1200&auto=format&fit=crop',
			'full_desc'  => 'Convierta cada viaje en una experiencia inolvidable. Nuestros tours privados son mucho mÃ¡s que un simple traslado; son una ventana a la belleza oculta de CataluÃ±a. Conducidos por verdaderos embajadores locales, podrÃ¡ explorar el misterio geolÃ³gico de Montserrat, conducir bordeando los acantilados celestes de la Costa Brava o sumergirse en la historia judÃ­a y romana medieval en la ciudad de Girona. DiseÃ±amos, coordinamos y operamos excursiones a la medida de sus intereses y tiempo disponible, liberÃ¡ndole de la ansiedad organizativa.',
			'features'   => array( 'Rutas flexibles decididas por usted', 'AsesorÃ­a local en la ruta', 'Disponibilidad desde medio dÃ­a (4h) hasta dÃ­as completos (12h)', 'Servicio Premium y discreciÃ³n total' ),
			'bullets'    => array( 'Rutas Personalizadas', 'VehÃ­culos de Lujo', 'ChÃ³fer local experto' ),
		),
		'corporativo-y-eventos' => array(
			'title'      => 'Corporativo y Eventos',
			'slug'       => 'corporativo-y-eventos',
			'desc'       => 'DisposiciÃ³n por horas, logÃ­stica para congresos (MWC, ISE) y viajes ejecutivos por carretera a Madrid, Valencia y mÃ¡s, asegurando mÃ¡xima confidencialidad.',
			'icon'       => get_template_directory_uri() . '/assets/icons/service-corporate-events.svg',
			'image'      => 'https://images.unsplash.com/photo-1554200876-56c2f25224fa?q=80&w=1200&auto=format&fit=crop',
			'full_desc'  => 'Eficiencia, discreciÃ³n e impecable representaciÃ³n corporativa. Entendemos las exigencias de ejecutivos, diplomÃ¡ticos y participantes de congresos C-Level. Ya sea que necesite disponer de un vehÃ­culo durante 10 horas seguidas para reuniones ininterrumpidas en el corazÃ³n financiero de Barcelona, coordinar traslados sincronizados para 50 delegados VIP en el Mobile World Congress, o un transporte largo seguro e inmediato hacia ciudades conectadas como Madrid, Zaragoza o Valencia, aportamos calma logÃ­stica a su agenda mÃ¡s apretada.',
			'features'   => array( 'CoordinaciÃ³n logÃ­stica pre-evento dedicada', 'Flota negra idÃ©ntica de Ãºltima generaciÃ³n', 'Agua, Wi-Fi de cortesÃ­a a bordo', 'FacturaciÃ³n internacional y contratos' ),
			'bullets'    => array( 'DisposiciÃ³n por horas', 'Choferes bilingÃ¼es', 'FacturaciÃ³n unificada' ),
		),
	);
}

/**
 * Returns the URL for a specific service.
 *
 * @param string $slug The service slug.
 * @return string
 */
function me_transfers_get_service_url( $slug ) {
	$page = get_page_by_path( $slug, OBJECT, 'page' );
	if ( $page instanceof WP_Post ) {
		return get_permalink( $page->ID );
	}
	return home_url( '/' . $slug );
}

/**
 * Checks if the current post is one of our dynamic services.
 *
 * @param WP_Post|null $post The post object.
 * @return array|false The service data array if it is a service, false otherwise.
 */
function me_transfers_get_current_service( $post = null ) {
	if ( ! $post ) {
		global $post;
	}
	if ( ! $post || 'page' !== $post->post_type ) {
		return false;
	}

	$catalog = me_transfers_get_service_catalog();
	if ( isset( $catalog[ $post->post_name ] ) ) {
		return $catalog[ $post->post_name ];
	}

	return false;
}

/**
 * Ensures all service pages exist in the WordPress database.
 * If they don't, it creates them.
 */
function me_transfers_sync_service_pages() {
	$catalog = me_transfers_get_service_catalog();

	foreach ( $catalog as $slug => $service ) {
		$page = get_page_by_path( $slug );
		if ( ! $page ) {
			wp_insert_post( array(
				'post_title'     => $service['title'],
				'post_name'      => $slug,
				'post_content'   => '',
				'post_status'    => 'publish',
				'post_type'      => 'page',
				'ping_status'    => 'closed',
				'comment_status' => 'closed',
			) );
		}
	}
}
add_action( 'after_switch_theme', 'me_transfers_sync_service_pages' );
add_action( 'admin_init', 'me_transfers_sync_service_pages' );
add_action( 'init', 'me_transfers_sync_service_pages', 20 ); // Also on init to ensure they exist for guests proxying through admin-initialized state
