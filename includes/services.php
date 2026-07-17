<?php
/**
 * Services Catalog — MeTransfers
 * Catálogo completo de los 6 servicios, con textos, beneficios y datos del formulario.
 *
 * @package Me_Transfers
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns the full catalog of available services.
 *
 * @return array
 */
function me_transfers_get_service_catalog() {
	return array(

		// ─── 1. TRASLADOS AL AEROPUERTO ─────────────────────────────────────────────
		'traslados-aeropuerto' => array(
			'title'       => 'Traslados al Aeropuerto Barcelona',
			'subtitle'    => 'Tu vuelo llega, nosotros ya estamos allí',
			'slug'        => 'traslados-aeropuerto',
			'badge'       => 'Aeropuerto El Prat · 24/7',
			'hero_desc'   => 'Recogida privada con seguimiento de vuelo en tiempo real, bienvenida con cartel y hasta 60 minutos de espera de cortesía. Sin estrés, sin sorpresas.',
			'desc_long'   => 'Llegar o salir de Barcelona nunca fue tan sencillo. En MeTransfers monitoreamos tu vuelo en tiempo real para que tu conductor esté exactamente donde necesitas, cuando lo necesitas — sin importar retrasos o adelantos de última hora.

A tu llegada al Aeropuerto Barcelona-El Prat, un chófer uniformado y bilingüe te recibirá en la zona de llegadas con un cartel personalizado con tu nombre o el de tu empresa. Te asistirá con el equipaje y te acompañará directamente a tu vehículo Mercedes estacionado a pie de terminal. El trayecto al hotel, oficina o destino final se convierte en el primer momento de descanso tras el vuelo.

Si vas al aeropuerto, calculamos el tiempo de salida con margen suficiente para que llegues tranquilo, sin carreras y con energía para tu viaje.',
			'features'    => array(
				array( 'icon' => 'flight', 'title' => 'Seguimiento de Vuelo', 'desc' => 'Monitoreamos tu vuelo en tiempo real. Si hay retrasos, tu conductor espera.' ),
				array( 'icon' => 'receipt_long', 'title' => 'Meet & Greet', 'desc' => 'Cartel personalizado en zona de llegadas. Bienvenida profesional y puntual.' ),
				array( 'icon' => 'schedule', 'title' => '60 min de espera', 'desc' => 'Incluimos hasta 60 minutos de espera gratuita en llegadas internacionales.' ),
				array( 'icon' => 'luggage', 'title' => 'Ayuda con el equipaje', 'desc' => 'Tu chófer te asiste con las maletas desde la terminal hasta el vehículo.' ),
				array( 'icon' => 'directions_car', 'title' => 'Flota Mercedes Premium', 'desc' => 'Viaja en ECONOMIC CLASS, MINI VAN «V» Class, BUSINESS CLASS o MINI VAN ECONOMIC según tus necesidades.' ),
				array( 'icon' => 'lock', 'title' => 'Precio cerrado', 'desc' => 'Sin tarifas sorpresa. El precio que ves es el precio que pagas.' ),
			),
			'steps'       => array(
				array( 'n' => '01', 'title' => 'Solicita tu traslado', 'desc' => 'Rellena el formulario con tu número de vuelo, fecha y punto de recogida o destino.' ),
				array( 'n' => '02', 'title' => 'Confirmación en minutos', 'desc' => 'Recibirás confirmación de reserva con los datos completos del servicio y del conductor.' ),
				array( 'n' => '03', 'title' => 'Tu chófer en el aeropuerto', 'desc' => 'El día del servicio, tu conductor monitoriza el vuelo y te espera con cartel en la terminal.' ),
				array( 'n' => '04', 'title' => 'Viaje premium a tu destino', 'desc' => 'Sube, relájate y disfruta del trayecto en total confort hasta donde necesites.' ),
			),
			'form_type'   => 'aeropuerto',
			'cta_text'    => 'Reservar ahora',
		),

		// ─── 2. TRASLADOS AL PUERTO ──────────────────────────────────────────────────
		'traslados-puerto' => array(
			'title'       => 'Traslados al Puerto de Barcelona',
			'subtitle'    => 'Inicia o termina tu crucero sin contratiempos',
			'slug'        => 'traslados-puerto',
			'badge'       => 'Puerto de Barcelona · Cruceros y ferries',
			'hero_desc'   => 'Conectamos el aeropuerto, tu hotel o cualquier dirección con las terminales del Puerto de Barcelona. Coordinación puntual de la recogida y asistencia con el equipaje.',
			'desc_long'   => 'El Puerto de Barcelona es una de las terminales de cruceros más activas del Mediterráneo. Embarcar o desembarcar con el equipaje de una semana de viaje puede ser estresante — a menos que tengas un servicio privado de confianza.

Operamos en todas las terminales activas de cruceros y ferris del Port de Barcelona. Indícanos el barco o la terminal y confirmaremos el punto exacto de recogida. Nos anticipamos al tráfico y a los tiempos de embarque para que llegues con margen suficiente y sin prisas.

Si llegas de un crucero, tu chófer te espera en el punto de salida de la terminal con tu nombre en el cartel. Si llegas en ferri desde las islas, coordinamos la recogida con la hora de atraque. El traslado al hotel, aeropuerto u otro destino es tranquilo, cómodo y con espacio para todo tu equipaje.',
			'features'    => array(
				array( 'icon' => 'directions_boat', 'title' => 'Todas las terminales', 'desc' => 'Operamos en todas las terminales activas del Port de Barcelona.' ),
				array( 'icon' => 'luggage', 'title' => 'Espacio para equipaje extra', 'desc' => 'Maletas de crucero, trolleys grandes y bolsas extra. La MINI VAN «V» Class lo lleva todo.' ),
				array( 'icon' => 'alarm', 'title' => 'Sincronización con atraque', 'desc' => 'Controlamos el horario de llegada del barco para ajustar la recogida.' ),
				array( 'icon' => 'hotel', 'title' => 'Hotel · Puerto · Aeropuerto', 'desc' => 'Cualquier combinación: hotel al puerto, aeropuerto al puerto y viceversa.' ),
				array( 'icon' => 'verified', 'title' => 'Sin colas ni taxis', 'desc' => 'Evita filas de taxi y transporte público con maletas. Tu coche privado, siempre listo.' ),
				array( 'icon' => 'forum', 'title' => 'Atención multilingüe', 'desc' => 'Chóferes que hablan español, inglés y más. Perfectos para cruceristas internacionales.' ),
			),
			'steps'       => array(
				array( 'n' => '01', 'title' => 'Envía tu solicitud', 'desc' => 'Indícanos el nombre del barco o número de crucero, terminal y fecha de llegada o salida.' ),
				array( 'n' => '02', 'title' => 'Confirmamos el servicio', 'desc' => 'Te enviamos confirmación con todos los detalles: conductor, vehículo y punto de encuentro.' ),
				array( 'n' => '03', 'title' => 'Tu chófer en el punto exacto', 'desc' => 'El conductor monitoriza el atraque y te espera en la terminal correcta, puntual.' ),
				array( 'n' => '04', 'title' => 'Traslado directo a tu destino', 'desc' => 'Con todo el equipaje cargado, viaja cómodo hasta el hotel, aeropuerto o la ciudad.' ),
			),
			'form_type'   => 'puerto',
			'cta_text'    => 'Reservar ahora',
		),

		// ─── 3. CHÓFER PRIVADO POR HORAS ────────────────────────────────────────────
		'chofer-por-horas' => array(
			'title'       => 'Chófer Privado por Horas en Barcelona',
			'subtitle'    => 'Tu conductor exclusivo, donde lo necesites',
			'slug'        => 'chofer-por-horas',
			'badge'       => 'Disposición por horas · Mínimo 3h',
			'hero_desc'   => 'Dispón de un vehículo Mercedes con conductor durante el tiempo que necesites. Ideal para reuniones, compras, visitas o días completos con múltiples paradas.',
			'desc_long'   => 'A veces no necesitas ir de A a B — necesitas un conductor que te espere, te lleve a varios sitios y esté disponible durante horas para todo lo que surja. Para eso está nuestro servicio de chófer privado por horas.

Imagina una mañana de reuniones en el 22@ de Barcelona, una parada a comer en el Eixample y después al aeropuerto. O una tarde de compras en Passeig de Gràcia con el coche esperando. O una noche de evento con cenas y traslados entre locales. Con el servicio por disposición, tú marcas el ritmo.

El conductor permanece a tu disposición exclusiva durante el tiempo contratado. Tú decides las paradas, los cambios de plan y los tiempos. Mínimo 3 horas, sin límite máximo. Disponible en toda el área metropolitana de Barcelona y rutas de larga distancia.',
			'features'    => array(
				array( 'icon' => 'schedule', 'title' => 'Flexibilidad total', 'desc' => 'Cambios de plan en tiempo real. El conductor se adapta a tu agenda, no al revés.' ),
				array( 'icon' => 'location_on', 'title' => 'Múltiples paradas', 'desc' => 'Reuniones, compras, restaurantes, eventos — todas las paradas que necesites.' ),
				array( 'icon' => 'lock', 'title' => 'Exclusividad garantizada', 'desc' => 'El vehículo y el conductor son exclusivamente tuyos durante todo el tiempo contratado.' ),
				array( 'icon' => 'wifi', 'title' => 'Wi-Fi y agua a bordo', 'desc' => 'Trabaja, descansa o prepara tus reuniones durante los trayectos con total comodidad.' ),
				array( 'icon' => 'map', 'title' => 'Toda el área metropolitana', 'desc' => 'Barcelona ciudad, costa, interior y rutas largas a Madrid, Valencia o Andorra.' ),
				array( 'icon' => 'dark_mode', 'title' => 'Disponible 24/7', 'desc' => 'Madrugadas, días festivos, eventos nocturnos. Siempre disponible cuando lo necesites.' ),
			),
			'steps'       => array(
				array( 'n' => '01', 'title' => 'Dinos cuántas horas necesitas', 'desc' => 'Indica fecha, hora de inicio, punto de recogida y descripción general del plan.' ),
				array( 'n' => '02', 'title' => 'Te enviamos presupuesto', 'desc' => 'Precio cerrado por el número de horas. Sin sorpresas al finalizar el servicio.' ),
				array( 'n' => '03', 'title' => 'El conductor llega puntual', 'desc' => 'Tu chófer aparece en el lugar acordado, vehículo preparado y listo para comenzar.' ),
				array( 'n' => '04', 'title' => 'Tú mandas, él conduce', 'desc' => 'Indica destinos, paradas y cambios sobre la marcha. Tú llevas el ritmo del día.' ),
			),
			'form_type'   => 'horas',
			'cta_text'    => 'Reservar ahora',
		),

		// ─── 4. CORPORATIVO Y EVENTOS ────────────────────────────────────────────────
		'corporativo-y-eventos' => array(
			'title'       => 'Transporte Corporativo y Eventos en Barcelona',
			'subtitle'    => 'Logística impecable para empresas y grandes eventos',
			'slug'        => 'corporativo-y-eventos',
			'badge'       => 'MWC · ISE · Congresos · Empresas',
			'hero_desc'   => 'Coordinamos la movilidad de directivos, delegaciones y equipos para congresos, ferias y eventos privados. Flota uniforme, facturación centralizada y máxima discreción.',
			'desc_long'   => 'Cuando la movilidad de tu empresa o evento debe funcionar sin fisuras, MeTransfers aporta la tranquilidad logística que los equipos necesitan. Tenemos experiencia coordinando traslados durante congresos como MWC, ISE y otras grandes ferias de Barcelona.

Ponemos a tu disposición una flota de vehículos Mercedes de última generación — todos del mismo modelo y color — para garantizar una imagen uniforme y profesional. Nuestros conductores son discretos, puntuales, bilingües y con experiencia en protocolos corporativos.

Tanto si necesitas coordinar 3 traslados ejecutivos como 50 delegados en rotación durante una feria de 4 días, gestionamos la logística completa: horarios, puntos de recogida, rutas, esperas y cambios de última hora. Facturación unificada al final del evento.',
			'features'    => array(
				array( 'icon' => 'business', 'title' => 'Gestión logística completa', 'desc' => 'Coordinador dedicado para eventos multi-vehículo. Un punto de contacto para todo.' ),
				array( 'icon' => 'directions_car', 'title' => 'Flota uniforme', 'desc' => 'Todos los vehículos del mismo modelo y acabado. Imagen de marca coherente y premium.' ),
				array( 'icon' => 'language', 'title' => 'Conductores bilingües', 'desc' => 'Español, inglés y más idiomas. Perfectos para delegaciones internacionales.' ),
				array( 'icon' => 'receipt_long', 'title' => 'Facturación centralizada', 'desc' => 'Una sola factura al final del evento. Compatible con contabilidad de empresa.' ),
				array( 'icon' => 'phone_iphone', 'title' => 'Coordinación en tiempo real', 'desc' => 'Cambios de última hora gestionados al instante vía WhatsApp o coordinador dedicado.' ),
				array( 'icon' => 'lock', 'title' => 'Máxima confidencialidad', 'desc' => 'Discreción absoluta con directivos, VIPs y delegaciones de alto nivel.' ),
			),
			'steps'       => array(
				array( 'n' => '01', 'title' => 'Cuéntanos el evento', 'desc' => 'Envíanos el tipo de evento, número de personas, fechas y necesidades específicas.' ),
				array( 'n' => '02', 'title' => 'Propuesta personalizada', 'desc' => 'Preparamos un plan logístico y presupuesto adaptado a tu evento en menos de 24h.' ),
				array( 'n' => '03', 'title' => 'Coordinación pre-evento', 'desc' => 'Ajustamos horarios, rutas y asignaciones de vehículos. Todo confirmado con antelación.' ),
				array( 'n' => '04', 'title' => 'Ejecución impecable', 'desc' => 'El día del evento, todo funciona. Factura única y resumen del servicio al finalizar.' ),
			),
			'form_type'   => 'corporativo',
			'cta_text'    => 'Solicitar presupuesto',
		),

		// ─── 5. TOURS PRIVADOS ───────────────────────────────────────────────────────
		'tours-privados' => array(
			'title'       => 'Tours Privados desde Barcelona',
			'subtitle'    => 'Cataluña a tu ritmo, en vehículo de lujo',
			'slug'        => 'tours-privados',
			'badge'       => 'Montserrat · Costa Brava · Girona · Andorra',
			'hero_desc'   => 'Explora Cataluña en exclusiva con un chófer guía local. Desde medio día hasta rutas completas. Sin horarios de grupo, sin esperas, sin límites.',
			'desc_long'   => 'Un tour privado con MeTransfers es una experiencia completamente diferente al turismo convencional. Sin autobuses llenos, sin horarios de grupo y sin paradas que no quieres hacer. Diseñamos cada excursión a medida de tus intereses, tiempo y ritmo.

Nuestros conductores son embajadores locales que conocen los rincones que los tours masivos nunca muestran. En Montserrat, el momento para bajar a las grutas tranquilas cuando los grupos ya se han ido. En la Costa Brava, la cala escondida que no sale en los folletos. En Girona, el callejón de la época medieval que te transporta siglos atrás.

Desde Barcelona, operamos excursiones de medio día (4 horas), día completo (8 horas) y rutas de varios días. Los destinos más populares incluyen Montserrat, Costa Brava, Girona, Figueres (Dalí), Tarragona, Sitges y Andorra. También diseñamos rutas temáticas: gastronomía, vinos, arquitectura modernista o paisajes naturales.',
			'features'    => array(
				array( 'icon' => 'map', 'title' => 'Rutas 100% personalizadas', 'desc' => 'Tú decides los destinos, paradas, tiempos y ritmo. Nosotros lo coordinamos todo.' ),
				array( 'icon' => 'explore', 'title' => 'Chófer-guía local', 'desc' => 'Conocimiento local profundo: historia, gastronomía, secretos que no están en las guías.' ),
				array( 'icon' => 'directions_car', 'title' => 'Sin grupos', 'desc' => 'Solo tú, tu familia o tus invitados. Privacidad y exclusividad absoluta en cada parada.' ),
				array( 'icon' => 'schedule', 'title' => 'Desde 4 hasta 12 horas', 'desc' => 'Medio día, día completo o rutas extendidas. El tiempo que necesites, sin restricciones.' ),
				array( 'icon' => 'wine_bar', 'title' => 'Tours temáticos', 'desc' => 'Gastronomía, vinos, arquitectura, naturaleza, historia. Diseñamos la ruta perfecta.' ),
				array( 'icon' => 'public', 'title' => 'Multilingüe', 'desc' => 'Servicio disponible en español, inglés y otros idiomas. Ideal para visitantes internacionales.' ),
			),
			'steps'       => array(
				array( 'n' => '01', 'title' => 'Elige tu destino y fecha', 'desc' => 'Cuéntanos qué quieres ver, cuántas personas sois y en qué fecha.' ),
				array( 'n' => '02', 'title' => 'Diseñamos tu ruta', 'desc' => 'Preparamos un itinerario personalizado con sugerencias de paradas y tiempos estimados.' ),
				array( 'n' => '03', 'title' => 'Recogida en tu hotel', 'desc' => 'Tu conductor te recoge en el lobby de tu hotel o alojamiento a la hora acordada.' ),
				array( 'n' => '04', 'title' => 'Explora sin límites', 'desc' => 'Vive Cataluña a tu ritmo. Paradas cuando quieras, retorno a la hora que prefieras.' ),
			),
			'form_type'   => 'tours',
			'cta_text'    => 'Reservar ahora',
		),

		// ─── 6. GRUPOS Y CELEBRACIONES ──────────────────────────────────────────────
		'grupos' => array(
			'title'       => 'Transporte para Grupos en Barcelona',
			'subtitle'    => 'Movilidad coordinada para grupos, bodas y celebraciones',
			'slug'        => 'grupos',
			'badge'       => 'Bodas · Despedidas · Grupos Privados',
			'hero_desc'   => 'Coordinamos el transporte de grupos desde 8 hasta 50+ personas. Bodas, despedidas, incentivos, excursiones de empresa y celebraciones especiales en vehículos premium.',
			'desc_long'   => 'Organizar el transporte de un grupo es un reto logístico que MeTransfers convierte en un proceso sin estrés. Ya sea una boda de 80 invitados entre la iglesia, el hotel y la masía; una despedida de soltero con 15 personas entre varios locales de Barcelona; o un incentivo de empresa de 40 personas desde el aeropuerto al resort — lo coordinamos todo con precisión.

Disponemos de vehículos para grupos de todos los tamaños: desde la MINI VAN «V» Class (7 plazas) hasta múltiples unidades coordinadas para grupos grandes. Todos los coches llegan al mismo tiempo, los conductores están sincronizados y tú tienes un solo punto de contacto para gestionar cualquier incidencia o cambio.

Para bodas, ofrecemos decoración del vehículo, bebidas de bienvenida y coordinación con el wedding planner. Para incentivos de empresa, gestionamos logística de varios días con facturación unificada.',
			'features'    => array(
				array( 'icon' => 'groups', 'title' => 'De 8 a 50+ personas', 'desc' => 'Escalamos el número de vehículos según el tamaño de tu grupo. Sin límite.' ),
				array( 'icon' => 'favorite', 'title' => 'Especialistas en bodas', 'desc' => 'Decoración del coche nupcial, coordinación con fotógrafo y wedding planner.' ),
				array( 'icon' => 'celebration', 'title' => 'Celebraciones y despedidas', 'desc' => 'Despedidas de soltero, cumpleaños, aniversarios. Tu noche perfecta empieza en el coche.' ),
				array( 'icon' => 'sync', 'title' => 'Flota sincronizada', 'desc' => 'Todos los vehículos coordinados. Llegada simultánea, salida coordinada, sin caos.' ),
				array( 'icon' => 'support_agent', 'title' => 'Un solo coordinador', 'desc' => 'Un punto de contacto directo para gestionar cambios, adiciones y ajustes de último minuto.' ),
				array( 'icon' => 'auto_awesome', 'title' => 'Servicios extras', 'desc' => 'Champán, agua, flores, letreros personalizados. Hacemos del trayecto parte del evento.' ),
			),
			'steps'       => array(
				array( 'n' => '01', 'title' => 'Cuéntanos el evento', 'desc' => 'Número de personas, tipo de evento, fecha y rutas necesarias.' ),
				array( 'n' => '02', 'title' => 'Propuesta de flota y precio', 'desc' => 'Te enviamos el número de vehículos recomendados y presupuesto detallado.' ),
				array( 'n' => '03', 'title' => 'Coordinación previa', 'desc' => 'Confirmamos horarios, rutas y extras contratados. Coordinador asignado al evento.' ),
				array( 'n' => '04', 'title' => 'Tu evento, en movimiento', 'desc' => 'El día del evento, todos los vehículos sincronizados. Tú disfrutas, nosotros coordinamos.' ),
			),
			'form_type'   => 'grupos',
			'cta_text'    => 'Solicitar presupuesto',
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
 * Detects if the current page matches a service in the catalog.
 *
 * @param WP_Post|null $post The post object.
 * @return array|false The service data array, or false.
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
 * Ensures all service pages exist in WordPress.
 * Called on theme activation or manually.
 */
function me_transfers_sync_service_pages() {
	$catalog       = me_transfers_get_service_catalog();
	$template_slug = 'template-servicio.php';

	foreach ( $catalog as $slug => $service ) {
		$page    = get_page_by_path( $slug );
		$trashed = get_page_by_path( $slug . '__trashed' );

		if ( ! $page && ! $trashed ) {
			$page_id = wp_insert_post( array(
				'post_title'     => $service['title'],
				'post_name'      => $slug,
				'post_content'   => '',
				'post_status'    => 'publish',
				'post_type'      => 'page',
				'ping_status'    => 'closed',
				'comment_status' => 'closed',
			) );
			if ( $page_id && ! is_wp_error( $page_id ) ) {
				update_post_meta( $page_id, '_wp_page_template', $template_slug );
			}
		} elseif ( $page ) {
			// Ensure existing pages use the right template.
			$current_template = get_post_meta( $page->ID, '_wp_page_template', true );
			if ( $current_template !== $template_slug ) {
				update_post_meta( $page->ID, '_wp_page_template', $template_slug );
			}
		}
	}
}
add_action( 'after_switch_theme', 'me_transfers_sync_service_pages' );
