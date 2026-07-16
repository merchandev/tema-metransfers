<?php
/**
 * Plugin Name: GCT Translator (SEO Edition)
 * Plugin URI:  https://github.com/merchandev/tema-metransfers/tree/plugin/gct-translator
 * Description: Traductor Server-Side compatible con SEO. Genera rutas /en/, /fr/, /de/, /it/, /pt/ para posicionamiento internacional.
 * Version:     4.0.0
 * Author:      Arturo Merchan
 * Text Domain: gct-translator
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class GCT_Translator_SEO {

    private static $instance = null;
    public $active_languages  = ['en', 'fr', 'pt', 'de', 'it'];
    public $default_language  = 'es';

    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_filter( 'query_vars',       [ $this, 'add_query_vars' ] );
        add_action( 'init',             [ $this, 'add_rewrite_rules' ] );
        add_action( 'admin_menu',       [ $this, 'add_settings_page' ] );
        add_action( 'admin_init',       [ $this, 'register_settings' ] );
        add_action( 'wp_head',          [ $this, 'add_hreflang_tags' ], 1 );
        add_action( 'template_redirect',[ $this, 'start_translation_buffer' ], 1 );
        add_shortcode( 'google_translate', [ $this, 'language_switcher_shortcode' ] );
        add_action( 'init',             [ $this, 'maybe_flush_rules' ], 999 );
    }

    /* Auto-flush al primer uso */
    public function maybe_flush_rules() {
        if ( ! get_option( 'gct_rules_flushed_v4' ) ) {
            $this->add_rewrite_rules();
            flush_rewrite_rules();
            update_option( 'gct_rules_flushed_v4', true );
        }
    }

    /* -------------------------------------------------------
       SELECTOR DE IDIOMAS  [google_translate]
    ------------------------------------------------------- */
    public function language_switcher_shortcode() {
        $current_lang = get_query_var('gct_lang') ?: $this->default_language;
        $current_path = trim( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ), '/' );
        $all_langs    = array_merge( [ $this->default_language ], $this->active_languages );

        // Eliminar prefijo de idioma para obtener el slug limpio
        $segments = explode( '/', $current_path );
        if ( in_array( $segments[0], $all_langs ) ) { array_shift( $segments ); }
        $clean_path = implode( '/', $segments );

        $labels = [ 'es' => 'ES', 'en' => 'EN', 'fr' => 'FR', 'de' => 'DE', 'it' => 'IT', 'pt' => 'PT' ];

        $html  = '<div class="gct-lang-switcher">';
        $html .= '<select id="gct-lang-select" onchange="location = this.value;">';

        foreach ( $all_langs as $lang ) {
            $url = ( $lang === $this->default_language )
                ? trailingslashit( home_url( $clean_path ? '/' . $clean_path : '/' ) )
                : trailingslashit( home_url( '/' . $lang . ( $clean_path ? '/' . $clean_path : '' ) ) );

            $selected = ( $lang === $current_lang ) ? 'selected' : '';
            $label    = isset( $labels[$lang] ) ? $labels[$lang] : strtoupper($lang);
            $html    .= '<option value="' . esc_url($url) . '" ' . $selected . '>' . esc_html($label) . '</option>';
        }

        $html .= '</select></div>';
        return $html;
        // El CSS lo gestiona style.css del tema (bloque 52 .gct-lang-switcher)
    }

    /* -------------------------------------------------------
       REWRITE RULES
    ------------------------------------------------------- */
    public function add_query_vars( $vars ) {
        $vars[] = 'gct_lang';
        return $vars;
    }

    public function add_rewrite_rules() {
        $langs = implode( '|', $this->active_languages );

        // Regla 1: Home del idioma  /en/  /fr/
        add_rewrite_rule( '^(' . $langs . ')/?$', 'index.php?gct_lang=$matches[1]', 'top' );

        // Regla 2: Subpaginas  /en/tours-privados/
        add_rewrite_rule( '^(' . $langs . ')/(.+?)/?$', 'index.php?gct_lang=$matches[1]&pagename=$matches[2]', 'top' );
    }

    /* -------------------------------------------------------
       PANEL WP-ADMIN
    ------------------------------------------------------- */
    public function add_settings_page() {
        add_options_page( 'GCT Translator', 'GCT Traductor SEO', 'manage_options', 'gct-translator', [ $this, 'settings_page_html' ] );
    }

    public function register_settings() {
        register_setting( 'gct_translator_group', 'gct_api_key' );
        register_setting( 'gct_translator_group', 'gct_api_provider' );
    }

    public function settings_page_html() { ?>
        <div class="wrap">
            <h1>GCT Translator &mdash; SEO Edition</h1>
            <p>Genera rutas <code>/en/</code>, <code>/fr/</code> etc. indexables por Google. Requiere una API Key para traducir el contenido.</p>
            <form method="post" action="options.php">
                <?php settings_fields( 'gct_translator_group' ); ?>
                <table class="form-table">
                    <tr><th>Proveedor</th><td>
                        <select name="gct_api_provider">
                            <option value="deepl"  <?php selected( get_option('gct_api_provider'), 'deepl'  ); ?>>DeepL API</option>
                            <option value="google" <?php selected( get_option('gct_api_provider'), 'google' ); ?>>Google Cloud Translation</option>
                        </select>
                    </td></tr>
                    <tr><th>API Key</th><td>
                        <input type="password" name="gct_api_key" value="<?php echo esc_attr( get_option('gct_api_key') ); ?>" class="regular-text" />
                        <p class="description">Hasta que no se configure, las rutas existen pero el contenido se muestra en espanol.</p>
                    </td></tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
    <?php }

    /* -------------------------------------------------------
       HREFLANG
    ------------------------------------------------------- */
    public function add_hreflang_tags() {
        global $wp;
        $url = home_url( $wp->request );
        $cl  = get_query_var('gct_lang');
        if ( $cl ) { $url = str_replace( home_url( '/' . $cl ), home_url(), $url ); }

        echo '<link rel="alternate" hreflang="' . esc_attr($this->default_language) . '" href="' . esc_url($url) . '" />' . "\n";
        foreach ( $this->active_languages as $lang ) {
            $lurl = trailingslashit( home_url( '/' . $lang . str_replace( home_url(), '', $url ) ) );
            echo '<link rel="alternate" hreflang="' . esc_attr($lang) . '" href="' . esc_url($lurl) . '" />' . "\n";
        }
        echo '<link rel="alternate" hreflang="x-default" href="' . esc_url($url) . '" />' . "\n";
    }

    /* -------------------------------------------------------
       OUTPUT BUFFER + TRADUCCION
    ------------------------------------------------------- */
    public function start_translation_buffer() {
        if ( is_admin() || wp_doing_ajax() ) return;

        $lang = get_query_var('gct_lang');
        if ( ! $lang || ! in_array( $lang, $this->active_languages ) ) return;

        // Forzar front page cuando llega /en/ sin pagename
        if ( ! get_query_var('pagename') && ! is_front_page() ) {
            global $wp_query;
            $fid = (int) get_option('page_on_front');
            if ( $fid ) {
                $wp_query->is_page = $wp_query->is_singular = true;
                $wp_query->is_home = $wp_query->is_404 = false;
                $wp_query->post              = get_post( $fid );
                $wp_query->posts             = [ $wp_query->post ];
                $wp_query->queried_object    = $wp_query->post;
                $wp_query->queried_object_id = $fid;
                status_header(200);
            }
        }

        if ( empty( get_option('gct_api_key') ) ) return; // Sin clave, las rutas existen pero sin traducir

        ob_start( [ $this, 'process_html_translation' ] );
    }

    public function process_html_translation( $html ) {
        $lang    = get_query_var('gct_lang');
        $api_key = get_option('gct_api_key');
        if ( empty($api_key) || ! $lang ) return $html;

        // TODO: conectar DeepL/Google y cachear en wp_mt_translations
        return $html;
    }
}

/* -------------------------------------------------------
   BOOTSTRAP
------------------------------------------------------- */
add_action( 'plugins_loaded', [ 'GCT_Translator_SEO', 'get_instance' ] );

register_activation_hook( __FILE__, function() {
    GCT_Translator_SEO::get_instance()->add_rewrite_rules();

    global $wpdb;
    $sql = "CREATE TABLE {$wpdb->prefix}mt_translations (
        id            bigint(20) NOT NULL AUTO_INCREMENT,
        original_hash varchar(32) NOT NULL,
        original_text text NOT NULL,
        translated_text text NOT NULL,
        language_code varchar(10) NOT NULL,
        created_at    datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY  (id),
        UNIQUE KEY hash_lang (original_hash, language_code)
    ) " . $wpdb->get_charset_collate() . ";";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
    delete_option('gct_rules_flushed_v4');
    flush_rewrite_rules();
} );

register_deactivation_hook( __FILE__, function() {
    delete_option('gct_rules_flushed_v4');
    flush_rewrite_rules();
} );