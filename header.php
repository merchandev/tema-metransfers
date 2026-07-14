<?php
/**
 * Header - Me Transfers Premium
 * @package Me_Transfers
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

	<!-- Favicon -->
	<link rel="icon"       type="image/png" sizes="32x32" href="<?php echo esc_url( get_template_directory_uri() . '/assets/img/favicon.png' ); ?>">
	<link rel="icon"       type="image/png" sizes="16x16" href="<?php echo esc_url( get_template_directory_uri() . '/assets/img/favicon.png' ); ?>">
<?php
/**
 * Header - Me Transfers Premium
 * @package Me_Transfers
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

	<!-- Favicon -->
	<link rel="icon"       type="image/png" sizes="32x32" href="<?php echo esc_url( get_template_directory_uri() . '/assets/img/favicon.png' ); ?>">
	<link rel="icon"       type="image/png" sizes="16x16" href="<?php echo esc_url( get_template_directory_uri() . '/assets/img/favicon.png' ); ?>">
	<link rel="shortcut icon"                              href="<?php echo esc_url( get_template_directory_uri() . '/assets/img/favicon.png' ); ?>">
	<link rel="apple-touch-icon"                           href="<?php echo esc_url( get_template_directory_uri() . '/assets/img/favicon.png' ); ?>">

	<?php wp_head(); ?>
<style>.site-header .btn{min-width:0!important;width:auto!important;padding-inline:clamp(1rem,2vw,1.5rem)!important;flex-shrink:1!important} @media (max-width: 991px) { .site-header .hdr-cta { display: none !important; } .hero-container { padding-top: 0 !important; padding-inline: 0 !important; } .container { margin-left: 34px !important; margin-right: 34px !important; width: auto !important; max-width: none !important; } .hero-section { padding-top: 8.5rem !important; } .hero-badge { justify-self: center !important; margin-inline: auto !important; } .hero-content { background: linear-gradient(145deg, rgba(3, 13, 30, 0.7) 0%, rgba(3, 13, 30, 0.4) 100%) !important; padding: 2rem 1rem 1.5rem !important; border-radius: 24px !important; backdrop-filter: blur(8px) !important; -webkit-backdrop-filter: blur(8px) !important; border: 1px solid rgba(255,255,255,0.08) !important; box-shadow: 0 10px 40px rgba(0,0,0,0.5) !important; margin-bottom: 1.5rem !important; } .hero-stats { display: flex !important; justify-content: center !important; text-align: center !important; gap: 1.5rem !important; } } .hero-video-bg { position: absolute !important; top: 50% !important; left: 50% !important; width: 100vw !important; height: 56.25vw !important; max-width: none !important; max-height: none !important; transform: translate(-50%, -50%) scale(1.05) !important; pointer-events: none; z-index: 0; } @media (max-aspect-ratio: 16/9) { .hero-video-bg { height: 500vw !important; width: 888.88vw !important; } } @media (min-width: 992px) { .header-right { align-items: center !important; } .header-right .gtranslate_wrapper, .header-right .gtranslate_wrapper select, .header-right .gtranslate_wrapper a.glink, .header-right .hdr-cta { height: 44px !important; min-height: 44px !important; max-height: 44px !important; display: inline-flex !important; align-items: center !important; box-sizing: border-box !important; margin: 0 !important; } .header-right .hdr-cta { justify-content: center !important; } }</style>
<style>
  /* NUEVO DISEÑO PREMIUM PARA EL FORMULARIO (FONDO VERDE) */
  .hero-booking-card {
      background: linear-gradient(145deg, rgba(5, 33, 20, 0.85) 0%, rgba(3, 22, 12, 0.65) 100%) !important;
      backdrop-filter: blur(12px) !important;
      -webkit-backdrop-filter: blur(12px) !important;
      border: 1px solid rgba(255, 255, 255, 0.1) !important;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5) !important;
  }
.hero-booking-card h3, .hero-booking-card label, .hero-booking-card p, .hero-booking-card span {
    color: #ffffff !important;
}
body .hero-booking-card {
    background-color: transparent !important;
}
.hero-badge {
    width: fit-content !important;
    justify-self: flex-start !important;
    align-self: flex-start !important;
}
@media (max-width: 991px) {
    .hero-badge {
        justify-self: center !important;
        align-self: center !important;
    }
}
.gtranslate_wrapper { background: none !important; opacity: 0 !important; position: absolute !important; pointer-events: none !important; width: 0 !important; height: 0 !important; overflow: hidden !important; }
</style>
<script>
// FIX CERO PARPADEO BTT
if (window.location.search.indexOf('source=BTT') !== -1) {
    document.write('<style>#page { display: none !important; } .btt-global-loader { display: flex !important; }<\/' + 'style>');
}
</script>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<!-- OVERLAY BTT GLOBAL -->
<div class="btt-global-loader" style="display: none; position: fixed; inset: 0; background: linear-gradient(180deg, rgba(0, 58, 82, 0.96) 0%, rgba(5, 23, 61, 1) 100%); z-index: 999999; flex-direction: column; align-items: center; justify-content: center; color: white;">
    <style>
        .btt-spinner { width: 50px; height: 50px; border: 4px solid rgba(255,255,255,0.2); border-top-color: white; border-radius: 50%; animation: btt-spin 1s linear infinite; margin-bottom: 20px; }
        @keyframes btt-spin { 100% { transform: rotate(360deg); } }
    </style>
    <div class="btt-spinner"></div>
    <h2 style="color: white; font-weight: 300; letter-spacing: 1px;">Calculando su mejor ruta...</h2>
</div>

<div id="page" class="site">
<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'me-transfers' ); ?></a>

<header id="masthead" class="site-header" role="banner">
	<div class="container header-inner">

		<!-- ① Logo -->
		<div class="site-branding">
			<?php if ( has_custom_logo() ) :
				the_custom_logo();
			else : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo-link" rel="home" aria-label="<?php bloginfo( 'name' ); ?>">
					<img
						src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/MT - MeTransfers.png' ); ?>"
						alt="<?php bloginfo( 'name' ); ?>"
						class="site-logo-img"
						width="160"
						height="44"
						loading="eager"
						decoding="async"
					>
				</a>
			<?php endif; ?>
		</div>

		<!-- ② Nav Desktop -->
		<nav class="main-navigation" id="main-nav" aria-label="Menú principal">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'menu-1',
				'menu_id'        => 'primary-menu',
				'menu_class'     => 'nav-menu',
				'container'      => false,
				'fallback_cb'    => 'me_transfers_fallback_menu',
			) );
			?>
		</nav>

		<!-- ③ Acciones: Traductor + Botón + Hamburger -->
		<div class="header-right">

			<!-- Selector de idioma -->
			<?php if ( shortcode_exists( 'google_translate' ) ) : ?>
				<?php echo do_shortcode( '[google_translate]' ); ?>
			<?php endif; ?>

			<!-- CTA botón -->
			<a href="<?php echo esc_url( me_transfers_get_section_url( 'search' ) ); ?>" class="btn btn-primary hdr-cta">Reservar Ya</a>

			<!-- Hamburger -->
			<button class="burger" id="burger-btn" aria-label="Abrir menú" aria-controls="mob-menu" aria-expanded="false">
				<span></span><span></span><span></span>
			</button>

		</div>
	</div><!-- .header-inner -->

</header><!-- #masthead -->

<!-- Drawer mobile (Fuera del header para evitar conflictos con transform) -->
<div id="mob-menu" class="mob-menu" aria-hidden="true">
    <div class="mob-menu-inner">
        <?php
        wp_nav_menu( array(
            'theme_location' => 'menu-1',
            'menu_class'     => 'mob-nav-list',
            'container'      => false,
            'fallback_cb'    => 'me_transfers_fallback_menu',
        ) );
        ?>
        <!-- Logo en el menú mobile (oculto a SEO para no duplicar) -->
        <div class="mob-logo" aria-hidden="true">
            <img
                src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/MT - MeTransfers.png' ); ?>"
                alt=""
                width="130"
                height="36"
                loading="lazy"
            >
        </div>
        <button onclick="window.location.href='<?php echo esc_url( me_transfers_get_section_url( 'search' ) ); ?>'" class="btn btn-primary mob-menu-cta" tabindex="-1">Reservar Ya</button>
    </div>
</div>
<div id="mob-overlay" class="mob-overlay" aria-hidden="true"></div>







<style>
.custom-lang-wrapper { position: relative; font-family: 'Inter', sans-serif; display: inline-flex; }
.custom-lang-trigger { display: inline-flex; align-items: center; gap: 0.4rem; height: 44px; padding: 0 1rem; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px; color: #fff; font-size: 0.85rem; font-weight: 500; cursor: pointer; transition: all 0.2s; }
.custom-lang-trigger:hover { background: rgba(255, 255, 255, 0.15); }
.custom-lang-dropdown { position: absolute; top: calc(100% + 5px); right: 0; min-width: 180px; background: #030d1e; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 0.5rem; box-shadow: 0 10px 25px rgba(0,0,0,0.5); opacity: 0; visibility: hidden; transform: translateY(-10px); transition: all 0.2s ease; list-style: none; margin: 0; z-index: 99999; }
.custom-lang-wrapper.open .custom-lang-dropdown { opacity: 1; visibility: visible; transform: translateY(0); }
.custom-lang-dropdown li { padding: 0.6rem 1rem; color: #e4f2ff; font-size: 0.9rem; border-radius: 6px; cursor: pointer; transition: all 0.2s; text-transform: capitalize; }
.custom-lang-dropdown li:hover { background: #0077b6; color: #fff; }
</style>
<script>
document.addEventListener('DOMContentLoaded', () => {
    function initCustomLang() {
        const nativeSelect = document.querySelector('.goog-te-combo');
        if (!nativeSelect || nativeSelect.options.length < 2) {
            setTimeout(initCustomLang, 300);
            return;
        }
        if (document.querySelector('.custom-lang-wrapper')) return;
        const nativeContainer = nativeSelect.closest('.gtranslate_wrapper') || nativeSelect.closest('.lang-wrapper') || nativeSelect.parentNode;
        nativeContainer.style.opacity = '0';
        nativeContainer.style.position = 'absolute';
        nativeContainer.style.pointerEvents = 'none';
        const wrapper = document.createElement('div');
        wrapper.className = 'custom-lang-wrapper';
        wrapper.innerHTML = `<div class="custom-lang-trigger"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg><span class="lang-text">Idioma</span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-left:4px;"><polyline points="6 9 12 15 18 9"></polyline></svg></div><ul class="custom-lang-dropdown"></ul>`;
        const dropdown = wrapper.querySelector('ul');
        const triggerText = wrapper.querySelector('.lang-text');
        Array.from(nativeSelect.options).forEach(opt => {
            if (!opt.value) return;
            const li = document.createElement('li');
            li.textContent = opt.textContent;
            li.addEventListener('click', () => {
                nativeSelect.value = opt.value;
                nativeSelect.dispatchEvent(new Event('change'));
                triggerText.textContent = opt.textContent.split(' ')[0];
                wrapper.classList.remove('open');
            });
            dropdown.appendChild(li);
        });
        nativeContainer.parentNode.insertBefore(wrapper, nativeContainer.nextSibling);
        wrapper.querySelector('.custom-lang-trigger').addEventListener('click', (e) => {
            e.stopPropagation();
            wrapper.classList.toggle('open');
        });
        document.addEventListener('click', () => wrapper.classList.remove('open'));
    }
    initCustomLang();
});
</script>





















