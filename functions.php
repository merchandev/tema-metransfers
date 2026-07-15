<?php
/**
 * Me Transfers functions and definitions
 *
 * @package Me_Transfers
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


require_once get_template_directory() . '/includes/destinations.php';
require_once get_template_directory() . '/includes/faq.php';
require_once get_template_directory() . '/includes/legal-pages.php';
require_once get_template_directory() . '/includes/seo-page-titles.php';
require_once get_template_directory() . '/includes/tours.php';
require_once get_template_directory() . '/includes/services.php';
require_once get_template_directory() . '/includes/request-cpt.php';
require_once get_template_directory() . '/includes/tour-bookings.php';
require_once get_template_directory() . '/includes/rutas-cpt.php';

// Migration safety switch — set to false once initial migration is done.
if ( ! defined( 'ME_TRANSFERS_ENABLE_MIGRATIONS' ) ) {
	define( 'ME_TRANSFERS_ENABLE_MIGRATIONS', false );
}

// Centralized Versioning
if ( ! defined( 'ME_TRANSFERS_VERSION' ) ) {
	define( 'ME_TRANSFERS_VERSION', wp_get_theme()->get( 'Version' ) );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function me_transfers_setup() {
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Ensure classic WordPress menu management stays available.
	add_theme_support( 'menus' );

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'me-transfers' ),
			'footer' => esc_html__( 'Footer Menu', 'me-transfers' ),
		)
	);

	// Switch default core markup for search form, comment form, and comments
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add support for core custom logo.
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'me_transfers_setup' );

/**
 * Unregister default WordPress sidebar widget areas so they don't
 * render on blog/archive pages.
 *
 * @return void
 */
function me_transfers_unregister_sidebars() {
	unregister_sidebar( 'sidebar-1' );
	unregister_sidebar( 'sidebar-2' );
	unregister_sidebar( 'sidebar-3' );
}
add_action( 'widgets_init', 'me_transfers_unregister_sidebars', 20 );

/**
 * Removido: me_transfers_prefix_document_title 
 * Para evitar "Keyword Stuffing" y permitir que WordPress (y el usuario en Ajustes) manejen el t�-tulo limpiamente.
 */



/**
 * Fallback menu renderer.
 *
 * If no menu is assigned to the location, render the first native WP menu
 * with items so custom Navigation Labels are respected.
 * Final fallback is a basic page list.
 *
 * @param array $args Nav menu arguments.
 * @return void
 */
function me_transfers_fallback_menu( $args ) {
	$menu_class = ! empty( $args['menu_class'] ) ? $args['menu_class'] : 'nav-menu';
	$menu_id    = ! empty( $args['menu_id'] ) ? (string) $args['menu_id'] : '';
	$depth      = isset( $args['depth'] ) ? absint( $args['depth'] ) : 1;

	$menus = wp_get_nav_menus();

	if ( ! empty( $menus ) && ! is_wp_error( $menus ) ) {
		foreach ( $menus as $menu_obj ) {
			$menu_items = wp_get_nav_menu_items( $menu_obj->term_id );

			if ( empty( $menu_items ) || is_wp_error( $menu_items ) ) {
				continue;
			}

			wp_nav_menu(
				array(
					'menu'        => (int) $menu_obj->term_id,
					'menu_id'     => $menu_id,
					'menu_class'  => $menu_class,
					'container'   => false,
					'fallback_cb' => false,
					'depth'       => $depth,
				)
			);
			return;
		}
	}

	$menu_id_attr = '' !== $menu_id ? sprintf( ' id="%s"', esc_attr( $menu_id ) ) : '';

	echo '<ul' . $menu_id_attr . ' class="' . esc_attr( $menu_class ) . '">';
	wp_list_pages(
		array(
			'title_li' => '',
			'depth'    => 1,
		)
	);
	echo '</ul>';
}

/**
 * Remove deprecated shortcodes that should no longer render in content.
 *
 * @param string $content Post content.
 * @return string
 */
function me_transfers_strip_deprecated_shortcodes( $content ) {
	if ( ! is_string( $content ) || false === stripos( $content, '[mt_hero_card' ) ) {
		return $content;
	}

	return preg_replace( '/\[\/?mt_hero_card[^\]]*\]/i', '', $content );
}
add_filter( 'the_content', 'me_transfers_strip_deprecated_shortcodes', 1 );
add_filter( 'get_the_excerpt', 'me_transfers_strip_deprecated_shortcodes', 1 );


/**
 * Enqueue scripts and styles.
 */
function me_transfers_scripts() {
	// Enqueue Google Fonts (Outfit and Inter)
	wp_enqueue_style( 'me-transfers-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap', array(), null );

	// Main stylesheet
	$style_path    = get_stylesheet_directory() . '/style.css';
	$style_version = file_exists($style_path) ? filemtime($style_path) : ME_TRANSFERS_VERSION;
	wp_enqueue_style( 'me-transfers-style', get_stylesheet_uri(), array(), $style_version );

	// Base dependencies for main.js
	$main_deps = array();

	// GSAP Library (Condicional para performance)
	if ( is_front_page() || is_page_template( 'template-tours.php' ) || is_singular( 'tour' ) || is_singular( 'ruta' ) ) {
		wp_enqueue_script( 'gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', array(), '3.12.5', true );
		wp_enqueue_script( 'gsap-scroll-trigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js', array('gsap'), '3.12.5', true );
		$main_deps = array('gsap', 'gsap-scroll-trigger');
	}

	// Theme custom scripts
	wp_enqueue_script( 'me-transfers-main-js', get_template_directory_uri() . '/assets/js/main.js', $main_deps, ME_TRANSFERS_VERSION, true );

	// Localize AJAX script
	$ajax_config = array(
		'ajaxUrl'           => admin_url( 'admin-ajax.php' ),
		'tourBookingNonce'  => wp_create_nonce( 'mt_tour_booking_nonce' ),
		'contactNonce'      => wp_create_nonce( 'mt_contact_request' ),
	);

	wp_localize_script( 'me-transfers-main-js', 'meTransfers', $ajax_config );
	wp_localize_script( 'me-transfers-main-js', 'meTransfersPublic', $ajax_config );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'me_transfers_scripts' );

// Add DEFER/ASYNC attributes to selected scripts.
add_filter( 'script_loader_tag', function( $tag, $handle, $src ) {
	if ( in_array( $handle, array( 'gsap', 'gsap-scroll-trigger', 'me-transfers-main-js' ), true ) ) {
		if ( false === strpos( $tag, ' defer' ) ) {
			$tag = str_replace( ' src', ' defer src', $tag );
		}
	}

	if ( is_string( $src ) && false !== strpos( $src, 'maps.googleapis.com/maps/api/js' ) ) {
		if ( false === strpos( $tag, ' async' ) ) {
			$tag = str_replace( ' src', ' async src', $tag );
		}
		if ( false === strpos( $tag, ' defer' ) ) {
			$tag = str_replace( ' src', ' defer src', $tag );
		}
	}

	return $tag;
}, 10, 3 );

/**
 * Ensure Maps JS API URL includes loading=async when enqueued by plugins.
 *
 * @param string $src Script source URL.
 * @return string
 */
function me_transfers_maps_async_query_arg( $src ) {
	if ( ! is_string( $src ) || '' === $src ) {
		return $src;
	}

	if ( false === strpos( $src, 'maps.googleapis.com/maps/api/js' ) ) {
		return $src;
	}

	if ( false !== strpos( $src, 'loading=' ) ) {
		return $src;
	}

	return add_query_arg( 'loading', 'async', $src );
}
add_filter( 'script_loader_src', 'me_transfers_maps_async_query_arg', 20 );

/**
 * Returns a section URL that works both on the front page and inner templates.
 *
 * @param string $section Section ID without the leading #.
 * @return string
 */
function me_transfers_get_section_url( $section = 'search' ) {
	$section = sanitize_title_with_dashes( ltrim( (string) $section, "# \t\n\r\0\x0B/" ) );

	if ( '' === $section ) {
		return home_url( '/' );
	}

	if ( is_front_page() ) {
		return '#' . $section;
	}

	return home_url( '/#' . $section );
}

/**
 * Force Tours page in navigation menu
 */
add_filter( 'wp_nav_menu_items', 'me_transfers_add_tours_menu_item', 10, 2 );
function me_transfers_add_tours_menu_item( $items, $args ) {
    if ( $args->theme_location === 'menu-1' || $args->menu_id === 'primary-menu' ) {
        $tours_url = home_url( '/tours/' );
        // Only inject if this URL is not already in the menu HTML.
        if ( strpos( $items, $tours_url ) === false && strpos( $items, '/tours"' ) === false ) {
            $items .= '<li class="menu-item"><a href="' . esc_url( $tours_url ) . '">Tours</a></li>';
        }
    }
    return $items;
}


/* ==========================================================================
   ROL PERSONALIZADO: CHECKHOTELES Y RESTRICCION DE MENUS
   ========================================================================== */

// 1. Crear el nuevo rol
add_action( 'after_switch_theme', 'me_transfers_create_checkhoteles_role' );

// Fallback: crear rol si no existe aun (primera instalacion sin cambio de tema),
// protegido por transient de larga duracion para no repetirse en cada request.
add_action( 'init', function() {
    if ( ! get_role( 'check_hoteles' ) && ! get_transient( 'me_transfers_role_created' ) ) {
        me_transfers_create_checkhoteles_role();
        set_transient( 'me_transfers_role_created', true, DAY_IN_SECONDS * 365 );
    }
} );
function me_transfers_create_checkhoteles_role() {
    $role = get_role( 'check_hoteles' );
    if ( ! $role ) {
        $role = add_role( 'check_hoteles', 'CheckHoteles', array(
            'read' => true,
        ));
    }

    if ( $role ) {
        // Eliminar permisos excesivos
        $role->remove_cap( 'manage_options' );
        $role->remove_cap( 'edit_posts' );
        $role->remove_cap( 'edit_others_posts' );
        $role->remove_cap( 'edit_published_posts' );
        $role->remove_cap( 'publish_posts' );
        
        // Añadir capacidades específicas
        $role->add_cap( 'read_transfer_requests' );
        $role->add_cap( 'edit_transfer_requests' );
        $role->add_cap( 'read_tour_bookings' );
        $role->add_cap( 'export_transfer_requests' );
    }
}

// 2. Ocultar menús no deseados en el panel izquierdo
add_action('admin_menu', 'me_transfers_hide_menus_checkhoteles', 999);
function me_transfers_hide_menus_checkhoteles() {
    $user = wp_get_current_user();
    if ( in_array( 'check_hoteles', (array) $user->roles ) && ! in_array( 'administrator', (array) $user->roles ) ) {
        global $menu;
        
        // Palabras clave de los menús permitidos
        $allowed_menus = array(
            'index.php', // Escritorio
            'edit.php?post_type=hotel_partner', // Hoteles QR
            'edit.php?post_type=mt_request', // Solicitudes
            'edit.php?post_type=gyg_review', // GYG Reviews (si es CPT)
            'gyg-reviews', // GYG Reviews (si es plugin/página)
            'agente-ia', // Agente IA
            'wp-agente-ia',
            'sg-cachepress', // Speed Optimizer
            'sg-security', // Security Optimizer
            'profile.php' // Perfil de usuario
        );
        
        foreach ( $menu as $key => $item ) {
            $menu_slug = $item[2];
            $is_allowed = false;
            foreach ( $allowed_menus as $allowed ) {
                if ( strpos( $menu_slug, $allowed ) !== false ) {
                    $is_allowed = true;
                    break;
                }
            }
            if ( ! $is_allowed ) {
                remove_menu_page( $menu_slug );
            }
        }
    }
}

// 3. Bloquear acceso directo por URL a páginas no permitidas
add_action('admin_init', 'me_transfers_restrict_checkhoteles_access');
function me_transfers_restrict_checkhoteles_access() {
    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
        return;
    }
    
    $user = wp_get_current_user();
    if ( in_array( 'check_hoteles', (array) $user->roles ) && ! in_array( 'administrator', (array) $user->roles ) ) {
        global $pagenow;
        
        $allowed_pages = array( 'index.php', 'profile.php', 'admin-ajax.php', 'admin-post.php' );
        $is_allowed = in_array( $pagenow, $allowed_pages );
        
        // Permitir listas de Custom Post Types
        if ( $pagenow === 'edit.php' && isset($_GET['post_type']) ) {
            $allowed_cpts = array('hotel_partner', 'mt_request', 'gyg_review');
            if ( in_array( sanitize_key( wp_unslash( $_GET['post_type'] ) ), $allowed_cpts, true ) ) {
                $is_allowed = true;
            }
        }
        
        // Permitir edición de Custom Post Types
        if ( ($pagenow === 'post.php' || $pagenow === 'post-new.php') ) {
            $post_type = '';
            if ( isset($_GET['post']) ) {
                $post_type = get_post_type( (int) $_GET['post'] );
            } elseif ( isset($_POST['post_ID']) ) {
                $post_type = get_post_type($_POST['post_ID']);
            } elseif ( isset($_GET['post_type']) ) {
                $post_type = $_GET['post_type'];
            } elseif ( isset($_POST['post_type']) ) {
                $post_type = $_POST['post_type'];
            }
            if ( in_array($post_type, array('hotel_partner', 'mt_request', 'gyg_review')) ) {
                $is_allowed = true;
            }
        }
        
        // Permitir páginas de plugins
        if ( isset($_GET['page']) ) {
            $requested_page  = sanitize_key( wp_unslash( $_GET['page'] ) );
            $allowed_plugins = array('sg-cachepress', 'sg-security', 'agente-ia', 'wp-agente-ia', 'gyg-reviews');
            foreach ($allowed_plugins as $plugin) {
                if ( $requested_page === $plugin || str_starts_with( $requested_page, $plugin ) ) {
                    $is_allowed = true;
                    break;
                }
            }
        }
        
        // Si no está permitido, redirigir al escritorio
        if ( ! $is_allowed ) {
            wp_redirect( admin_url( 'index.php' ) );
            exit;
        }
    }
}

// 4. Limitar visualización de Hoteles QR a los creados por el usuario
add_action('pre_get_posts', 'me_transfers_restrict_hotel_partner_view');
function me_transfers_restrict_hotel_partner_view($query) {
    if ( is_admin() && $query->is_main_query() ) {
        $user = wp_get_current_user();
        if ( in_array( 'check_hoteles', (array) $user->roles ) && ! in_array( 'administrator', (array) $user->roles ) ) {
            if ( $query->get('post_type') === 'hotel_partner' ) {
                $query->set('author', $user->ID);
            }
        }
    }
}

// Ocultar recuentos (Todo | Publicados) para el rol CheckHoteles
add_filter( 'views_edit-hotel_partner', 'me_transfers_hide_hotel_partner_counts' );
function me_transfers_hide_hotel_partner_counts( $views ) {
    $user = wp_get_current_user();
    if ( in_array( 'check_hoteles', (array) $user->roles ) && ! in_array( 'administrator', (array) $user->roles ) ) {
        return array(); 
    }
    return $views;
}

// Ocultar widgets por defecto de WP en el escritorio para CheckHoteles
add_action( 'wp_dashboard_setup', 'me_transfers_remove_default_dashboard_widgets', 999 );
function me_transfers_remove_default_dashboard_widgets() {
    $user = wp_get_current_user();
    if ( in_array( 'check_hoteles', (array) $user->roles ) && ! in_array( 'administrator', (array) $user->roles ) ) {
        remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' ); // Actividad
        remove_meta_box( 'dashboard_primary', 'dashboard', 'side' ); // Eventos y Noticias
        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' ); // Borrador rapido
        remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' ); // De un vistazo
    }
}

/**
 * One-off migration: Copy hardcoded content to post_content for SEO & Editing
 */
function me_transfers_migrate_content_to_editor() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    if ( get_option( 'me_transfers_content_migrated_v1' ) ) {
        return;
    }
    // Transient lock: prevents simultaneous execution in race conditions.
    if ( get_transient( 'me_transfers_migrating_content_v1' ) ) {
        return;
    }
    set_transient( 'me_transfers_migrating_content_v1', true, MINUTE_IN_SECONDS * 5 );

    // Hub Page
    $hub = get_page_by_path( 'destinos', OBJECT, 'page' );
    if ( $hub && empty( trim( $hub->post_content ) ) ) {
        wp_update_post( array(
            'ID' => $hub->ID,
            'post_content' => 'Explora los destinos más solicitados y accede a una ficha rápida para pedir información de traslados privados, recogidas en aeropuerto, hoteles, puertos y rutas personalizadas.'
        ) );
    }

    // Destinations
    $destinations = me_transfers_get_destination_catalog();
    foreach ( $destinations as $dest ) {
        $page = get_page_by_path( $dest['slug'], OBJECT, 'page' );
        if ( ! $page ) {
            $page = get_page_by_path( 'destinos/' . $dest['slug'], OBJECT, 'page' );
        }
        if ( $page && empty( trim( $page->post_content ) ) ) {
            $content = '<p>' . esc_html( $dest['travel_note'] ) . '</p>';
            $content .= '<p>' . esc_html( sprintf( 'Si estás organizando un traslado hacia %s, podemos prepararte una propuesta adaptada al punto de recogida, número de pasajeros, fecha estimada y tipo de servicio que necesites.', $dest['title'] ) ) . '</p>';
            $content .= '<ul>';
            foreach ( $dest['highlights'] as $highlight ) {
                $content .= '<li>' . esc_html( $highlight ) . '</li>';
            }
            $content .= '</ul>';
            
            wp_update_post( array(
                'ID' => $page->ID,
                'post_content' => $content
            ) );
        }
    }

    // Tours
    $tours = me_transfers_get_tour_catalog();
    foreach ( $tours as $slug => $tour ) {
        $page = get_page_by_path( $slug, OBJECT, 'page' );
        if ( $page && empty( trim( $page->post_content ) ) ) {
            $paragraphs = isset( $tour['full_desc'] ) ? explode( "\n\n", $tour['full_desc'] ) : array( $tour['desc'] );
            $content = '';
            foreach ( $paragraphs as $p ) {
                $p = trim( $p );
                if ( $p ) {
                    $content .= '<p>' . esc_html( $p ) . '</p>';
                }
            }
            
            wp_update_post( array(
                'ID' => $page->ID,
                'post_content' => $content
            ) );
        }
    }

    update_option( 'me_transfers_content_migrated_v1', true );
}
if ( defined( 'ME_TRANSFERS_ENABLE_MIGRATIONS' ) && ME_TRANSFERS_ENABLE_MIGRATIONS ) {
	add_action( 'admin_init', 'me_transfers_migrate_content_to_editor' );
}

/**
 * Migration v2: Copy hardcoded content to post_content for Services
 */
function me_transfers_migrate_services_to_editor() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    if ( get_option( 'me_transfers_content_migrated_services' ) ) {
        return;
    }
    // Transient lock: prevents simultaneous execution in race conditions.
    if ( get_transient( 'me_transfers_migrating_services' ) ) {
        return;
    }
    set_transient( 'me_transfers_migrating_services', true, MINUTE_IN_SECONDS * 5 );

    $services = me_transfers_get_service_catalog();
    foreach ( $services as $slug => $service ) {
        $page = get_page_by_path( $slug, OBJECT, 'page' );
        if ( $page && empty( trim( $page->post_content ) ) ) {
            wp_update_post( array(
                'ID' => $page->ID,
                'post_content' => '<p>' . esc_html( $service['full_desc'] ) . '</p>'
            ) );
        }
    }

    update_option( 'me_transfers_content_migrated_services', true );
}
if ( defined( 'ME_TRANSFERS_ENABLE_MIGRATIONS' ) && ME_TRANSFERS_ENABLE_MIGRATIONS ) {
	add_action( 'admin_init', 'me_transfers_migrate_services_to_editor' );
}

/**
 * Migration v3: Move Legal Pages from hardcoded to database
 */
function me_transfers_migrate_legal_to_editor() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    if ( get_option( 'me_transfers_content_migrated_legal' ) ) {
        return;
    }
    // Transient lock: prevents simultaneous execution in race conditions.
    if ( get_transient( 'me_transfers_migrating_legal' ) ) {
        return;
    }
    set_transient( 'me_transfers_migrating_legal', true, MINUTE_IN_SECONDS * 5 );

    $pages = array(
        'privacidad' => '<h2>1. Identificación del Responsable del Tratamiento</h2>
<p><strong>Razón Social:</strong> METRANSFERS GESTION SL</p>
<p><strong>NIF:</strong> B22522353</p>
<p><strong>Domicilio Fiscal:</strong> AVDA MARE DE DEU DE MONTSERRAT, NUM 18, PLANTA 5, PUERTA 2, 08970 SANT JOAN DESPÍ &ndash; (BARCELONA)</p>
<p><strong>Contacto Privacidad:</strong> <a href="mailto:info@metransfers.es">info@metransfers.es</a></p>
<h2>2. Aceptación Vinculante</h2>
<p>Al utilizar nuestros servicios, navegar por nuestra plataforma o completar el proceso de configuración de una reserva, usted reconoce haber leído, comprendido y aceptado sin reservas que sus datos personales sean tratados conforme a los términos aquí expuestos. La formalización de una reserva constituye un contrato entre las partes, legitimando el tratamiento de los datos necesarios para la ejecución del servicio.</p>
<h2>3. Datos Objeto de Tratamiento</h2>
<p>Recopilamos los datos estrictamente necesarios para la prestación del servicio:</p>
<ul>
<li><strong>Datos de Reserva:</strong> Nombre, apellidos, teléfono, correo electrónico y detalles del trayecto/servicio solicitado.</li>
<li><strong>Datos de Facturación:</strong> Dirección postal y NIF/DNI (según los datos de registro fiscal de la entidad).</li>
<li><strong>Datos de Navegación:</strong> Dirección IP, cookies y metadatos para garantizar la seguridad del sitio.</li>
</ul>
<h2>4. Finalidad del Tratamiento</h2>
<p>Sus datos serán tratados con el fin de:</p>
<ul>
<li><strong>Gestión de Reservas:</strong> Tramitar, confirmar y ejecutar los servicios de transporte o gestión contratados.</li>
<li><strong>Atención al Cliente:</strong> Resolver dudas y proporcionar soporte a través del punto único de contacto <a href="mailto:info@metransfers.es">info@metransfers.es</a>.</li>
<li><strong>Cumplimiento Legal:</strong> Emitir facturas y cumplir con las obligaciones tributarias ante la AEAT.</li>
<li><strong>Seguridad:</strong> Prevenir fraudes y usos no autorizados de la plataforma.</li>
</ul>
<h2>5. Legitimación</h2>
<p>La base legal para el tratamiento es:</p>
<ul>
<li><strong>Ejecución Contractual:</strong> Necesaria para procesar su reserva y prestarle el servicio solicitado.</li>
<li><strong>Obligación Legal:</strong> Derivada de la normativa fiscal y mercantil vigente en España.</li>
<li><strong>Consentimiento:</strong> Otorgado explícitamente al marcar la casilla de aceptación en nuestros formularios.</li>
</ul>
<h2>6. Conservación y Destinatarios</h2>
<p><strong>Plazos:</strong> Los datos se conservarán durante el tiempo que dure la relación comercial y, posteriormente, durante los plazos legales de prescripción (generalmente 6 años para documentos contables según el Código de Comercio).</p>
<p><strong>Cesiones:</strong> No se cederán datos a terceros ajenos a la operativa del servicio, salvo obligación legal ante autoridades competentes.</p>
<h2>7. Derechos del Interesado</h2>
<p>Usted puede ejercer sus derechos de Acceso, Rectificación, Supresión, Limitación, Portabilidad y Oposición enviando una comunicación escrita acompañada de copia de su DNI a: <a href="mailto:info@metransfers.es">info@metransfers.es</a>.</p>
<p>Asimismo, tiene derecho a retirar su consentimiento en cualquier momento y a presentar una reclamación ante la Agencia Española de Protección de Datos (AEPD) si considera que sus derechos han sido vulnerados.</p>',
        'cookie' => '<h2>1. Responsable del sitio web</h2>
<p><strong>Razón social:</strong> METRANSFERS GESTION SL</p>
<p><strong>NIF:</strong> B22522353</p>
<p><strong>Domicilio:</strong> AVDA MARE DE DEU DE MONTSERRAT, NUM 18, PLANTA 5, PUERTA 2, 08970 SANT JOAN DESPÍ (BARCELONA)</p>
<p><strong>Correo electrónico:</strong> <a href="mailto:info@metransfers.es">info@metransfers.es</a></p>
<h2>2. Qué son las cookies</h2>
<p>Las cookies son pequeños archivos que se descargan en su dispositivo al acceder a determinadas páginas web. Permiten, entre otras cosas, reconocer su navegador, mantener la sesión, recordar preferencias, reforzar la seguridad o facilitar determinadas funcionalidades técnicas del sitio.</p>
<h2>3. Tipos de cookies</h2>
<p>Las cookies pueden clasificarse, entre otros criterios, del siguiente modo:</p>
<ul>
<li><strong>Según la entidad que las gestione:</strong> cookies propias y cookies de terceros.</li>
<li><strong>Según su finalidad:</strong> cookies técnicas o necesarias, de preferencias o personalización, de análisis, y de publicidad o publicidad comportamental.</li>
<li><strong>Según el tiempo que permanecen activas:</strong> cookies de sesión y cookies persistentes.</li>
</ul>
<h2>4. Cookies utilizadas en metransfers.es</h2>
<p>Con carácter general, este sitio utiliza o puede utilizar cookies técnicas, de sesión y de preferencia estrictamente relacionadas con el funcionamiento de la web y la prestación del servicio solicitado por el usuario. Entre ellas se incluyen, cuando proceda:</p>
<ul>
<li><strong>Cookies técnicas de navegación y seguridad:</strong> necesarias para cargar la web, proteger formularios, prevenir usos abusivos y garantizar el funcionamiento básico del sitio.</li>
<li><strong>Cookies asociadas al proceso de reserva o contacto:</strong> necesarias para gestionar solicitudes enviadas por el usuario, mantener datos temporales de sesión y completar procesos esenciales vinculados al servicio contratado.</li>
<li><strong>Cookies de preferencias:</strong> destinadas a recordar opciones expresamente solicitadas por el usuario, como el idioma o determinadas configuraciones de visualización, cuando estas funcionalidades estén habilitadas.</li>
<li><strong>Cookies técnicas de terceros vinculadas al servicio:</strong> determinados proveedores externos integrados en la web, como herramientas de traducción, mapas, contenidos embebidos o pasarelas de pago seguras, pueden instalar sus propias cookies cuando el usuario interactúa con dichas funcionalidades.</li>
</ul>
<p>Este tema no instala por sí mismo cookies de publicidad comportamental. Si en el futuro se incorporan herramientas analíticas no exentas, servicios de personalización avanzada o soluciones publicitarias que requieran consentimiento, se informará al usuario de forma previa y se recabará la autorización correspondiente antes de su activación.</p>
<h2>5. Base jurídica</h2>
<p>Las cookies técnicas o estrictamente necesarias pueden utilizarse sin consentimiento previo cuando resultan imprescindibles para prestar el servicio solicitado por el usuario o para posibilitar la navegación segura por el sitio web. Las cookies no necesarias solo podrán utilizarse cuando exista una base jurídica adecuada y, en los casos exigidos por la normativa, tras obtener el consentimiento informado del usuario.</p>
<h2>6. Plazo de conservación</h2>
<p>Las cookies de sesión permanecen activas únicamente mientras el usuario navega por el sitio y se eliminan al cerrar el navegador. Las cookies persistentes, cuando existan, se conservarán durante el tiempo estrictamente necesario para cumplir su finalidad o hasta que el usuario las elimine manualmente desde la configuración de su navegador o del servicio correspondiente.</p>
<h2>7. Gestión, configuración y desactivación</h2>
<p>El usuario puede permitir, bloquear o eliminar las cookies instaladas en su dispositivo mediante la configuración de su navegador. Debe tener en cuenta que la desactivación de cookies técnicas o necesarias puede afectar al correcto funcionamiento del sitio, del proceso de reserva o de determinadas funcionalidades esenciales.</p>
<ul>
<li><a href="https://support.google.com/chrome/answer/95647?hl=es" target="_blank" rel="noopener">Configurar cookies en Google Chrome</a></li>
<li><a href="https://support.mozilla.org/es/kb/proteccion-antirrastreo-mejorada-firefox-escritorio" target="_blank" rel="noopener">Configurar cookies en Mozilla Firefox</a></li>
<li><a href="https://support.apple.com/es-es/guide/safari/sfri11471/mac" target="_blank" rel="noopener">Configurar cookies en Safari</a></li>
<li><a href="https://support.microsoft.com/es-es/microsoft-edge/administrar-cookies-en-microsoft-edge-ver-permitir-bloquear-eliminar-y-usar-168dab11-0753-043d-7c16-ede5947fc64d" target="_blank" rel="noopener">Configurar cookies en Microsoft Edge</a></li>
</ul>
<h2>8. Cookies de terceros</h2>
<p>La aceptación, configuración y uso de cookies de terceros se rige por las políticas propias de dichos proveedores. METRANSFERS GESTION SL no puede controlar en todo momento las actualizaciones que esos terceros realicen en sus políticas, por lo que se recomienda al usuario revisar directamente sus condiciones cuando interactúe con herramientas externas integradas o enlazadas desde la web.</p>
<h2>9. Información adicional y contacto</h2>
<p>Para obtener más información sobre el tratamiento de datos personales, puede consultar nuestra <a href="' . home_url( '/privacidad' ) . '">Política de Privacidad</a>. Si necesita aclaraciones sobre el uso de cookies en este sitio web, puede escribir a <a href="mailto:info@metransfers.es">info@metransfers.es</a>.</p>
<p>La presente Política de Cookies podrá actualizarse cuando se produzcan cambios normativos, técnicos o funcionales en el sitio web. Se recomienda revisarla periódicamente.</p>',
        'terminos-y-condiciones' => '<h2>1. MARCO LEGAL APLICABLE</h2>
<p>El presente contrato se rige por lo dispuesto en la legislación española vigente, específicamente:</p>
<ul>
<li>Ley 16/1987, de 30 de julio, de Ordenación de los Transportes Terrestres (LOTT) y su Reglamento (ROTT).</li>
<li>Ley 34/2002 (LSSI-CE) sobre servicios de la sociedad de la información.</li>
<li>Real Decreto Legislativo 1/2007, por el que se aprueba el texto refundido de la Ley General para la Defensa de los Consumidores y Usuarios.</li>
<li>Reglamento (UE) 2016/679 (RGPD) en materia de protección de datos.</li>
</ul>
<h2>2. IDENTIFICACIÓN DE LAS PARTES</h2>
<p><strong>El Prestador:</strong> METRANSFERS GESTION SL, con NIF B22522353 y domicilio social en AVDA MARE DE DEU DE MONTSERRAT, NUM 18, PLANTA 5, PUERTA 2, 08970 SANT JOAN DESPÍ (BARCELONA).</p>
<p><strong>El Cliente:</strong> Persona física o jurídica que formaliza la reserva y garantiza tener capacidad legal para contratar.</p>
<h2>3. OBLIGACIÓN DE NOTIFICACIÓN Y REQUISITOS DEL SERVICIO</h2>
<p>Para garantizar la seguridad y legalidad del transporte, el Cliente tiene la obligación inexcusable de declarar las siguientes necesidades en el formulario de reserva:</p>
<h3>3.1. Sistemas de Retención Infantil (SRI)</h3>
<p>Conforme al Artículo 117 del Reglamento General de Circulación, es obligatorio el uso de sillas homologadas para menores de estatura igual o inferior a 135 cm. El Cliente debe seleccionar el número y tipo de sillas necesarias en el formulario. La omisión de este dato facultará al conductor a denegar el servicio por razones de seguridad, sin derecho a reembolso.</p>
<h3>3.2. Equipaje Extraordinario</h3>
<p>La capacidad del vehículo está limitada por su ficha técnica. El transporte de maletas adicionales, material deportivo (golf, esquí) o bultos voluminosos debe ser notificado. EL PRESTADOR se reserva el derecho de cobrar suplementos o denegar el transporte si el volumen excede la capacidad del maletero del vehículo contratado.</p>
<h3>3.3. Transporte de Mascotas</h3>
<p>El transporte de animales domésticos está sujeto a notificación previa y debe realizarse en trasportines homologados proporcionados por el cliente, salvo acuerdo en contrario. Los perros guía viajarán sin coste adicional conforme a la normativa vigente.</p>
<h2>4. PASARELA DE PAGO Y SEGURIDAD (REDSYS)</h2>
<p>El pago de los servicios se efectuará mediante tarjeta de crédito o débito a través de la pasarela de pago segura Redsys.</p>
<ul>
<li><strong>Seguridad:</strong> El sistema utiliza protocolos de encriptación SSL y autenticación 3D Secure (Verified by Visa / Mastercard ID Check).</li>
<li><strong>Confirmación:</strong> El contrato se perfecciona en el momento en que EL PRESTADOR recibe la confirmación de la autorización de pago por parte de la entidad bancaria.</li>
<li><strong>Fraude:</strong> EL PRESTADOR se reserva el derecho de anular cualquier transacción ante sospechas de uso fraudulento de tarjetas.</li>
</ul>
<h2>5. DERECHO DE DESISTIMIENTO Y POLÍTICA DE CANCELACIÓN</h2>
<p>En virtud del Artículo 103 l) del Real Decreto Legislativo 1/2007, el derecho de desistimiento no será aplicable a los servicios de transporte de pasajeros si el contrato prevé una fecha o un periodo de ejecución específicos. No obstante, EL PRESTADOR ofrece las siguientes condiciones comerciales:</p>
<ul>
<li><strong>Cancelación con &gt;24 horas:</strong> Devolución del 100% del importe mediante el mismo sistema de pago (Redsys).</li>
<li><strong>Cancelación con &lt;24 horas o No-Show:</strong> Penalización del 100% del valor de la reserva.</li>
<li><strong>Retrasos de vuelos:</strong> EL PRESTADOR monitoriza los vuelos. No obstante, si el retraso excede los 90 minutos sobre la hora prevista, el servicio quedará sujeto a disponibilidad de flota, pudiendo incurrir en gastos de espera adicionales.</li>
</ul>
<h2>6. RESPONSABILIDAD LIMITADA</h2>
<p>EL PRESTADOR no será responsable por incumplimientos derivados de:</p>
<ul>
<li>Fuerza mayor o causas fortuitas (cortes de carretera, condiciones climáticas adversas, huelgas generales).</li>
<li>Errores en los datos facilitados por el cliente en el formulario de reserva (ej. fecha errónea o número de teléfono incorrecto).</li>
<li>Incumplimiento de las normas de seguridad por parte de los pasajeros (uso de cinturón, comportamiento disruptivo).</li>
</ul>
<h2>7. JURISDICCIÓN Y LEY APLICABLE</h2>
<p>Para la resolución de cualquier litigio derivado de la interpretación o ejecución de este contrato, las partes se someten a la legislación española. En caso de controversia, se recurrirá a los Juzgados y Tribunales de Barcelona, salvo que el cliente ostente la condición de consumidor, en cuyo caso se atenderá a la competencia territorial establecida por ley.</p>',
        'aviso-legal' => '<h2>1. INFORMACIÓN IDENTIFICATIVA</h2>
<p>En cumplimiento con el deber de información recogido en el artículo 10 de la Ley 34/2002, de 11 de julio, de Servicios de la Sociedad de la Información y del Comercio Electrónico (LSSI-CE), a continuación se reflejan los siguientes datos:</p>
<p><strong>Titular del sitio web:</strong> METRANSFERS GESTION SL</p>
<p><strong>NIF:</strong> B22522353</p>
<p><strong>Domicilio Social:</strong> AVDA MARE DE DEU DE MONTSERRAT, NUM 18, PLANTA 5, PUERTA 2, 08970 SANT JOAN DESPÍ &ndash; (BARCELONA)</p>
<p><strong>Correo electrónico de contacto:</strong> <a href="mailto:info@metransfers.es">info@metransfers.es</a></p>
<p><strong>Actividad:</strong> Transporte de viajeros y gestión de servicios turísticos.</p>
<h2>2. CONDICIONES DE USO</h2>
<p>El acceso y/o uso de este portal atribuye la condición de USUARIO, que acepta, desde dicho acceso y/o uso, las Condiciones Generales de Uso aquí reflejadas.</p>
<p>El sitio web proporciona acceso a informaciones, servicios o datos (en adelante, &ldquo;los contenidos&rdquo;) en Internet pertenecientes a METRANSFERS GESTION SL. El USUARIO asume la responsabilidad del uso del portal. Dicha responsabilidad se extiende al registro que fuese necesario para acceder a determinados servicios o contenidos (como el formulario de reservas).</p>
<h2>3. PROPIEDAD INTELECTUAL E INDUSTRIAL</h2>
<p>METRANSFERS GESTION SL es titular de todos los derechos de propiedad intelectual e industrial de su página web, así como de los elementos contenidos en la misma (a título enunciativo: imágenes, sonido, audio, vídeo, software o textos; marcas o logotipos, combinaciones de colores, estructura y diseño, selección de materiales usados, programas de ordenador necesarios para su funcionamiento, acceso y uso, etc.).</p>
<p>En virtud de lo dispuesto en los artículos 8 y 32.1, párrafo segundo, de la Ley de Propiedad Intelectual, quedan expresamente prohibidas la reproducción, la distribución y la comunicación pública, incluida su modalidad de puesta a disposición, de la totalidad o parte de los contenidos de esta página web, con fines comerciales, en cualquier soporte y por cualquier medio técnico, sin la autorización de METRANSFERS GESTION SL.</p>
<h2>4. EXCLUSIÓN DE GARANTÍAS Y RESPONSABILIDAD</h2>
<p>EL PRESTADOR no se hace responsable, en ningún caso, de los daños y perjuicios de cualquier naturaleza que pudieran ocasionar, a título enunciativo: errores u omisiones en los contenidos, falta de disponibilidad del portal o la transmisión de virus o programas maliciosos o lesivos en los contenidos, a pesar de haber adoptado todas las medidas tecnológicas necesarias para evitarlo.</p>
<h2>5. MODIFICACIONES</h2>
<p>METRANSFERS GESTION SL se reserva el derecho de efectuar sin previo aviso las modificaciones que considere oportunas en su portal, pudiendo cambiar, suprimir o añadir tanto los contenidos y servicios que se presten a través de la misma como la forma en la que éstos aparezcan presentados o localizados en su portal.</p>
<h2>6. ENLACES (LINKS)</h2>
<p>En el caso de que en el sitio web se dispusiesen enlaces o hipervínculos hacía otros sitios de Internet, METRANSFERS GESTION SL no ejercerá ningún tipo de control sobre dichos sitios y contenidos. En ningún caso asumirá responsabilidad alguna por los contenidos de algún enlace perteneciente a un sitio web ajeno.</p>
<h2>7. DERECHO DE EXCLUSIÓN</h2>
<p>METRANSFERS GESTION SL se reserva el derecho a denegar o retirar el acceso al portal y/o los servicios ofrecidos sin necesidad de preaviso, a instancia propia o de un tercero, a aquellos usuarios que incumplan las presentes Condiciones Generales de Uso.</p>
<h2>8. PROTECCIÓN DE DATOS</h2>
<p>Todo lo relativo a la política de protección de datos se encuentra recogido en el documento de Política de Privacidad de la entidad, conforme al Reglamento (UE) 2016/679 (RGPD) y la Ley Orgánica 3/2018 (LOPDGDD).</p>
<h2>9. LEGISLACIÓN APLICABLE Y JURISDICCIÓN</h2>
<p>La relación entre METRANSFERS GESTION SL y el USUARIO se regirá por la normativa española vigente y cualquier controversia se someterá a los Juzgados y Tribunales de la ciudad de Barcelona.</p>'
    );

    foreach ( $pages as $slug => $content ) {
        $page = get_page_by_path( $slug, OBJECT, 'page' );
        if ( $page && empty( trim( $page->post_content ) ) ) {
            wp_update_post( array(
                'ID' => $page->ID,
                'post_content' => $content
            ) );
        }
    }

    update_option( 'me_transfers_content_migrated_legal', true );
}
if ( defined( 'ME_TRANSFERS_ENABLE_MIGRATIONS' ) && ME_TRANSFERS_ENABLE_MIGRATIONS ) {
	add_action( 'admin_init', 'me_transfers_migrate_legal_to_editor' );
}


/* ==========================================================================
   FASE 2: WPO, METADATOS Y REDIRECCIONES
   ========================================================================== */

// 1. Optimización WPO: Forzar WebP como formato de salida y forzar lazy load
add_filter( 'image_editor_output_format', function( $formats ) {
    $formats['image/jpeg'] = 'image/webp';
    $formats['image/png']  = 'image/webp';
    return $formats;
});

add_filter( 'wp_get_attachment_image_attributes', function( $attr, $attachment, $size ) {
    if ( ! isset( $attr['loading'] ) ) {
        $attr['loading'] = 'lazy';
    }
    return $attr;
}, 10, 3 );

// 2. Limpieza de Metadatos: Forzar Título y Descripción Global para Home
add_filter( 'pre_get_document_title', function( $title ) {
    if ( is_front_page() || is_home() ) {
        return 'MeTransfers | Traslados Privados y Tours VIP en Barcelona';
    }
    return $title;
}, 999 );

add_action( 'wp_head', function() {
    // Only output meta description if Yoast SEO is NOT active (avoids duplication).
    if ( ( is_front_page() || is_home() ) && ! defined( 'WPSEO_VERSION' ) && ! function_exists( 'the_seo_framework' ) ) {
        echo '<meta name="description" content="Traslados Privados y Tours VIP en Barcelona. Reserva tu servicio de chófer privado en MeTransfers para un viaje seguro, cómodo y exclusivo.">' . "\n";
    }
}, 1 );

// 3.1b: Filtros de integracion con Yoast SEO para titulo y meta description del home.
// Si Yoast esta activo, usar sus filtros nativos evita duplicar etiquetas SEO.
if ( defined( 'WPSEO_VERSION' ) ) {
    add_filter( 'wpseo_title', function( $title ) {
        if ( is_front_page() || is_home() ) {
            return 'MeTransfers | Traslados Privados y Tours VIP en Barcelona';
        }
        return $title;
    } );

    add_filter( 'wpseo_metadesc', function( $desc ) {
        if ( is_front_page() || is_home() ) {
            return 'Traslados Privados y Tours VIP en Barcelona. Reserva tu servicio de chofer privado en MeTransfers.';
        }
        return $desc;
    } );
}

// 3. Motor de Redirecciones 301 y 410 (Páginas Muertas)
add_action( 'template_redirect', 'me_transfers_custom_redirects' );
function me_transfers_custom_redirects() {
    if ( is_404() ) {
        $requested_url = $_SERVER['REQUEST_URI'];
        
        // Array de redirecciones 301. Formato: '/url-antigua/' => '/url-nueva/'
        $redirects_301 = array(
            // '/ejemplo-url-rota/' => '/tours/',
        );

        foreach ( $redirects_301 as $old => $new ) {
            if ( strpos( $requested_url, $old ) !== false ) {
                wp_redirect( home_url( $new ), 301 );
                exit;
            }
        }
        
        // Array de páginas 410 (Gone) para purga de contenido zombi
        $gone_urls = array(
            // '/pagina-eliminada-permanentemente/'
        );
        
        foreach ( $gone_urls as $gone ) {
            if ( strpos( $requested_url, $gone ) !== false ) {
                global $wp_query;
                $wp_query->set_404();
                status_header( 410 );
                nocache_headers();
                return;
            }
        }
    }
}


