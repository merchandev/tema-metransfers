<?php
/**
 * Tours Management Logic
 *
 * @package Me_Transfers
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns the catalog of available tours.
 *
 * @return array
 */
function me_transfers_get_tour_catalog() {
	return array(
		'tour-en-barcelona' => array(
			'title'      => 'Tour en Barcelona',
			'slug'       => 'tour-en-barcelona',
			'price'      => 'Desde 400â‚¬',
			'duration'   => '6-8 horas',
			'group_size' => 'Hasta 7 personas',
			'img'        => 'https://images.unsplash.com/photo-1583422409516-2895a77efded?q=80&w=1200&auto=format&fit=crop',
			'desc'       => 'Descubre Barcelona con un recorrido por sus monumentos icÃ³nicos, como la Sagrada Familia, el Barrio GÃ³tico y el Paseo de Gracia. Disfruta de la arquitectura de GaudÃ­ y la vibrante cultura catalana en un tour inolvidable.',
			'full_desc'  => 'Barcelona es una de las ciudades mÃ¡s fascinantes de Europa, y nuestro tour privado te permite descubrirla a tu ritmo, sin aglomeraciones y con la comodidad de un vehÃ­culo Mercedes de alta gama con chÃ³fer profesional.

Comenzamos el recorrido con la recogida puerta a puerta en tu hotel, apartamento o cualquier punto de Barcelona. Nuestro conductor, completamente bilingÃ¼e, te acompaÃ±arÃ¡ durante toda la jornada y te darÃ¡ contexto sobre cada lugar que visitÃ©is.

La primera parada es la majestuosa Sagrada Familia, la obra maestra inacabada de Antoni GaudÃ­ que atrae a millones de visitantes cada aÃ±o. Desde el exterior podrÃ¡s apreciar la grandeza de sus fachadas, mientras tu chÃ³fer te explica la historia de su construcciÃ³n que comenzÃ³ en 1882.

Continuamos hacia el Parque GÃ¼ell, otro de los tesoros de GaudÃ­, donde los mosaicos de colores y las formas orgÃ¡nicas crean un paisaje de fantasÃ­a con vistas panorÃ¡micas espectaculares de toda la ciudad y el MediterrÃ¡neo. Es un lugar perfecto para fotografÃ­as inolvidables.

El recorrido sigue por el corazÃ³n histÃ³rico de Barcelona: el Barrio GÃ³tico, con sus calles estrechas medievales, la Catedral de Barcelona y las plazas escondidas que guardan siglos de historia. Pasearemos por Las Ramblas, el bulevar mÃ¡s famoso de EspaÃ±a, y el Mercado de la BoquerÃ­a con sus colores y aromas.

Finalizamos con una subida a MontjuÃ¯c, la colina que domina la ciudad, donde disfrutarÃ¡s de las mejores vistas panorÃ¡micas de Barcelona, el puerto y el mar. Es el cierre perfecto para un dÃ­a completo de descubrimiento.

Este tour es completamente personalizable: si prefieres visitar el Camp Nou, el barrio de la Barceloneta o hacer una parada para comer en un restaurante local, solo tienes que decÃ­rnoslo.',
			'itinerary'  => array(
				'Recogida en su hotel o punto acordado en Barcelona',
				'Visita exterior a la Sagrada Familia con explicaciÃ³n del chÃ³fer',
				'Recorrido por el Parque GÃ¼ell y sus terrazas panorÃ¡micas',
				'Paseo por el Barrio GÃ³tico, la Catedral y Las Ramblas',
				'Parada en el Mercado de la BoquerÃ­a (opcional)',
				'Subida panorÃ¡mica a MontjuÃ¯c con vistas de la ciudad',
				'Regreso al punto de origen o lugar que prefiera',
			),
			'includes'   => array(
				'ChÃ³fer privado profesional bilingÃ¼e (espaÃ±ol/inglÃ©s)',
				'VehÃ­culo Mercedes de alta gama (Clase V o Clase E)',
				'Recogida y devoluciÃ³n puerta a puerta',
				'Agua frÃ­a y WiFi a bordo',
				'Flexibilidad total de horario y paradas',
				'Seguro de responsabilidad civil completo',
			),
			'highlights' => array( 'Sagrada Familia', 'Parque GÃ¼ell', 'Barrio GÃ³tico', 'MontjuÃ¯c' ),
		),

		'tour-a-montserrat' => array(
			'title'      => 'Tour a Montserrat',
			'slug'       => 'tour-a-montserrat',
			'price'      => 'Desde 450â‚¬',
			'duration'   => '5-7 horas',
			'group_size' => 'Hasta 7 personas',
			'img'        => get_template_directory_uri() . '/assets/img/V2.png',
			'desc'       => 'Explora la majestuosa montaÃ±a de Montserrat y su monasterio benedictino, hogar de la Virgen de Montserrat. Disfruta de vistas panorÃ¡micas, senderos naturales y la espiritualidad de este emblemÃ¡tico lugar de CataluÃ±a.',
			'full_desc'  => 'Montserrat es mucho mÃ¡s que una montaÃ±a: es el corazÃ³n espiritual de CataluÃ±a y una de las formaciones rocosas mÃ¡s impresionantes de Europa. Nuestro tour privado te lleva desde Barcelona hasta la cima en un trayecto de apenas una hora, atravesando paisajes que cambian de la ciudad al campo y finalmente a las espectaculares agujas de roca que dan nombre a la "montaÃ±a serrada".

La experiencia comienza con la recogida en tu alojamiento de Barcelona. Durante el trayecto, tu chÃ³fer te pondrÃ¡ en contexto sobre la importancia histÃ³rica y cultural de Montserrat para el pueblo catalÃ¡n, un lugar de peregrinaje desde hace mÃ¡s de mil aÃ±os.

Al llegar, visitarÃ¡s la BasÃ­lica del Monasterio de Montserrat, un impresionante conjunto arquitectÃ³nico fundado en el siglo XI que alberga a la famosa Virgen de Montserrat, conocida cariÃ±osamente como "La Moreneta". Esta talla romÃ¡nica del siglo XII es la patrona de CataluÃ±a y cada aÃ±o recibe a millones de devotos y visitantes.

Si la visita coincide con el horario, podrÃ¡s escuchar a la EscolanÃ­a de Montserrat, uno de los coros de niÃ±os mÃ¡s antiguos de Europa, cuyas voces llenan la basÃ­lica con una acÃºstica sobrecogedora.

El tour incluye tiempo libre para subir en el funicular de Sant Joan hasta el punto mÃ¡s alto accesible de la montaÃ±a, desde donde las vistas son absolutamente extraordinarias: en dÃ­as claros puedes ver hasta Mallorca. TambiÃ©n puedes optar por el funicular de Santa Cova, que baja hasta la cueva donde segÃºn la leyenda se encontrÃ³ la imagen de la Virgen.

Antes de regresar, hacemos una parada para degustar los famosos licores artesanales que elaboran los monjes del monasterio, asÃ­ como quesos y productos locales de la regiÃ³n. Es una experiencia gastronÃ³mica que complementa perfectamente la visita cultural.

El regreso a Barcelona se realiza a tu ritmo, con la posibilidad de hacer paradas adicionales en pueblos del interior como Manresa o bodegas del PenedÃ¨s.',
			'itinerary'  => array(
				'Recogida en su hotel en Barcelona',
				'Trayecto escÃ©nico hasta Montserrat (~1 hora)',
				'Visita a la BasÃ­lica y la Virgen de la Moreneta',
				'Coro de la EscolanÃ­a (segÃºn horario disponible)',
				'Subida en funicular de Sant Joan (vistas panorÃ¡micas)',
				'DegustaciÃ³n de licores y productos locales',
				'Regreso a Barcelona con paradas opcionales',
			),
			'includes'   => array(
				'ChÃ³fer privado profesional bilingÃ¼e',
				'VehÃ­culo Mercedes de alta gama',
				'Recogida y devoluciÃ³n puerta a puerta',
				'Agua frÃ­a y WiFi a bordo',
				'DegustaciÃ³n de productos locales',
				'Seguro de responsabilidad civil completo',
			),
			'highlights' => array( 'AbadÃ­a de Montserrat', 'La Moreneta', 'Funicular de Sant Joan', 'DegustaciÃ³n de licores' ),
		),

		'tour-costa-brava' => array(
			'title'      => 'Tour Costa Brava',
			'slug'       => 'tour-costa-brava',
			'price'      => 'Desde 600â‚¬',
			'duration'   => '8-10 horas',
			'group_size' => 'Hasta 7 personas',
			'img'        => get_template_directory_uri() . '/assets/img/V1.png',
			'desc'       => 'SumÃ©rgete en las aguas cristalinas y paisajes Ãºnicos de la Costa Brava. Recorre encantadores pueblos pesqueros, calas escondidas y disfruta de la mejor gastronomÃ­a mediterrÃ¡nea en un entorno paradisÃ­aco.',
			'full_desc'  => 'La Costa Brava es sin duda uno de los destinos mÃ¡s espectaculares del MediterrÃ¡neo occidental. Con nuestro tour privado, recorrerÃ¡s los pueblos mÃ¡s bonitos de esta costa salvaje y escarpada, lejos de las rutas turÃ­sticas masificadas, con la libertad de parar donde y cuando quieras.

Salimos de Barcelona por la maÃ±ana y en aproximadamente una hora y media llegamos a Tossa de Mar, nuestro primer destino. Este pueblo medieval amurallado, que cautivÃ³ al mismÃ­simo Marc Chagall, tiene una de las playas urbanas mÃ¡s bonitas de la Costa Brava, coronada por las ruinas de la Vila Vella, la Ãºnica ciudad medieval fortificada que se conserva en el litoral catalÃ¡n.

Continuamos por la sinuosa carretera de la costa, con vistas que quitan el aliento en cada curva, hasta llegar a Calella de Palafrugell, un antiguo pueblo de pescadores que conserva toda su autenticidad. Sus casitas blancas con puertas azules, las barcas varadas en la playa y los arcos del paseo marÃ­timo crean una postal mediterrÃ¡nea perfecta. AquÃ­ podemos hacer una parada para un almuerzo de mariscos frescos en uno de los restaurantes locales con terraza frente al mar.

El recorrido incluye una caminata por un tramo de los Caminos de Ronda, los antiguos senderos costeros que recorrÃ­an los vigilantes del contrabando. Hoy son rutas de senderismo espectaculares que conectan calas escondidas, acantilados y miradores naturales con aguas turquesas dignas del Caribe.

Dependiendo de la temporada y tus preferencias, podemos incluir una visita a Pals o Peratallada, dos pueblos medievales del interior que han sido declarados conjuntos histÃ³rico-artÃ­sticos, con calles empedradas, murallas y torres que parecen detenidas en el tiempo.

El regreso a Barcelona se realiza al atardecer, el momento perfecto para contemplar la puesta de sol sobre los campos y viÃ±edos del EmpordÃ  desde la comodidad de nuestro vehÃ­culo Mercedes. Un dÃ­a que combina playa, cultura, gastronomÃ­a y naturaleza en su mÃ¡xima expresiÃ³n.',
			'itinerary'  => array(
				'Recogida en su hotel en Barcelona por la maÃ±ana',
				'Trayecto escÃ©nico hasta Tossa de Mar (~1.5 horas)',
				'Visita a la Vila Vella y playas de Tossa de Mar',
				'Ruta costera hasta Calella de Palafrugell',
				'Almuerzo de mariscos con vistas al mar (opcional)',
				'Caminata por los Caminos de Ronda y calas escondidas',
				'Visita a pueblos medievales del interior (Pals o Peratallada)',
				'Regreso a Barcelona al atardecer',
			),
			'includes'   => array(
				'ChÃ³fer privado profesional bilingÃ¼e',
				'VehÃ­culo Mercedes de alta gama',
				'Recogida y devoluciÃ³n puerta a puerta',
				'Agua frÃ­a y WiFi a bordo',
				'Paradas ilimitadas para fotos y exploraciÃ³n',
				'Seguro de responsabilidad civil completo',
			),
			'highlights' => array( 'Tossa de Mar', 'Calella de Palafrugell', 'Caminos de Ronda', 'GastronomÃ­a local' ),
		),

		'tour-a-girona' => array(
			'title'      => 'Tour a Girona',
			'slug'       => 'tour-a-girona',
			'price'      => 'Desde 500â‚¬',
			'duration'   => '6-8 horas',
			'group_size' => 'Hasta 7 personas',
			'img'        => 'http://metransfers.es/wp-content/uploads/2026/04/catedral-de-girona_principal.jpg',
			'desc'       => 'Pasea por la histÃ³rica ciudad de Girona, con su impresionante casco antiguo, el barrio judÃ­o y los coloridos puentes sobre el rÃ­o Onyar. Un destino lleno de historia, cultura y escenarios de pelÃ­cula.',
			'full_desc'  => 'Girona es una de las ciudades con mÃ¡s encanto de toda EspaÃ±a, y nuestro tour privado te permite descubrir cada rincÃ³n de esta joya medieval a solo una hora de Barcelona. Con mÃ¡s de dos mil aÃ±os de historia, Girona ofrece una combinaciÃ³n Ãºnica de patrimonio romano, medieval, judÃ­o y modernista que la convierte en una visita imprescindible.

El tour comienza con la recogida en tu alojamiento de Barcelona. El trayecto hasta Girona dura aproximadamente una hora por autopista, tiempo que tu chÃ³fer aprovecharÃ¡ para contarte la historia de la ciudad y recomendarte los mejores lugares.

Al llegar, comenzamos por la imponente Catedral de Girona, que posee la nave gÃ³tica mÃ¡s ancha del mundo con sus 23 metros. La escalinata barroca que conduce hasta su entrada principal es uno de los escenarios mÃ¡s reconocidos de "Juego de Tronos", donde se rodaron escenas de Desembarco del Rey en las temporadas 5 y 6.

Descendemos hacia el Call, el barrio judÃ­o medieval mejor conservado de toda Europa. Sus callejuelas laberÃ­nticas, algunas de apenas un metro de ancho, te transportan directamente al siglo XV. AquÃ­ se encuentra el Museo de Historia de los JudÃ­os, donde podrÃ¡s conocer la importante comunidad sefardÃ­ que habitÃ³ Girona durante siglos.

Uno de los momentos mÃ¡s fotogÃ©nicos del tour es el paseo por las Cases de l\'Onyar, las coloridas casas colgadas sobre el rÃ­o que se han convertido en la imagen icÃ³nica de la ciudad. Los puentes que cruzan el rÃ­o, incluido el Pont de les Peixateries Velles diseÃ±ado por Gustave Eiffel, ofrecen las mejores perspectivas para fotografÃ­as.

Completamos el recorrido con un paseo por la Muralla medieval, un camino elevado que rodea el casco antiguo y ofrece vistas panorÃ¡micas extraordinarias de los tejados, las torres y las montaÃ±as que rodean la ciudad. Es el lugar perfecto para entender la dimensiÃ³n y belleza de Girona desde las alturas.

Para el almuerzo, podemos hacer una parada en alguno de los restaurantes del casco antiguo donde podrÃ¡s probar la cocina gerundense, influenciada por la cercanÃ­a de los Pirineos y el MediterrÃ¡neo. Girona es una ciudad con una escena gastronÃ³mica de primer nivel, sede de varios restaurantes con estrellas Michelin.',
			'itinerary'  => array(
				'Recogida en su hotel en Barcelona',
				'Trayecto hasta Girona (~1 hora por autopista)',
				'Visita a la Catedral de Girona (escenario de Juego de Tronos)',
				'Recorrido por el Call, el barrio judÃ­o medieval',
				'Paseo por las Cases de l\'Onyar y puentes del rÃ­o',
				'Almuerzo en restaurante del casco antiguo (opcional)',
				'Caminata por la Muralla medieval y vistas panorÃ¡micas',
				'Regreso a Barcelona',
			),
			'includes'   => array(
				'ChÃ³fer privado profesional bilingÃ¼e',
				'VehÃ­culo Mercedes de alta gama',
				'Recogida y devoluciÃ³n puerta a puerta',
				'Agua frÃ­a y WiFi a bordo',
				'Flexibilidad total de horario y paradas',
				'Seguro de responsabilidad civil completo',
			),
			'highlights' => array( 'Casco Antiguo', 'Barrio JudÃ­o', 'Catedral de Girona', 'Paseo de la Muralla' ),
		),
	);
}

/**
 * Returns the URL for a specific tour.
 *
 * @param string $slug The tour slug.
 * @return string
 */
function me_transfers_get_tour_url( $slug ) {
	$page = get_page_by_path( $slug );
	if ( $page ) {
		return get_permalink( $page->ID );
	}
	return home_url( '/' . $slug );
}

/**
 * Checks if the current post is one of our dynamic tours.
 *
 * @param WP_Post|null $post The post object.
 * @return array|false The tour data array if it is a tour, false otherwise.
 */
function me_transfers_get_current_tour( $post = null ) {
	if ( ! $post ) {
		global $post;
	}
	if ( ! $post || 'page' !== $post->post_type ) {
		return false;
	}

	$catalog = me_transfers_get_tour_catalog();
	if ( isset( $catalog[ $post->post_name ] ) ) {
		return $catalog[ $post->post_name ];
	}

	return false;
}

/**
 * Ensures all tour pages exist in the WordPress database.
 * If they don't, it creates them.
 */
function me_transfers_sync_tour_pages() {
	$catalog = me_transfers_get_tour_catalog();

	foreach ( $catalog as $slug => $tour ) {
		$page = get_page_by_path( $slug );
		if ( ! $page ) {
			wp_insert_post( array(
				'post_title'     => $tour['title'],
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
add_action( 'after_switch_theme', 'me_transfers_sync_tour_pages' );
add_action( 'admin_init', 'me_transfers_sync_tour_pages' );
