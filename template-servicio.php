<?php
/**
 * Template Name: Página de Servicio
 *
 * Template inteligente para todas las páginas de servicios de MeTransfers.
 * Detecta el slug de la página y carga el contenido, formulario y diseño
 * específico de cada servicio.
 *
 * @package Me_Transfers
 */

// Import Material Symbols for icons
add_action('wp_head', function() {
    echo '<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet" />';
});

get_header();

global $post;
$service = me_transfers_get_current_service( $post );

// Si no se detecta un servicio, mostrar el contenido normal de la página.
if ( ! $service ) {
	?>
	<main id="primary" class="site-main">
		<section class="section container" style="padding-top: 6rem;">
			<?php while ( have_posts() ) : the_post(); the_content(); endwhile; ?>
		</section>
	</main>
	<?php
	get_footer();
	return;
}

$form_type = $service['form_type'];
$form_id   = 'svc-form-' . esc_attr( $form_type );
?>

<style>
/* ─────────────────────────────────────────────────────────────────────────────
   SERVICE PAGE STYLES - TWO COLUMN LAYOUT
   ───────────────────────────────────────────────────────────────────────────── */

/* General Elements */
.material-symbols-outlined {
	font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
}

/* Hero Section */
.svc-hero {
	position: relative;
	background: linear-gradient(135deg, #0B1F35 0%, #0d3b6e 60%, #112a4a 100%);
	padding: 7rem 0 5rem;
	overflow: hidden;
}
.svc-hero::before {
	content: '';
	position: absolute; inset: 0;
	background: radial-gradient(ellipse at 70% 50%, rgba(30,100,200,0.18) 0%, transparent 70%);
	pointer-events: none;
}
.svc-hero-badge {
	display: inline-flex;
	align-items: center;
	gap: 8px;
	background: rgba(255,255,255,0.1);
	border: 1px solid rgba(255,255,255,0.2);
	color: #90cdf4;
	font-size: 13px;
	font-weight: 600;
	letter-spacing: 0.06em;
	text-transform: uppercase;
	padding: 6px 16px;
	border-radius: 50px;
	margin-bottom: 1.5rem;
}
.svc-hero-badge::before {
	content: '';
	width: 8px; height: 8px;
	background: #63b3ed;
	border-radius: 50%;
	display: inline-block;
	animation: pulse-dot 2s infinite;
}
@keyframes pulse-dot {
	0%, 100% { opacity: 1; transform: scale(1); }
	50% { opacity: 0.5; transform: scale(1.3); }
}
.svc-hero h1 {
	color: #fff;
	font-size: clamp(2rem, 5vw, 3.2rem);
	font-weight: 800;
	line-height: 1.15;
	margin-bottom: 1.25rem;
	max-width: 780px;
}
.svc-hero-sub {
	color: #90cdf4;
	font-size: 1.25rem;
	font-weight: 500;
	margin-bottom: 1.25rem;
}
.svc-hero-desc {
	color: #cbd5e1;
	font-size: 1.1rem;
	line-height: 1.75;
	max-width: 650px;
}
.svc-hero-cta-group {
	display: flex;
	flex-wrap: wrap;
	gap: 1rem;
	margin-top: 2.5rem;
	align-items: center;
}

/* Two Column Layout */
.svc-layout {
	display: grid;
	grid-template-columns: 1.5fr 1fr;
	gap: 4rem;
	padding: 4rem 0 6rem;
	align-items: start;
}
@media (max-width: 1024px) {
	.svc-layout {
		grid-template-columns: 1fr;
		gap: 3rem;
	}
	.svc-sidebar {
		order: -1; /* Mueve el formulario arriba en móviles/tablets */
	}
}

/* Main Content Column */
.svc-main {
	display: flex;
	flex-direction: column;
	gap: 4rem;
}

/* Content Blocks */
.svc-block h2 {
	font-size: clamp(1.6rem, 2.5vw, 2.2rem);
	font-weight: 800;
	color: #0B1F35; /* Dark blue contrast on white/light grey */
	line-height: 1.2;
	margin-bottom: 1.5rem;
}
.svc-label {
	font-size: 12px;
	font-weight: 700;
	letter-spacing: 0.1em;
	text-transform: uppercase;
	color: #1e40af;
	margin-bottom: 0.75rem;
	display: block;
}
.svc-desc-text {
	font-size: 1.05rem;
	line-height: 1.9;
	color: #334155;
}
.svc-desc-text p { margin-bottom: 1.25rem; }

/* Features */
.svc-features-grid {
	display: grid;
	grid-template-columns: repeat(2, 1fr);
	gap: 1.5rem;
}
@media (max-width: 600px) {
	.svc-features-grid { grid-template-columns: 1fr; }
}
.svc-feature-card {
	background: #f8fafc;
	border-radius: 16px;
	padding: 1.75rem;
	border: 1px solid #e2e8f0;
	transition: border-color 0.25s, box-shadow 0.25s, transform 0.25s;
}
.svc-feature-card:hover {
	border-color: #3b82f6;
	box-shadow: 0 8px 30px rgba(59,130,246,0.1);
	transform: translateY(-3px);
}
.svc-feature-icon {
	color: #2563eb;
	font-size: 2rem !important;
	margin-bottom: 1rem;
	display: block;
}
.svc-feature-card h3 {
	font-size: 1.1rem;
	font-weight: 700;
	color: #0B1F35;
	margin-bottom: 0.5rem;
}
.svc-feature-card p {
	font-size: 0.95rem;
	color: #64748b;
	line-height: 1.6;
}

/* Steps */
.svc-steps-grid {
	display: grid;
	gap: 1.5rem;
	counter-reset: step;
}
.svc-step {
	display: flex;
	gap: 1.5rem;
	padding: 1.5rem;
	border-radius: 16px;
	background: #fff;
	border: 1px solid #e2e8f0;
}
.svc-step-number {
	font-size: 2.5rem;
	font-weight: 900;
	color: #bfdbfe;
	line-height: 1;
	font-family: 'Outfit', sans-serif;
	flex-shrink: 0;
}
.svc-step h3 {
	font-size: 1.1rem;
	font-weight: 700;
	color: #0B1F35;
	margin-bottom: 0.5rem;
}
.svc-step p {
	font-size: 0.95rem;
	color: #64748b;
	line-height: 1.6;
}

/* Sidebar / Form */
.svc-sidebar {
	position: sticky;
	top: 100px;
}
.svc-form-box {
	background: #fff;
	border-radius: 20px;
	padding: 2.5rem;
	box-shadow: 0 10px 40px rgba(0,0,0,0.08);
	border: 1px solid #e2e8f0;
}
.svc-form-box h2 {
	color: #0B1F35;
	font-size: 1.6rem;
	font-weight: 800;
	margin-bottom: 0.5rem;
}
.svc-form-box .svc-form-sub {
	color: #64748b;
	margin-bottom: 2rem;
	font-size: 0.95rem;
	line-height: 1.5;
}
.svc-form-row {
	display: grid;
	grid-template-columns: 1fr;
	gap: 1.25rem;
	margin-bottom: 1.25rem;
}
.svc-form-row.two-cols {
	grid-template-columns: 1fr 1fr;
}
@media (max-width: 640px) {
	.svc-form-row.two-cols { grid-template-columns: 1fr; }
	.svc-form-box { padding: 1.5rem; }
}
.sfg {
	display: flex;
	flex-direction: column;
	gap: 6px;
}
.sfg label {
	font-size: 13px;
	font-weight: 600;
	color: #1e293b;
	letter-spacing: 0.02em;
}
.sfg input,
.sfg select,
.sfg textarea {
	width: 100%;
	padding: 12px 16px;
	border: 1.5px solid #e2e8f0;
	border-radius: 10px;
	font: 400 15px 'Inter', sans-serif;
	color: #1e293b;
	background: #f8fafc;
	transition: border-color 0.2s, box-shadow 0.2s;
	box-sizing: border-box;
}
.sfg input:focus,
.sfg select:focus,
.sfg textarea:focus {
	outline: none;
	border-color: #3b82f6;
	box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
	background: #fff;
}
.sfg textarea { resize: vertical; min-height: 110px; }
.svc-gdpr {
	display: flex;
	gap: 12px;
	align-items: flex-start;
	margin-bottom: 1.5rem;
	margin-top: 0.5rem;
}
.svc-gdpr input[type="checkbox"] { margin-top: 3px; flex-shrink: 0; }
.svc-gdpr label { font-size: 13px; color: #64748b; line-height: 1.5; }
.svc-gdpr a { color: #3b82f6; }
.svc-submit-btn {
	width: 100%;
	padding: 16px;
	background: linear-gradient(135deg, #1e40af, #2563eb);
	color: #fff;
	border: none;
	border-radius: 12px;
	font: 700 16px 'Inter', sans-serif;
	cursor: pointer;
	transition: opacity 0.2s, transform 0.2s, box-shadow 0.2s;
	display: flex;
	align-items: center;
	justify-content: center;
	gap: 10px;
	box-shadow: 0 4px 20px rgba(37,99,235,0.3);
}
.svc-submit-btn:hover {
	opacity: 0.93;
	transform: translateY(-1px);
	box-shadow: 0 8px 28px rgba(37,99,235,0.4);
}
.svc-submit-btn:disabled { opacity: 0.65; cursor: not-allowed; transform: none; }
.svc-form-ok {
	display: none;
	background: #f0fdf4;
	border: 1px solid #86efac;
	color: #166534;
	border-radius: 10px;
	padding: 16px 20px;
	margin-top: 1.25rem;
	font-weight: 600;
	text-align: center;
}
.svc-form-ok.active { display: block; }
.svc-form-divider {
	border: none;
	border-top: 1.5px solid #e2e8f0;
	margin: 1.5rem 0;
}
.svc-form-section-title {
	font-size: 13px;
	font-weight: 700;
	color: #1e40af;
	text-transform: uppercase;
	letter-spacing: 0.08em;
	margin-bottom: 1rem;
	display: flex;
	align-items: center;
	gap: 8px;
}
</style>

<main id="primary" class="site-main">

	<!-- ═══ HERO ════════════════════════════════════════════════════════════════ -->
	<section class="svc-hero">
		<div class="container">
			<div class="svc-hero-badge"><?php echo esc_html( $service['badge'] ); ?></div>
			<h1><?php echo esc_html( $service['title'] ); ?></h1>
			<p class="svc-hero-sub"><?php echo esc_html( $service['subtitle'] ); ?></p>
			<p class="svc-hero-desc"><?php echo esc_html( $service['hero_desc'] ); ?></p>
			<div class="svc-hero-cta-group">
				<?php
				$cta_href = '#solicitar';
				if ( ! in_array( $service['slug'], array( 'corporativo-y-eventos', 'vehiculos-para-grupos' ), true ) ) {
					$cta_href = me_transfers_get_section_url( 'search' );
				}
				?>
				<a href="<?php echo esc_url( $cta_href ); ?>" class="btn btn-solid" style="background:linear-gradient(135deg,#1e40af,#2563eb);color:#fff;border:none;padding:14px 32px;font-size:15px;border-radius:10px;">
					<?php echo esc_html( $service['cta_text'] ); ?>
				</a>
				<button class="btn js-wa-trigger" style="background:#25d366;color:#fff;border:none;padding:14px 28px;font-size:15px;border-radius:10px;display:flex;align-items:center;gap:8px;cursor:pointer;">
					<span class="material-symbols-outlined" aria-hidden="true">chat</span>
					WhatsApp
				</button>
			</div>
		</div>
	</section>

	<div class="svc-layout container">

		<!-- ═══ COLUMNA PRINCIPAL: CONTENIDO ════════════════════════════════════ -->
		<div class="svc-main">
			
			<!-- DESCRIPCIÓN COMPLETA -->
			<div class="svc-block">
				<span class="svc-label">Sobre este servicio</span>
				<h2><?php echo esc_html( $service['subtitle'] ); ?></h2>
				<div class="svc-desc-text">
					<?php
					$paragraphs = explode( "\n\n", $service['desc_long'] );
					foreach ( $paragraphs as $p ) {
						echo '<p>' . nl2br( esc_html( trim( $p ) ) ) . '</p>';
					}
					?>
				</div>
			</div>

			<!-- BENEFICIOS -->
			<div class="svc-block">
				<span class="svc-label">¿Por qué elegir MeTransfers?</span>
				<h2>Todo lo que necesitas, incluido</h2>
				<div class="svc-features-grid">
					<?php foreach ( $service['features'] as $feat ) : ?>
					<div class="svc-feature-card">
						<span class="material-symbols-outlined svc-feature-icon"><?php echo esc_attr( $feat['icon'] ); ?></span>
						<h3><?php echo esc_html( $feat['title'] ); ?></h3>
						<p><?php echo esc_html( $feat['desc'] ); ?></p>
					</div>
					<?php endforeach; ?>
				</div>
			</div>

			<!-- CÓMO FUNCIONA -->
			<div class="svc-block">
				<span class="svc-label">El proceso</span>
				<h2>Así de sencillo es reservar</h2>
				<div class="svc-steps-grid">
					<?php foreach ( $service['steps'] as $step ) : ?>
					<div class="svc-step">
						<div class="svc-step-number"><?php echo esc_html( $step['n'] ); ?></div>
						<div>
							<h3><?php echo esc_html( $step['title'] ); ?></h3>
							<p><?php echo esc_html( $step['desc'] ); ?></p>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
			</div>

		</div><!-- .svc-main -->

		<!-- ═══ BARRA LATERAL: FORMULARIO ═══════════════════════════════════════ -->
		<div class="svc-sidebar" id="solicitar">
			<div class="svc-form-box">
				<h2>Solicita presupuesto</h2>
				<p class="svc-form-sub">Rellena el formulario y te respondemos en menos de 2 horas — o al instante por WhatsApp.</p>

				<form id="<?php echo esc_attr( $form_id ); ?>" class="svc-form" data-service="<?php echo esc_attr( $form_type ); ?>">

					<!-- Campos comunes: Nombre, Email, Teléfono -->
					<p class="svc-form-section-title">
						<span class="material-symbols-outlined" aria-hidden="true" style="font-size:18px;">person</span>
						Tus datos
					</p>
					<div class="svc-form-row">
						<div class="sfg">
							<label for="<?php echo esc_attr( $form_id ); ?>-nombre">Nombre completo *</label>
							<input type="text" id="<?php echo esc_attr( $form_id ); ?>-nombre" name="nombre" placeholder="Ej: Juan García" required>
						</div>
					</div>
					<div class="svc-form-row two-cols">
						<div class="sfg">
							<label for="<?php echo esc_attr( $form_id ); ?>-telefono">Teléfono *</label>
							<input type="tel" id="<?php echo esc_attr( $form_id ); ?>-telefono" name="telefono" placeholder="+34 600 000 000" required>
						</div>
						<div class="sfg">
							<label for="<?php echo esc_attr( $form_id ); ?>-email">Email</label>
							<input type="email" id="<?php echo esc_attr( $form_id ); ?>-email" name="email" placeholder="tu@email.com">
						</div>
					</div>

					<hr class="svc-form-divider">

					<!-- ── Campos específicos por tipo de servicio ── -->

					<?php if ( $form_type === 'aeropuerto' ) : ?>
					<p class="svc-form-section-title">
						<span class="material-symbols-outlined" aria-hidden="true" style="font-size:18px;">flight</span>
						Detalles del traslado
					</p>
					<div class="svc-form-row two-cols">
						<div class="sfg">
							<label for="<?php echo esc_attr( $form_id ); ?>-vuelo">Nº de vuelo</label>
							<input type="text" id="<?php echo esc_attr( $form_id ); ?>-vuelo" name="extra_vuelo" placeholder="Ej: VY1234">
						</div>
						<div class="sfg">
							<label for="<?php echo esc_attr( $form_id ); ?>-fecha">Fecha *</label>
							<input type="date" id="<?php echo esc_attr( $form_id ); ?>-fecha" name="extra_fecha" required>
						</div>
					</div>
					<div class="svc-form-row two-cols">
						<div class="sfg">
							<label for="<?php echo esc_attr( $form_id ); ?>-hora">Hora recogida</label>
							<input type="time" id="<?php echo esc_attr( $form_id ); ?>-hora" name="extra_hora">
						</div>
						<div class="sfg">
							<label for="<?php echo esc_attr( $form_id ); ?>-direccion">Origen / Destino</label>
							<input type="text" id="<?php echo esc_attr( $form_id ); ?>-direccion" name="extra_direccion" placeholder="Hotel o dirección">
						</div>
					</div>
					<div class="svc-form-row two-cols">
						<div class="sfg">
							<label for="<?php echo esc_attr( $form_id ); ?>-pasajeros">Pasajeros</label>
							<select id="<?php echo esc_attr( $form_id ); ?>-pasajeros" name="extra_pasajeros">
								<option value="">Selecciona...</option>
								<?php for ( $i = 1; $i <= 10; $i++ ) : ?>
								<option value="<?php echo $i; ?>"><?php echo $i; ?> pasajero<?php echo $i > 1 ? 's' : ''; ?></option>
								<?php endfor; ?>
							</select>
						</div>
						<div class="sfg">
							<label for="<?php echo esc_attr( $form_id ); ?>-maletas">Maletas grandes</label>
							<select id="<?php echo esc_attr( $form_id ); ?>-maletas" name="extra_maletas">
								<option value="">Selecciona...</option>
								<option>1</option><option>2</option><option>3</option>
								<option>4</option><option>5+</option>
							</select>
						</div>
					</div>

					<?php elseif ( $form_type === 'puerto' ) : ?>
					<p class="svc-form-section-title">
						<span class="material-symbols-outlined" aria-hidden="true" style="font-size:18px;">directions_boat</span>
						Detalles del traslado
					</p>
					<div class="svc-form-row">
						<div class="sfg">
							<label for="<?php echo esc_attr( $form_id ); ?>-barco">Nombre del barco / crucero</label>
							<input type="text" id="<?php echo esc_attr( $form_id ); ?>-barco" name="extra_barco" placeholder="Ej: MSC Grandiosa">
						</div>
					</div>
					<div class="svc-form-row two-cols">
						<div class="sfg">
							<label for="<?php echo esc_attr( $form_id ); ?>-fecha">Fecha *</label>
							<input type="date" id="<?php echo esc_attr( $form_id ); ?>-fecha" name="extra_fecha" required>
						</div>
						<div class="sfg">
							<label for="<?php echo esc_attr( $form_id ); ?>-terminal">Terminal</label>
							<select id="<?php echo esc_attr( $form_id ); ?>-terminal" name="extra_terminal">
								<option value="">No lo sé aún</option>
								<option>Adossat A</option><option>Adossat B</option>
								<option>Adossat C</option><option>Adossat D</option>
								<option>Drassanes</option><option>Otra</option>
							</select>
						</div>
					</div>
					<div class="svc-form-row two-cols">
						<div class="sfg">
							<label for="<?php echo esc_attr( $form_id ); ?>-pasajeros">Pasajeros</label>
							<select id="<?php echo esc_attr( $form_id ); ?>-pasajeros" name="extra_pasajeros">
								<option value="">Selecciona...</option>
								<?php for ( $i = 1; $i <= 10; $i++ ) : ?>
								<option value="<?php echo $i; ?>"><?php echo $i; ?> pasajero<?php echo $i > 1 ? 's' : ''; ?></option>
								<?php endfor; ?>
							</select>
						</div>
						<div class="sfg">
							<label for="<?php echo esc_attr( $form_id ); ?>-origen">Origen / Destino</label>
							<input type="text" id="<?php echo esc_attr( $form_id ); ?>-origen" name="extra_origen" placeholder="Ej: Aeropuerto T1">
						</div>
					</div>

					<?php elseif ( $form_type === 'horas' ) : ?>
					<p class="svc-form-section-title">
						<span class="material-symbols-outlined" aria-hidden="true" style="font-size:18px;">schedule</span>
						Detalles del servicio
					</p>
					<div class="svc-form-row two-cols">
						<div class="sfg">
							<label for="<?php echo esc_attr( $form_id ); ?>-fecha">Fecha *</label>
							<input type="date" id="<?php echo esc_attr( $form_id ); ?>-fecha" name="extra_fecha" required>
						</div>
						<div class="sfg">
							<label for="<?php echo esc_attr( $form_id ); ?>-hora">Hora de inicio</label>
							<input type="time" id="<?php echo esc_attr( $form_id ); ?>-hora" name="extra_hora">
						</div>
					</div>
					<div class="svc-form-row two-cols">
						<div class="sfg">
							<label for="<?php echo esc_attr( $form_id ); ?>-horas">Horas estimadas</label>
							<select id="<?php echo esc_attr( $form_id ); ?>-horas" name="extra_horas">
								<option value="">Selecciona...</option>
								<option>3 horas</option><option>4 horas</option><option>5 horas</option>
								<option>6 horas</option><option>8 horas</option>
								<option>10 horas (día completo)</option>
							</select>
						</div>
						<div class="sfg">
							<label for="<?php echo esc_attr( $form_id ); ?>-partida">Punto de partida</label>
							<input type="text" id="<?php echo esc_attr( $form_id ); ?>-partida" name="extra_partida" placeholder="Hotel o dirección">
						</div>
					</div>
					<div class="svc-form-row">
						<div class="sfg">
							<label for="<?php echo esc_attr( $form_id ); ?>-plan">Descripción del plan</label>
							<textarea id="<?php echo esc_attr( $form_id ); ?>-plan" name="extra_plan" placeholder="Describe las paradas..."></textarea>
						</div>
					</div>

					<?php elseif ( $form_type === 'corporativo' ) : ?>
					<p class="svc-form-section-title">
						<span class="material-symbols-outlined" aria-hidden="true" style="font-size:18px;">business_center</span>
						Detalles del evento
					</p>
					<div class="svc-form-row two-cols">
						<div class="sfg">
							<label for="<?php echo esc_attr( $form_id ); ?>-empresa">Empresa</label>
							<input type="text" id="<?php echo esc_attr( $form_id ); ?>-empresa" name="extra_empresa" placeholder="Nombre de tu empresa">
						</div>
						<div class="sfg">
							<label for="<?php echo esc_attr( $form_id ); ?>-tipo-evento">Tipo de evento</label>
							<select id="<?php echo esc_attr( $form_id ); ?>-tipo-evento" name="extra_tipo_evento">
								<option value="">Selecciona...</option>
								<option>Congreso / Feria</option>
								<option>Reunión ejecutiva</option>
								<option>Incentivo</option>
								<option>Otro</option>
							</select>
						</div>
					</div>
					<div class="svc-form-row two-cols">
						<div class="sfg">
							<label for="<?php echo esc_attr( $form_id ); ?>-vehiculos">Vehículos</label>
							<select id="<?php echo esc_attr( $form_id ); ?>-vehiculos" name="extra_vehiculos">
								<option value="">Selecciona...</option>
								<option>1 vehículo</option><option>2 vehículos</option>
								<option>3-5 vehículos</option><option>Más de 5</option>
							</select>
						</div>
						<div class="sfg">
							<label for="<?php echo esc_attr( $form_id ); ?>-fecha">Fecha inicio *</label>
							<input type="date" id="<?php echo esc_attr( $form_id ); ?>-fecha" name="extra_fecha" required>
						</div>
					</div>
					<div class="svc-form-row">
						<div class="sfg">
							<label for="<?php echo esc_attr( $form_id ); ?>-descripcion">Descripción</label>
							<textarea id="<?php echo esc_attr( $form_id ); ?>-descripcion" name="extra_descripcion" placeholder="Horarios, rutas..."></textarea>
						</div>
					</div>

					<?php elseif ( $form_type === 'tours' ) : ?>
					<p class="svc-form-section-title">
						<span class="material-symbols-outlined" aria-hidden="true" style="font-size:18px;">map</span>
						Detalles del tour
					</p>
					<div class="svc-form-row">
						<div class="sfg">
							<label for="<?php echo esc_attr( $form_id ); ?>-destino">Tour de interés</label>
							<select id="<?php echo esc_attr( $form_id ); ?>-destino" name="extra_destino">
								<option value="">Selecciona...</option>
								<option>Montserrat</option>
								<option>Costa Brava</option>
								<option>Girona + Costa Brava</option>
								<option>Tarragona Romana</option>
								<option>Sitges y Penedès</option>
								<option>Barcelona City Tour</option>
								<option>Ruta personalizada</option>
							</select>
						</div>
					</div>
					<div class="svc-form-row two-cols">
						<div class="sfg">
							<label for="<?php echo esc_attr( $form_id ); ?>-fecha">Fecha *</label>
							<input type="date" id="<?php echo esc_attr( $form_id ); ?>-fecha" name="extra_fecha" required>
						</div>
						<div class="sfg">
							<label for="<?php echo esc_attr( $form_id ); ?>-personas">Personas</label>
							<select id="<?php echo esc_attr( $form_id ); ?>-personas" name="extra_personas">
								<option value="">Selecciona...</option>
								<?php for ( $i = 1; $i <= 8; $i++ ) : ?>
								<option value="<?php echo $i; ?>"><?php echo $i; ?> persona<?php echo $i > 1 ? 's' : ''; ?></option>
								<?php endfor; ?>
							</select>
						</div>
					</div>
					<div class="svc-form-row">
						<div class="sfg">
							<label for="<?php echo esc_attr( $form_id ); ?>-idioma">Idioma preferido</label>
							<select id="<?php echo esc_attr( $form_id ); ?>-idioma" name="extra_idioma">
								<option>Español</option><option>Inglés</option><option>Francés</option><option>Otro</option>
							</select>
						</div>
					</div>

					<?php elseif ( $form_type === 'grupos' ) : ?>
					<p class="svc-form-section-title">
						<span class="material-symbols-outlined" aria-hidden="true" style="font-size:18px;">groups</span>
						Detalles del grupo
					</p>
					<div class="svc-form-row">
						<div class="sfg">
							<label for="<?php echo esc_attr( $form_id ); ?>-grupo">Nombre del grupo</label>
							<input type="text" id="<?php echo esc_attr( $form_id ); ?>-grupo" name="extra_grupo" placeholder="Ej: Boda García">
						</div>
					</div>
					<div class="svc-form-row two-cols">
						<div class="sfg">
							<label for="<?php echo esc_attr( $form_id ); ?>-tipo-evento">Tipo de evento</label>
							<select id="<?php echo esc_attr( $form_id ); ?>-tipo-evento" name="extra_tipo_evento">
								<option value="">Selecciona...</option>
								<option>Boda</option><option>Cumpleaños</option>
								<option>Incentivo de empresa</option><option>Excursión</option><option>Otro</option>
							</select>
						</div>
						<div class="sfg">
							<label for="<?php echo esc_attr( $form_id ); ?>-personas">Personas</label>
							<select id="<?php echo esc_attr( $form_id ); ?>-personas" name="extra_personas">
								<option value="">Selecciona...</option>
								<option>8-15 personas</option><option>15-30 personas</option>
								<option>30-50 personas</option><option>Más de 50</option>
							</select>
						</div>
					</div>
					<div class="svc-form-row">
						<div class="sfg">
							<label for="<?php echo esc_attr( $form_id ); ?>-fecha">Fecha del evento *</label>
							<input type="date" id="<?php echo esc_attr( $form_id ); ?>-fecha" name="extra_fecha" required>
						</div>
					</div>
					<div class="svc-form-row">
						<div class="sfg">
							<label for="<?php echo esc_attr( $form_id ); ?>-descripcion">Servicio necesario</label>
							<textarea id="<?php echo esc_attr( $form_id ); ?>-descripcion" name="extra_descripcion" placeholder="Origen, destino, horarios..."></textarea>
						</div>
					</div>

					<?php endif; ?>

					<!-- Mensaje adicional -->
					<div class="svc-form-row">
						<div class="sfg">
							<label for="<?php echo esc_attr( $form_id ); ?>-mensaje">Comentarios adicionales</label>
							<textarea id="<?php echo esc_attr( $form_id ); ?>-mensaje" name="mensaje" placeholder="Cualquier detalle adicional..."></textarea>
						</div>
					</div>

					<!-- GDPR -->
					<div class="svc-gdpr">
						<input type="checkbox" id="<?php echo esc_attr( $form_id ); ?>-gdpr" required>
						<label for="<?php echo esc_attr( $form_id ); ?>-gdpr">
							He leído y acepto la <a href="<?php echo esc_url( home_url( '/politica-de-privacidad' ) ); ?>" target="_blank">Política de Privacidad</a>.
						</label>
					</div>

					<button type="submit" class="svc-submit-btn">
						<span class="material-symbols-outlined" aria-hidden="true">send</span>
						<?php echo esc_html( $service['cta_text'] ); ?>
					</button>

					<div class="svc-form-ok" id="<?php echo esc_attr( $form_id ); ?>-ok">
						<span class="material-symbols-outlined" aria-hidden="true" style="vertical-align: middle; margin-right: 5px;">check_circle</span>
						¡Solicitud enviada! Te responderemos muy pronto.
					</div>

				</form>
			</div>
		</div><!-- .svc-sidebar -->

	</div><!-- .svc-layout -->

</main><!-- #primary -->

<script>
(function() {
	var form = document.getElementById('<?php echo esc_js( $form_id ); ?>');
	if (!form) return;

	form.addEventListener('submit', function(e) {
		e.preventDefault();

		var btn = form.querySelector('.svc-submit-btn');
		var ok  = document.getElementById('<?php echo esc_js( $form_id ); ?>-ok');
		var orig = btn.innerHTML;
		btn.innerHTML = '<span class="material-symbols-outlined" aria-hidden="true" style="animation: spin 1s linear infinite;">hourglass_empty</span> Enviando...';
		btn.disabled = true;

		var data = new FormData(form);
		data.append('action',   'mt_save_lead');
		data.append('security', (window.mtAjax && mtAjax.nonce) ? mtAjax.nonce : '');
		data.append('origen',   'formulario-<?php echo esc_js( $form_type ); ?>');
		data.append('servicio', '<?php echo esc_js( $service['title'] ); ?>');

		// Collect extra fields into the message
		var extras = [];
		['extra_vuelo','extra_fecha','extra_hora','extra_direccion','extra_pasajeros',
		 'extra_maletas','extra_barco','extra_terminal','extra_origen',
		 'extra_horas','extra_partida','extra_plan','extra_empresa','extra_tipo_evento',
		 'extra_vehiculos','extra_descripcion','extra_destino','extra_personas',
		 'extra_idioma','extra_grupo'].forEach(function(key){
			var el = form.querySelector('[name="' + key + '"]');
			if (el && el.value.trim()) {
				extras.push(key.replace('extra_','').replace(/_/g,' ').replace(/\b\w/g,l=>l.toUpperCase()) + ': ' + el.value.trim());
			}
		});
		var baseMensaje = (data.get('mensaje') || '').trim();
		var fullMensaje = (extras.length ? extras.join('\n') + '\n\n' : '') + baseMensaje;
		data.set('mensaje', fullMensaje);

		var url = (window.mtAjax && mtAjax.ajaxurl) ? mtAjax.ajaxurl : '/wp-admin/admin-ajax.php';

		fetch(url, { method: 'POST', body: data })
			.then(function(r){ return r.json(); })
			.then(function(res){
				if (ok) { ok.classList.add('active'); }
				form.reset();
			})
			.catch(function(){
				if (ok) { ok.classList.add('active'); }
			})
			.finally(function(){
				btn.innerHTML = orig;
				btn.disabled = false;
				if (ok) { ok.scrollIntoView({behavior:'smooth', block:'center'}); }
			});
	});
})();
</script>
<style>
@keyframes spin { 100% { transform: rotate(360deg); } }
</style>

<?php get_footer(); ?>
