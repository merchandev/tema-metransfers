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
			'desc'       => 'Seguimiento de vuelo VIP, recibimiento con cartel y espera de cortesía en la terminal. Tu chófer experto te estará esperando en el Aeropuerto de Barcelona (El Prat).',
			'icon'       => get_template_directory_uri() . '/assets/icons/service-airport-transfer.svg',
			'image'      => 'https://images.unsplash.com/photo-1549303698-500e2b3db5d2?q=80&w=1200&auto=format&fit=crop',
			'full_desc'  => 'Comience o termine su viaje con la máxima tranquilidad. Nuestro servicio de traslado al aeropuerto está diseñado para cumplir con los estándares más altos de puntualidad y exclusividad. Monitoreamos su vuelo en tiempo real para adaptar la recogida en caso de retrasos o adelantos. A su llegada, un chófer uniformado le recibirá en la zona de llegadas con un cartel a su nombre o el de su empresa, asistiéndole inmediatamente con su equipaje y acompañándole a uno de nuestros vehículos premium estacionados a pie de terminal.',
			'features'   => array( 'Seguimiento inteligente de vuelos', 'Meet & Greet en zona de llegadas', 'Vehículos Mercedes Benz (Clase E, Clase V, Clase S)', 'Conductores uniformados, discretos y bilingües' ),
			'bullets'    => array( 'Monitoreo de Vuelo', 'Meet & Greet', '60 minutos de espera gratuita' ),
		),
		'tours-privados' => array(
			'title'      => 'Tours Extraordinarios',
			'slug'       => 'tours-privados',
			'desc'       => 'Viaja por Cataluña en confort total. Montserrat, Costa Brava, Celler de Can Roca y más destinos en vehículos de lujo con conductores profesionales.',
			'icon'       => get_template_directory_uri() . '/assets/icons/service-private-tours.svg',
			'image'      => 'https://images.unsplash.com/photo-1583422409516-2895a77efded?q=80&w=1200&auto=format&fit=crop',
			'full_desc'  => 'Convierta cada viaje en una experiencia inolvidable. Nuestros tours privados son mucho más que un simple traslado; son una ventana a la belleza oculta de Cataluña. Conducidos por verdaderos embajadores locales, podrá explorar el misterio geológico de Montserrat, conducir bordeando los acantilados celestes de la Costa Brava o sumergirse en la historia judía y romana medieval en la ciudad de Girona. Diseñamos, coordinamos y operamos excursiones a la medida de sus intereses y tiempo disponible, liberándole de la ansiedad organizativa.',
			'features'   => array( 'Rutas flexibles decididas por usted', 'Asesoría local en la ruta', 'Disponibilidad desde medio día (4h) hasta días completos (12h)', 'Servicio Premium y discreción total' ),
			'bullets'    => array( 'Rutas Personalizadas', 'Vehículos de Lujo', 'Chófer local experto' ),
		),
		'corporativo-y-eventos' => array(
			'title'      => 'Corporativo y Eventos',
			'slug'       => 'corporativo-y-eventos',
			'desc'       => 'Disposición por horas, logística para congresos (MWC, ISE) y viajes ejecutivos por carretera a Madrid, Valencia y más, asegurando máxima confidencialidad.',
			'icon'       => get_template_directory_uri() . '/assets/icons/service-corporate-events.svg',
			'image'      => 'https://images.unsplash.com/photo-1554200876-56c2f25224fa?q=80&w=1200&auto=format&fit=crop',
			'full_desc'  => 'Eficiencia, discreción e impecable representación corporativa. Entendemos las exigencias de ejecutivos, diplomáticos y participantes de congresos C-Level. Ya sea que necesite disponer de un vehículo durante 10 horas seguidas para reuniones ininterrumpidas en el corazón financiero de Barcelona, coordinar traslados sincronizados para 50 delegados VIP en el Mobile World Congress, o un transporte largo seguro e inmediato hacia ciudades conectadas como Madrid, Zaragoza o Valencia, aportamos calma logística a su agenda más apretada.',
			'features'   => array( 'Coordinación logística pre-evento dedicada', 'Flota negra idéntica de última generación', 'Agua, Wi-Fi de cortesía a bordo', 'Facturación internacional y contratos' ),
			'bullets'    => array( 'Disposición por horas', 'Choferes bilingües', 'Facturación unificada' ),
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
