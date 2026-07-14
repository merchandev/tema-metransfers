<?php
/**
 * 404 - Página no encontrada
 * Sigue las pautas de Google para páginas de error 404:
 *  – Devuelve HTTP 404 (WordPress lo hace automáticamente para este template)
 *  – Ofrece navegación útil para que el usuario encuentre lo que busca
 *  – No indexada por los motores de búsqueda (noindex via wp_head)
 *  – Diseño consistente con el resto del sitio
 *
 * @package Me_Transfers
 */

// Garantizar que la respuesta HTTP sea 404
if ( ! headers_sent() ) {
    status_header( 404 );
}

get_header();
?>

<main id="primary" class="site-main" role="main" aria-label="<?php esc_attr_e( 'Página no encontrada', 'me-transfers' ); ?>">

    <section class="error-404 not-found section-404">

        <!-- Fondo estrellado animado -->
        <div class="error-404-bg" aria-hidden="true">
            <div class="stars-layer stars-layer--sm"></div>
            <div class="stars-layer stars-layer--md"></div>
            <div class="error-404-glow error-404-glow--left"></div>
            <div class="error-404-glow error-404-glow--right"></div>
        </div>

        <div class="container error-404-inner">

            <!-- Número 404 gigante -->
            <div class="error-404-number" aria-hidden="true">
                <span class="error-404-digit">4</span>
                <span class="error-404-zero">
                    <img
                        class="error-404-car"
                        src="<?php echo esc_url( add_query_arg( 'v', (string) filemtime( get_template_directory() . '/assets/icons/404.svg' ), get_template_directory_uri() . '/assets/icons/404.svg' ) ); ?>"
                        alt=""
                        loading="eager"
                        decoding="async"
                    >
                </span>

                <span class="error-404-digit">4</span>
            </div>

            <!-- Contenido textual -->
            <div class="error-404-content">

                <p class="error-404-badge">ERROR 404</p>

                <h1 class="error-404-title">
                    <?php esc_html_e( 'Página no encontrada', 'me-transfers' ); ?>
                </h1>

                <p class="error-404-desc">
                    <?php esc_html_e( 'La página que buscas no existe o ha sido movida. No te preocupes — puedes reservar tu traslado desde aquí o explorar nuestros servicios.', 'me-transfers' ); ?>
                </p>

                <!-- Acciones principales -->
                <div class="error-404-actions">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary error-404-cta">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        <?php esc_html_e( 'Volver al inicio', 'me-transfers' ); ?>
                    </a>
                    <a href="<?php echo esc_url( me_transfers_get_section_url( 'search' ) ); ?>" class="btn btn-glass error-404-cta">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <?php esc_html_e( 'Reservar traslado', 'me-transfers' ); ?>
                    </a>
                </div>

                <!-- Búsqueda rápida del sitio -->
                <div class="error-404-search">
                    <p class="error-404-search-label"><?php esc_html_e( 'O busca en nuestro sitio:', 'me-transfers' ); ?></p>
                    <?php
                    get_search_form();
                    ?>
                </div>

                <!-- Links de navegación útiles -->
                <nav class="error-404-nav" aria-label="<?php esc_attr_e( 'Páginas sugeridas', 'me-transfers' ); ?>">
                    <p class="error-404-nav-label"><?php esc_html_e( 'Páginas populares:', 'me-transfers' ); ?></p>
                    <ul class="error-404-nav-list">
                        <li>
                            <a href="<?php echo esc_url( me_transfers_get_section_url( 'search' ) ); ?>">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="5 12 3 12 12 3 21 12 19 12"/><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-7"/></svg>
                                <?php esc_html_e( 'Traslados al Aeropuerto', 'me-transfers' ); ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url( me_transfers_get_section_url( 'tours' ) ); ?>">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                                <?php esc_html_e( 'Tours Privados', 'me-transfers' ); ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url( home_url( '/blog' ) ); ?>">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                <?php esc_html_e( 'Blog', 'me-transfers' ); ?>
                            </a>
                        </li>
                        <li>
                            <a href="mailto:info@metransfers.es">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                <?php esc_html_e( 'Contacto', 'me-transfers' ); ?>
                            </a>
                        </li>
                    </ul>
                </nav>

            </div><!-- .error-404-content -->

        </div><!-- .error-404-inner -->

    </section><!-- .error-404 -->

</main><!-- #primary -->

<?php get_footer(); ?>


