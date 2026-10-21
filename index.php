<?php
if (file_exists(__DIR__ . '/honeybot_shield.php')) { require_once __DIR__ . '/honeybot_shield.php'; }
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('America/Hermosillo');

$telefono_whatsapp = "526622971128"; 
$telefono_llamadas = "6622170995";   

$estudio_url = isset($_GET['estudio']) ? strtolower($_GET['estudio']) : 'general';

switch ($estudio_url) {
    case 'metabolico':
        $msg_hero = "Hola, necesito más información sobre el Check Up Metabólico.";
        break;
    case 'checkup2':
        $msg_hero = "Hola, necesito más información sobre el Check Up 2.";
        break;
    case 'tiroideo':
        $msg_hero = "Hola, necesito más información sobre el Perfil Tiroideo.";
        break;
    case 'prostatico':
        $msg_hero = "Hola, necesito más información sobre el Antígeno Prostático.";
        break;
    default:
        $msg_hero = "Hola, vengo de laboratoriosanfrancisco.com, ¿Me podrían brindar más información sobre sus servicios?";
        break;
}
$link_hero = "https://wa.me/" . $telefono_whatsapp . "?text=" . urlencode($msg_hero);

$link_metabolico   = "https://wa.me/" . $telefono_whatsapp . "?text=" . urlencode("Hola, necesito más información sobre el Check Up Metabólico.");
$link_checkup2     = "https://wa.me/" . $telefono_whatsapp . "?text=" . urlencode("Hola, necesito más información sobre el Check Up 2.");
$link_individuales = "https://wa.me/" . $telefono_whatsapp . "?text=" . urlencode("Hola, necesito más información sobre estudios individuales a domicilio.");
$link_card_centro  = "https://wa.me/" . $telefono_whatsapp . "?text=" . urlencode("Hola, necesito más información específica sobre la Sucursal Centro.");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- SOLUSOL INTELLIGENCE CENTER (SIC) - SENSOR DE TELEMETRÍA Y ATRIBUCIÓN ADSOLUSOL -->
    <script>
      window.SOLUSOL_CONFIG = {
        siteKey: 'sol_live_da5077366ee996a2',
        domain: 'laboratoriosanfrancisco.com',
        endpoint: 'https://solusol.net/api/v1/telemetry.php'
      };
    </script>
    <script src="https://solusol.net/public/sensor.php?key=sol_live_da5077366ee996a2" async></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Laboratorio Clínico San Francisco en Hermosillo. Más de 34 años ofreciendo análisis clínicos precisos, radiología digital y especialidad en toma pediátrica.">
    <title>Laboratorio San Francisco | Análisis Clínicos y Radiología en Hermosillo</title>

    <link rel="canonical" href="https://laboratoriosanfrancisco.com/" />

    <!-- PRELOAD LCP IMAGE -->
    <link rel="preload" as="image" href="images/urgente.jpg" fetchpriority="high">

    <!-- BLOQUE COMPLETO DE FAVICONS -->
    <link rel="apple-touch-icon" sizes="57x57" href="images/favicon/apple-icon-57x57.png?v=2">
    <link rel="apple-touch-icon" sizes="60x60" href="images/favicon/apple-icon-60x60.png?v=2">
    <link rel="apple-touch-icon" sizes="72x72" href="images/favicon/apple-icon-72x72.png?v=2">
    <link rel="apple-touch-icon" sizes="76x76" href="images/favicon/apple-icon-76x76.png?v=2">
    <link rel="apple-touch-icon" sizes="114x114" href="images/favicon/apple-icon-114x114.png?v=2">
    <link rel="apple-touch-icon" sizes="120x120" href="images/favicon/apple-icon-120x120.png?v=2">
    <link rel="apple-touch-icon" sizes="144x144" href="images/favicon/apple-icon-144x144.png?v=2">
    <link rel="apple-touch-icon" sizes="152x152" href="images/favicon/apple-icon-152x152.png?v=2">
    <link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-icon-180x180.png?v=2">
    <link rel="icon" type="image/png" sizes="192x192" href="images/favicon/android-icon-192x192.png?v=2">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png?v=2">
    <link rel="icon" type="image/png" sizes="96x96" href="images/favicon/favicon-96x96.png?v=2">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png?v=2">
    <link rel="manifest" href="images/favicon/manifest.json?v=2">
    
    <meta name="msapplication-TileColor" content="#1e3a8a">
    <meta name="msapplication-TileImage" content="images/favicon/ms-icon-144x144.png?v=2">
    <meta name="theme-color" content="#1e3a8a">

    <!-- GTAG CARGADO CON DEFER PARA EVITAR TOTAL BLOCKING TIME (TBT) -->
    <script src="https://www.googletagmanager.com/gtag/js?id=AW-944260655" defer></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'AW-944260655');
    </script>

    <style>
        :root {
            --primary-color: #1e3a8a; 
            --secondary-color: #0d746d; 
            --accent-color: #f59e0b; 
            --text-dark: #1f2937;
            --text-light: #ffffff;
            --bg-light: #f3f4f6;
            --card-bg: #ffffff;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', system-ui, sans-serif; scroll-behavior: smooth; }
        body { background-color: var(--bg-light); color: var(--text-dark); line-height: 1.6; }
        header { background-color: var(--card-bg); box-shadow: 0 4px 6px rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 1000; }
        .nav-container { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 10px 20px; }
        .logo-img { height: 55px; width: 220px; object-fit: contain; }
        nav ul { display: flex; list-style: none; gap: 10px; }
        nav a { text-decoration: none; color: var(--text-dark); font-weight: 600; font-size: 14px; padding: 8px 12px; border-radius: 6px; transition: 0.3s; cursor: pointer; white-space: nowrap; }
        nav a:hover, nav a.active-menu { color: white; background-color: var(--primary-color); }

        .menu-toggle {
            display: none;
            flex-direction: column;
            justify-content: space-between;
            width: 30px;
            height: 21px;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 0;
            z-index: 1010;
        }
        .menu-toggle span { width: 100%; height: 3px; background-color: var(--primary-color); border-radius: 2px; transition: all 0.3s ease-in-out; }
        .menu-toggle.open span:nth-child(1) { transform: rotate(45deg) translate(5px, 5px); }
        .menu-toggle.open span:nth-child(2) { opacity: 0; }
        .menu-toggle.open span:nth-child(3) { transform: rotate(-45deg) translate(5px, -6px); }

        .hero { background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%); color: var(--text-light); padding: 50px 20px; }
        .hero-grid { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: 1fr; gap: 30px; align-items: center; }
        .badge { background-color: var(--accent-color); color: #000000; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: bold; display: inline-block; margin-bottom: 15px; }
        .hero h1 { font-size: 32px; margin-bottom: 15px; line-height: 1.2; }
        .hero p { font-size: 16px; margin-bottom: 25px; opacity: 0.95; }
        .hero-image-slot { width: 100%; height: 340px; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 20px rgba(0,0,0,0.2); }
        .hero-image-slot img { width: 100%; height: 100%; object-fit: cover; }

        .cta-group { display: flex; flex-direction: column; gap: 12px; }
        .btn { display: flex; align-items: center; justify-content: center; padding: 12px 24px; border-radius: 30px; text-decoration: none; font-weight: bold; font-size: 15px; transition: 0.2s; }
        .btn-whatsapp { background-color: #128c7e; color: #ffffff; }
        .btn-primary { background-color: var(--secondary-color); color: #ffffff; }
        .btn-maps { background-color: #ffffff; color: var(--primary-color); border: 2px solid var(--primary-color); font-size: 13px; padding: 8px 16px; }

        .section { padding: 50px 20px; max-width: 1200px; margin: 0 auto; }
        .section-title { text-align: center; margin-bottom: 35px; color: var(--primary-color); font-size: 26px; }
        .section-title::after { content: ''; display: block; width: 50px; height: 4px; background-color: var(--secondary-color); margin: 8px auto 0; border-radius: 2px; }

        .quienes-layout { display: grid; grid-template-columns: 1fr; gap: 30px; align-items: start; }
        .quienes-img-box { width: 100%; height: auto; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .quienes-img-box img { width: 100%; height: 100%; object-fit: cover; display: block; }

        .features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; }
        .feature-card { background-color: var(--card-bg); padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); border-top: 4px solid var(--primary-color); display: flex; flex-direction: column; justify-content: space-between; }
        .feature-image-slot { width: 100%; height: 180px; border-radius: 8px; margin-bottom: 15px; overflow: hidden; background-color: #eaeef4; display: flex; align-items: center; justify-content: center; }
        .feature-image-slot img { width: 100%; height: 100%; object-fit: cover; }
        .feature-card h3 { color: var(--primary-color); margin-bottom: 10px; font-size: 17px; text-align: center; font-weight: bold; }

        .packages-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; }
        .package-card { background-color: var(--card-bg); border: 1px solid #e5e7eb; border-radius: 14px; padding: 25px 20px; text-align: center; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 4px 10px rgba(0,0,0,0.02); }
        .package-card.featured { border: 2px solid var(--secondary-color); position: relative; }
        .package-tag { position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background-color: var(--primary-color); color: #ffffff; padding: 4px 14px; font-size: 11px; font-weight: bold; border-radius: 20px; text-transform: uppercase; }
        .package-card h3 { color: var(--primary-color); font-size: 19px; margin-bottom: 10px; }
        .package-price { font-size: 30px; font-weight: bold; margin-bottom: 20px; }
        .package-list { list-style: none; text-align: left; margin-bottom: 20px; font-size: 14px; }
        .package-list li { margin-bottom: 8px; padding-left: 20px; position: relative; }
        .package-list li::before { content: '🧪'; position: absolute; left: 0; font-size: 12px; }

        .branches-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px; }
        .branch-card { background-color: var(--card-bg); border-radius: 12px; box-shadow: 0 4px 8px rgba(0,0,0,0.03); padding: 20px; display: flex; flex-direction: column; justify-content: space-between; border-top: 5px solid var(--primary-color); }
        .branch-image-slot { width: 100%; height: 280px; border-radius: 8px; margin-bottom: 15px; overflow: hidden; background-color: #eaeef4; }
        .branch-card h3 { color: var(--primary-color); margin-bottom: 10px; font-size: 18px; }
        .branch-card p { font-size: 14px; margin-bottom: 6px; }

        .blog-section { background-color: #ffffff; border-top: 1px solid #e5e7eb; padding: 50px 20px; }
        .blog-container { max-width: 1000px; margin: 0 auto; }
        .blog-text { font-size: 15px; color: #2d3748; text-align: justify; line-height: 1.7; }

        details { background-color: var(--card-bg); padding: 12px 20px; border-radius: 8px; margin-bottom: 10px; cursor: pointer; }
        summary { font-weight: bold; color: var(--primary-color); text-align: center; list-style-position: inside; }
        details p { margin-top: 8px; font-size: 14px; color: #4b5563; border-left: 3px solid var(--secondary-color); padding-left: 10px; text-align: center; }
        
        footer { background-color: #0f172a; color: #cbd5e1; padding: 35px 20px; text-align: center; font-size: 14px; border-top: 4px solid var(--secondary-color); }
        .legal-box { background-color: #1e293b; padding: 12px; border-radius: 6px; margin-top: 20px; color: #cbd5e1; font-size: 12px; text-align: left; border-left: 3px solid var(--accent-color); max-width: 800px; margin: 20px auto 0; }

        @media (min-width: 992px) {
            .hero-grid { grid-template-columns: 1fr 1fr; }
            .hero h1 { font-size: 38px; }
            .cta-group { flex-direction: row; }
            .btn { flex: 1; }
            .quienes-layout { grid-template-columns: 1fr 1.2fr; align-items: center; }
        }

        @media (max-width: 991px) {
            .menu-toggle { display: flex; }
            nav {
                display: none; position: absolute; top: 100%; left: 0; width: 100%; background-color: var(--card-bg); box-shadow: 0 8px 16px rgba(0,0,0,0.1); padding: 15px; box-sizing: border-box; z-index: 999;
            }
            nav.mobile-open { display: block; }
            nav ul { flex-direction: column; gap: 8px; width: 100%; align-items: stretch; }
            nav a { display: block; width: 100%; text-align: center; padding: 12px; font-size: 16px; white-space: normal; box-sizing: border-box; }
        }
    </style>
</head>
<body>

    <div style="background-color: var(--accent-color); color: #000000; text-align: center; padding: 10px 15px; font-size: 14px; font-weight: bold; box-shadow: 0 2px 10px rgba(0,0,0,0.1); position: relative; z-index: 1001; line-height: 1.4;">
        ⏱️ ¡Servicios Urgentes con Resultados en 1 Hora! <a id="btn-como-llegar-ads" style="color: #1e3a8a; text-decoration: underline; font-weight: 800; margin-left: 6px; cursor: pointer;">Presiona aquí para ver Ubicación y Cómo Llegar</a>
    </div>

    <header>
        <div class="nav-container">
            <a id="btn-logo" style="cursor:pointer;" aria-label="Ir al inicio"><img src="images/logo.jpg" alt="Laboratorio San Francisco Logo" class="logo-img" width="220" height="55"></a>
            <button class="menu-toggle" id="menu-toggle" aria-label="Abrir menú de navegación">
                <span></span><span></span><span></span>
            </button>
            <nav id="nav-menu" aria-label="Navegación principal">
                <ul>
                    <li><a id="btn-inicio" class="active-menu">Inicio</a></li>
                    <li><a id="btn-quienes">Quiénes Somos</a></li>
                    <li><a id="btn-checkups">Check-Ups</a></li>
                    <li><a id="btn-salud">Salud y Prevención</a></li>
                    <li><a id="btn-ubicaciones">Ubicaciones</a></li>
                    <li><a href="https://radiologiasanfrancisco.com.mx">Radiología</a></li>
                    <li><a href="https://quirogasanfrancisco.com">Sucursal Quiroga</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main id="main-content">

        <section id="inicio" class="hero">
            <div class="hero-grid">
                <div class="hero-content">
                    <span class="badge">⏱️ SERVICIOS URGENTES CON RESULTADOS EN 1 HORA</span>
                    <h1>Más de 34 Años Ofrecer un Servicio de Excelencia</h1>
                    <p>Contamos con tecnología automatizada de alta precisión y máxima rapidez para el cuidado de tu salud en Hermosillo.</p>
                    <div class="cta-group">
                        <a href="<?php echo $link_hero; ?>" class="btn btn-whatsapp" target="_blank" data-solusol-tag="whatsapp_conversion" aria-label="Cotizar Análisis Clínicos por WhatsApp">💬 Cotizar Análisis Clínicos</a>
                        <a href="tel:<?php echo $telefono_llamadas; ?>" class="btn btn-primary" data-solusol-tag="phone_conversion" aria-label="Llamar directo a Sucursal Centro">📞 Llamar Directo (Centro)</a>
                    </div>
                    <p style="font-size: 16px; margin-top: 22px; opacity: 1; font-weight: 700; color: #fbbf24; text-align: left; line-height: 1.4;">
                        ✨ Tu salud en manos de expertos: Resultados rápidos, confiables y con la mejor atención de Hermosillo.
                    </p>
                </div>
                <div class="hero-image-slot">
                    <img src="images/urgente.jpg" alt="Resultados de análisis clínicos en 1 hora" width="600" height="340" fetchpriority="high">
                </div>
            </div>
        </section>

        <section class="section" id="quienes-somos" style="padding-top: 40px; padding-bottom: 20px;">
            <div class="blog-container">
                <div class="branch-card" style="background: #ffffff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.02); border-top: 5px solid var(--primary-color);">
                    <div class="quienes-layout">
                        <div class="quienes-img-box">
                            <img src="images/quienes_somos.jpg" alt="Matriz Sucursal Centro Laboratorio San Francisco" width="500" height="350" loading="lazy">
                        </div>
                        <div class="blog-text">
                            <h2 style="color: var(--primary-color); font-size: 24px; margin-bottom: 12px; font-weight: bold; text-align: left;">Quiénes Somos</h2>
                            <p style="font-size: 15px; color: var(--text-dark); text-align: justify; line-height: 1.7; margin-bottom: 20px;">
                                En Laboratorio San Francisco nos dedicamos a ofrecer servicios de diagnóstico clínico con los más altos estándares de precisión y calidez humana. Avalados por más de 34 años de trayectoria en Sonora, nuestra matriz Centro ofrece la máxima tecnología automatizada en Hermosillo, garantizando la entrega de tus resultados el mismo día con total seguridad.
                            </p>
                            <div style="height: 1px; background-color: #e5e7eb; margin: 20px 0;"></div>
                            <h3 style="color: var(--primary-color); font-size: 19px; margin-bottom: 15px; font-weight: bold; text-align: left;">Laboratorio San Francisco te ofrece:</h3>
                            <ul style="list-style: none; padding: 0; font-size: 15px; color: var(--text-dark); text-align: left;">
                                <li style="margin-bottom: 12px; padding-left: 25px; position: relative; line-height: 1.5;">
                                    <span style="position: absolute; left: 0; color: var(--secondary-color); font-weight: bold;">✔</span><strong>Máxima Precisión Clínica:</strong> Análisis clínicos completamente automatizados respaldados por tecnología de punta.
                                </li>
                                <li style="margin-bottom: 12px; padding-left: 25px; position: relative; line-height: 1.5;">
                                    <span style="position: absolute; left: 0; color: var(--secondary-color); font-weight: bold;">✔</span><strong>Check-Ups a Tu Alcance:</strong> Paquetes preventivos diseñados específicamente para proteger tu salud y tu economía.
                                </li>
                                <li style="margin-bottom: 12px; padding-left: 25px; position: relative; line-height: 1.5;">
                                    <span style="position: absolute; left: 0; color: var(--secondary-color); font-weight: bold;">✔</span><strong>Atención Profesional y Segura:</strong> Personal calificado para garantizarte una toma de muestra rápida, cómoda y sin dolor.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section">
            <h2 class="section-title">¿Por Qué Confiar en Nosotros?</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-image-slot"><img src="images/Domicilio.jpg" alt="Servicio a Domicilio de Toma de Muestras" width="300" height="180" loading="lazy"></div>
                    <h3>🚘 Servicio a Domicilio</h3>
                    <p>Llevamos el laboratorio hasta la puerta de tu casa u oficina. Agenda tu cita y nuestro personal asistirá con total puntualidad y equipo esterilizado.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-image-slot"><img src="images/tecnologia.jpg" alt="Tecnología de Vanguardia en Análisis Clínicos" width="300" height="180" loading="lazy"></div>
                    <h3>🧪 Máxima Precisión y Rapidez</h3>
                    <p>Nuestros procesos automatizados garantizan un servicio médico confiable, con entrega el mismo día en la mayoría de tus estudios.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-image-slot"><img src="images/Pantallazo 10-07-2026 13.33.00.png" alt="Atención Humana y Personalizada" width="300" height="180" loading="lazy"></div>
                    <h3>💉 Personal Altamente Capacitado</h3>
                    <p>Como dicen nuestros pacientes de "venas difíciles": con nosotros vas a la segura, sin dolor y con trato humano y cercano.</p>
                </div>
            </div>
        </section>

        <section id="checkups" class="section" style="background-color: #ffffff; max-width: 100%; border-top: 1px solid #e5e7eb;">
            <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
                <h2 class="section-title">Nuestros Check-Ups Actuales</h2>
                <div class="packages-grid">
                    <div class="package-card featured">
                        <span class="package-tag">El Más Completo</span>
                        <h3>Check Up Metabólico</h3>
                        <div class="package-price">$800.00 <span>MXN</span></div>
                        <ul class="package-list">
                            <li>Biometría Hemática</li><li>Examen General de Orina</li><li>Glucosa, Urea y Creatinina</li><li>Ácido Úrico y Triglicéridos</li><li>Colesterol HDL (Bueno)</li><li>Colesterol LDL (Malo)</li><li>Perfil Hepático Completo</li>
                        </ul>
                        <a href="<?php echo $link_metabolico; ?>" class="btn btn-whatsapp" target="_blank" data-solusol-tag="whatsapp_conversion" aria-label="Consultar Requisitos del Check Up Metabólico por WhatsApp">💬 Consultar Requisitos</a>
                    </div>
                    <div class="package-card">
                        <h3>Check Up 2</h3>
                        <div class="package-price">$500.00 <span>MXN</span></div>
                        <ul class="package-list">
                            <li>Biometría Hemática</li><li>Examen General de Orina</li><li>Glucosa, Urea y Creatinina</li><li>Ácido Úrico y Triglicéridos</li><li>Colesterol HDL (Bueno)</li><li>Colesterol LDL (Malo)</li>
                        </ul>
                        <a href="<?php echo $link_checkup2; ?>" class="btn btn-whatsapp" target="_blank" data-solusol-tag="whatsapp_conversion" aria-label="Consultar Requisitos del Check Up 2 por WhatsApp">💬 Consultar Requisitos</a>
                    </div>
                    <div class="package-card">
                        <h3>Estudios Individuales</h3>
                        <div class="package-price">Precios <span>Especiales</span></div>
                        <ul class="package-list">
                            <li>🧪 <strong>Perfil Tiroideo:</strong> $350.00</li><li>🧪 <strong>Antígeno Prostático:</strong> $270.00</li><li>🚘 <strong>Servicio a Domicilio:</strong> Disponible para tu comodidad.</li>
                        </ul>
                        <a href="<?php echo $link_individuales; ?>" class="btn btn-primary" target="_blank" data-solusol-tag="whatsapp_conversion" aria-label="Cotizar Otros Estudios Individuales">💬 Cotizar Otros Estudios</a>
                    </div>
                </div>
            </div>
        </section>

        <section id="quiroga" class="section" style="background-color: #f8fafc; max-width: 100%; border-top: 1px solid #e5e7eb;">
            <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
                <h2 class="section-title">Nuestras Ubicaciones</h2>
                <div class="branches-grid">
                    
                    <div class="branch-card" style="border-top: 5px solid var(--primary-color);">
                        <div class="branch-image-slot">
                            <iframe title="Mapa Google Maps Ubicación Sucursal Centro Laboratorio San Francisco" data-src="https://maps.google.com/maps?q=Oaxaca%2063,%20Centro,%20Hermosillo&t=&z=15&ie=UTF8&iwloc=&output=embed" width="100%" height="100%" style="border:0;" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        <div>
                            <h3>🏢 Sucursal Centro (Matriz)</h3>
                            <p><strong>📍 Dirección:</strong> Oaxaca No. 63 (Entre Guerrero y Garmendia), Colonia Centro.</p>
                            <p><strong>🕒 Horarios:</strong> Lunes a Sábado 6:00 AM a 8:00 PM | Domingo 7:00 AM a 2:00 PM</p>
                            <p><strong>📞 Teléfono:</strong> 662 217 0995</p>
                        </div>
                        <div style="margin-top: 20px;">
                            <a href="https://google.com/maps?q=Oaxaca+63,+Centro,+Hermosillo" class="btn btn-maps" target="_blank" aria-label="Abrir mapa de navegación GPS para Sucursal Centro">🗺️ Abrir en GPS Navegador</a>
                            <a href="<?php echo $link_card_centro; ?>" class="btn btn-whatsapp" style="margin-top: 10px; font-size: 14px;" target="_blank" data-solusol-tag="whatsapp_conversion" aria-label="Cotizar análisis en Sucursal Centro por WhatsApp">💬 Cotizar en Centro</a>
                        </div>
                    </div>

                    <div class="branch-card" style="border-top: 5px solid var(--secondary-color);">
                        <div class="branch-image-slot">
                            <img src="images/quiroga_fachada.jpg" alt="Fachada Sucursal Quiroga Laboratorio San Francisco" width="300" height="280" style="width:100%; height:100%; object-fit:cover;" loading="lazy">
                        </div>
                        <div>
                            <h3>📍 Sucursal Quiroga (Poniente)</h3>
                            <p><strong>📍 Dirección:</strong> Blvd. Antonio Quiroga No. 132, Colonia El Llanito.</p>
                            <p><strong>🕒 Horarios:</strong> Lunes a Sábado 7:00 AM a 7:00 PM | Domingo 7:00 AM a 2:00 PM</p>
                            <p><strong>📞 Teléfono Directo:</strong> 662 136 5325</p>
                        </div>
                        <div style="margin-top: 20px;">
                            <a href="https://quirogasanfrancisco.com" class="btn btn-primary" style="margin-top: 10px; font-size: 14px; background-color: var(--secondary-color);" aria-label="Visitar el sitio oficial de la Sucursal Quiroga">🌐 Visitar Sitio de Quiroga</a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section class="blog-section" id="salud-prevencion">
            <div class="blog-container" style="max-width: 750px;">
                <h2 class="section-title">Salud y Prevención</h2>
                <div class="branch-card" style="background: #ffffff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.02); border-top: 5px solid var(--secondary-color);">
                    <div class="blog-text">
                        <p style="font-size: 15px; color: var(--text-dark); text-align: justify; line-height: 1.7; margin: 0;">
                            El cuerpo humano es experto en ocultar síntomas. Enfermedades silenciosas como la diabetes en etapas tempranas, la hipertensión arterial, el colesterol alto o problemas de tiroides pueden pasar años desarrollándose sin dar una sola señal de alerta. La mayoría de las personas asocian el laboratorio con la enfermedad, pero el verdadero poder de la medicina está en adelantarse al problema. Un chequeo a tiempo cambia vidas.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="section" style="padding-bottom: 80px;">
            <h2 class="section-title">Indicaciones Generales</h2>
            <div class="faq-container">
                <details>
                    <summary>📋 Indicaciones de ayuno para Check-Ups</summary>
                    <p>Para el Check Up Metabólico y Check Up 2 se requiere un ayuno obligatorio de 8 a 12 horas. Durante este tiempo no se deben ingerir alimentos ni bebidas azucaradas.</p>
                </details>
            </div>
        </section>

    </main>

    <a href="tel:<?php echo $telefono_llamadas; ?>" title="Llamar directo al laboratorio" data-solusol-tag="phone_conversion" aria-label="Llamar directamente por teléfono al laboratorio" style="position: fixed !important; bottom: 25px !important; left: 25px !important; width: 68px !important; height: 68px !important; background-color: #d32f2f !important; border-radius: 50% !important; display: flex !important; align-items: center !important; justify-content: center !important; box-shadow: 0 5px 20px rgba(0,0,0,0.4) !important; z-index: 999999 !important; transition: transform 0.2s;">
        <svg viewBox="0 0 24 24" style="width: 32px; height: 32px; fill: white;"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V21c0 .55-.45 1-1 1A18 18 0 0 1 3 4c0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
    </a>

    <a href="<?php echo $link_hero; ?>" target="_blank" title="Cotizar por WhatsApp" data-solusol-tag="whatsapp_conversion" aria-label="Cotizar análisis clínicos por WhatsApp" style="position: fixed !important; bottom: 25px !important; right: 25px !important; width: 68px !important; height: 68px !important; background-color: #128c7e !important; border-radius: 50% !important; display: flex !important; align-items: center !important; justify-content: center !important; box-shadow: 0 5px 20px rgba(0,0,0,0.4) !important; z-index: 999999 !important; transition: transform 0.2s;">
        <svg viewBox="0 0 24 24" style="width: 38px; height: 38px; fill: white;"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.713-1.457L0 24zm6.59-4.846c1.6.95 3.498 1.451 5.438 1.453 5.494 0 9.961-4.47 9.965-9.964.002-2.66-1.019-5.161-2.876-7.022-1.856-1.861-4.35-2.883-7.014-2.884-5.502 0-9.972 4.47-9.975 9.965-.001 1.93.501 3.81 1.456 5.416l-.995 3.637 3.73-.978zm10.743-7.795c-.308-.154-1.82-.9-.2.083-1.047-.308-.236-.677-.323-.89-.175-.436-.78-.636-1.07-.154-.307.513-.615 1.025-.918 1.543-.242.414-.492.46-.893.266-.401-.194-1.696-.625-3.23-1.994-1.193-1.064-1.998-2.378-2.232-2.78-.234-.403-.024-.62.177-.82.18-.18.401-.467.602-.7.199-.234.266-.4.4-.667.135-.267.068-.501-.034-.709-.102-.207-.918-2.21-1.258-3.03-.33-.795-.665-.687-.918-.7-.24-.012-.516-.014-.792-.014-.276 0-.724.104-1.103.513-.379.409-1.449 1.414-1.449 3.448 0 2.034 1.48 4.001 1.686 4.277.207.276 2.915 4.451 7.059 6.241 2.29.99 3.361 1.12 4.542.945 1.204-.177 2.686-.834 3.064-1.604.377-.77.377-1.429.263-1.604-.113-.177-.417-.277-.724-.432z"/></svg>
    </a>

    <footer id="contacto-footer">
        <div class="footer-content">
            <div class="legal-box">
                <strong>⚖️ Información de Responsabilidad Sanitaria:</strong><br>
                Responsable Sanitario: Q.B. Fidel Octavio Navarro Carrillo<br>
                Profesión: Químico Biólogo con Especialidad en Análisis Clínicos (Universidad de Sonora) | Cédula Profesional: 1889542 
            </div>
            <p style="margin-top: 25px;">© 2026 Laboratorio San Francisco. Todos los derechos reservados.</p> 
            <p style="font-size: 12px; margin-top: 5px;">Hermosillo, Sonora, México.</p> 
            <p style="font-size: 11px; margin-top: 20px; opacity: 0.8; letter-spacing: 0.5px;">
                Diseño y Desarrollo por <a href="https://cmsolucionesweb.com" target="_blank" style="color: #fbbf24; text-decoration: none; font-weight: bold;">CMSoluciones Web</a> 
            </p>
        </div>
    </footer>

    <script>
    const menuToggle = document.getElementById('menu-toggle');
    const navMenu = document.getElementById('nav-menu');
    
    if (menuToggle && navMenu) {
        menuToggle.addEventListener('click', function() {
            this.classList.toggle('open');
            navMenu.classList.toggle('mobile-open');
        });
        document.querySelectorAll('nav a').forEach(link => {
            link.addEventListener('click', () => {
                menuToggle.classList.remove('open');
                navMenu.classList.remove('mobile-open');
            });
        });
    }

    function setupSmoothScroll(buttonId, targetId) {
        const element = document.getElementById(buttonId);
        if(element) {
            element.addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById(targetId).scrollIntoView({ behavior: 'smooth' });
            });
        }
    }

    setupSmoothScroll('btn-inicio', 'inicio');
    setupSmoothScroll('btn-logo', 'inicio');
    setupSmoothScroll('btn-quienes', 'quienes-somos');
    setupSmoothScroll('btn-checkups', 'checkups');
    setupSmoothScroll('btn-salud', 'salud-prevencion');
    setupSmoothScroll('btn-ubicaciones', 'quiroga');

    const btnComoLlegarAds = document.getElementById('btn-como-llegar-ads');
    if(btnComoLlegarAds) {
        btnComoLlegarAds.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('quiroga').scrollIntoView({ behavior: 'smooth' });
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        const mapIframe = document.querySelector('iframe[data-src]');
        if (mapIframe) {
            const observer = new IntersectionObserver((entries, obs) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        mapIframe.src = mapIframe.getAttribute('data-src');
                        obs.unobserve(mapIframe);
                    }
                });
            }, { rootMargin: "200px" });
            observer.observe(mapIframe);
        }
    });
    </script>
    
    <script type="text/javascript">
    var sc_project=13031790; var sc_invisible=1; var sc_security="4f67607d"; 
    </script>
    <script type="text/javascript" src="https://www.statcounter.com/counter/counter.js" async></script>
</body>
</html>