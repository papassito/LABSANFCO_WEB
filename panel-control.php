<?php
// 🔒 CONFIGURACIÓN CORE DE LA MATRIZ MULTI-NODO

// =================================================================
// 🛡️ BÚNKER DE SEGURIDAD ANTI-BOTS (ESTRATEGIA "ONION")
// =================================================================
$es_peticion_api = isset($_GET['action']) && $_GET['action'] === 'get_live_data';

// --- CAPA 1: FILTRO DE REFERENCIA (SOLO PERMITE ACCESO DESDE SOLUSOL.NET) ---
$referer = $_SERVER['HTTP_REFERER'] ?? '';
if (!$es_peticion_api && strpos($referer, 'solusol.net') === false) {
    header("HTTP/1.1 403 Forbidden");
    echo '<h1><span style="color:red;">[ACCESO DENEGADO]</span> - Origen no autorizado.</h1>';
    exit;
}

// --- CAPA 2: DESAFÍO JAVASCRIPT (PRUEBA DE NAVEGADOR REAL) ---
$cookie_name = "auth_human_check";
if (!isset($_COOKIE[$cookie_name])) {
    // Si la cookie no existe, la creamos con JS y recargamos la página.
    // Los bots que no ejecutan JS se quedarán en un bucle o serán bloqueados.
    echo '<script>document.cookie = "'.$cookie_name.'=1; path=/; max-age=60"; window.location.reload();</script>';
    exit;
}

// --- CAPA 3: INSPECCIÓN DE USER-AGENT (BLOQUEA BOTS BÁSICOS) ---
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
if (empty($user_agent)) {
    header("HTTP/1.1 403 Forbidden");
    echo '<h1><span style="color:red;">[ACCESO DENEGADO]</span> - Identidad no válida.</h1>';
    exit;
}

header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('America/Hermosillo'); 

// ========================================================
// 📡 MODO API INVISIBLE: RESPONDE CON DATOS EN VIVO VÍA AJAX
// ========================================================
if ($es_peticion_api) {

    require_once __DIR__ . '/config.php';
    $nodo = isset($_GET['node']) ? $_GET['node'] : 'centro';
    
    // Obtener la configuración del nodo. Si no existe, usa 'centro' como fallback.
    $node_cfg = NODE_CONFIG[$nodo] ?? NODE_CONFIG['centro'];
    $archivo_json = $node_cfg['path'] . $node_cfg['logs'];
    $online_json = $node_cfg['path'] . $node_cfg['online'];

    // Lectura de base de datos plana
    $leads = file_exists($archivo_json) ? json_decode(file_get_contents($archivo_json), true) : [];
    if (!is_array($leads)) { $leads = []; } // Asegura que $leads sea un array si el JSON está corrupto o vacío
    
    // Lectura de usuarios online (Heartbeat)
    $usuarios_online = 0;
    if (file_exists($online_json)) {
        $online_data = json_decode(file_get_contents($online_json), true);
        $tiempo_limite = time() - 15;
        foreach((array)$online_data as $ip => $time) {
            if($time >= $tiempo_limite) $usuarios_online++;
        }
    }
    // Si hay datos de usuarios pero están expirados, muestra 1. Si el archivo está vacío, muestra 0.
    if ($usuarios_online == 0 && count((array)$online_data) > 0) {
        $usuarios_online = 1;
    }

    $total_trafico = count($leads);
    $clics_whatsapp = 0;
    $ordenes_correo = 0;
    $clics_llamadas = 0;
    $ultimas_ubicaciones = [];

    // Optimización: El log ya se guarda con el más nuevo al principio. No es necesario invertir el array.
    foreach ($leads as $l) {
        $accion = isset($l['tipo']) ? strtolower($l['tipo']) : (isset($l['accion']) ? strtolower($l['accion']) : '');

        // Excluimos a los bots de las métricas de conversión
        if (strpos($accion, 'bot_trapped') !== false) continue;

        if (strpos($accion, 'whatsapp') !== false) { $clics_whatsapp++; } 
        elseif (strpos($accion, 'llamada') !== false) { $clics_llamadas++; } 
        else { $ordenes_correo++; } // Cuenta formularios, clics de ads, etc.

        $ciudad = isset($l['ciudad']) ? $l['ciudad'] : (isset($l['ubicacion']) ? $l['ubicacion'] : '');
        if ($ciudad && !in_array($ciudad, $ultimas_ubicaciones) && count($ultimas_ubicaciones) < 5) {
            $ultimas_ubicaciones[] = $ciudad;
        }
    }
    if (empty($ultimas_ubicaciones)) $ultimas_ubicaciones = ['Hermosillo, Sonora'];

    header('Content-Type: application/json');
    echo json_encode([
        'total_trafico' => $total_trafico,
        'clics_whatsapp' => $clics_whatsapp,
        'ordenes_correo' => $ordenes_correo,
        'clics_llamadas' => $clics_llamadas,
        'usuarios_online' => $usuarios_online,
        'ultimas_ubicaciones' => $ultimas_ubicaciones,
        'leads' => $leads
    ]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WAR ROOM MULTI-NODO | CMSOLUCIONES V10.0</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        :root {
            --bg-base: #000000;
            --panel-bg: #09090b;
            --border-glow: #1f1f22;
            --amber: #ffb700;
            --green: #00ff41;
            --red: #ff003c;
            --blue: #00e5ff;
            --text-main: #e4e4e7;
            --text-dim: #71717a;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'JetBrains Mono', monospace; }
        body { background-color: var(--bg-base); color: var(--text-main); padding: 15px; height: 100vh; overflow: hidden; }

        .war-room-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 380px;
            grid-template-rows: auto auto auto 1fr;
            gap: 15px;
            height: 100%;
            max-width: 1920px;
            margin: 0 auto;
        }

        .panel { background-color: var(--panel-bg); border: 1px solid var(--border-glow); padding: 15px; display: flex; flex-direction: column; position: relative; }
        .panel-header { font-family: 'Share Tech Mono'; font-size: 11px; text-transform: uppercase; color: var(--text-dim); margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center;}

        /* HEADER GLOBAL */
        .header-module { grid-column: span 4; display: flex; justify-content: space-between; align-items: center; padding: 10px 15px; border-bottom: 1px solid var(--border-glow); }
        .brand-title { font-family: 'Share Tech Mono'; font-size: 18px; color: var(--text-main); letter-spacing: 2px; }
        .brand-title span { color: var(--amber); }
        
        .sys-health { display: flex; gap: 20px; align-items: center; }
        .online-badge { display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--green); border: 1px solid var(--green); padding: 4px 10px; border-radius: 2px;}
        .pulse { width: 8px; height: 8px; background-color: var(--green); border-radius: 50%; box-shadow: 0 0 8px var(--green); animation: blink 1.5s infinite; }
        @keyframes blink { 0% {opacity: 1;} 50% {opacity: 0.3;} 100% {opacity: 1;} }

        /* SELECTOR DE NODOS (TABS MULTI-SUCURSAL) */
        .node-selector {
            grid-column: span 4;
            display: flex;
            gap: 15px;
            padding-bottom: 5px;
        }
        .node-tab {
            background: #000; border: 1px solid var(--border-glow); color: var(--text-dim);
            padding: 10px 25px; font-size: 13px; cursor: pointer; text-transform: uppercase;
            font-family: 'Share Tech Mono'; font-weight: bold; letter-spacing: 1px; transition: 0.2s;
            display: flex; align-items: center; gap: 10px;
        }
        .node-tab:hover { border-color: var(--text-main); color: var(--text-main); }
        .node-tab.active-centro { background: var(--amber); color: #000; border-color: var(--amber); }
        .node-tab.active-quiroga { background: var(--green); color: #000; border-color: var(--green); }
        .node-tab.active-radiologia { background: var(--blue); color: #000; border-color: var(--blue); }
        
        .node-indicator { width: 8px; height: 8px; border-radius: 50%; background: currentColor; }

        /* KPI METRICS */
        .kpi-value { font-family: 'Share Tech Mono'; font-size: 38px; color: var(--text-main); margin-top: auto; transition: color 0.3s;}
        .kpi-sub { font-size: 10px; color: var(--text-dim); margin-top: 5px; }

        /* RADAR MAP STICKY */
        .radar-module { grid-column: 4; grid-row: 3 / 5; transition: border-color 0.3s;}
        .map-container { flex-grow: 1; border: 1px solid var(--border-glow); background: #000; position: relative; overflow: hidden; }
        
        #sat-iframe { 
            filter: grayscale(100%) invert(100%) sepia(100%) hue-rotate(0deg) saturate(400%) contrast(1.2); 
            opacity: 0.8; width: 100%; height: 100%; border: 0; transition: filter 0.5s ease;
        }
        .target-feed { margin-top: 10px; background: #000; padding: 8px; font-size: 10px; border: 1px solid var(--border-glow); color: var(--green); text-align: center; font-weight: bold;}

        /* GRAFICA */
        .chart-module { grid-column: span 2; }
        .chart-container { flex-grow: 1; width: 100%; min-height: 200px; }

        /* TERMINAL DE EVENTOS */
        .terminal-module { grid-column: 3; overflow: hidden; }
        .log-panel-box { flex-grow: 1; display: flex; flex-direction: column; overflow: hidden; background-color: #000; border: 1px solid var(--border-glow); }
        .table-wrapper { overflow-y: auto; flex-grow: 1; }
        .table-wrapper::-webkit-scrollbar { width: 4px; }
        .table-wrapper::-webkit-scrollbar-thumb { background: var(--border-glow); }
        
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { padding: 10px 12px; font-size: 10px; color: var(--text-terminal); opacity: 0.4; border-bottom: 1px solid var(--border-glow); text-transform: uppercase; }
        td { padding: 10px 12px; font-size: 11.5px; border-bottom: 1px solid #09090b; color: var(--text-terminal); }
        tbody tr:hover { background-color: #111; cursor: crosshair; }
        
        tbody tr.active-centro { background-color: #1a1400 !important; color: var(--amber); }
        tbody tr.active-quiroga { background-color: #0a1c10 !important; color: var(--green); }
        tbody tr.active-radiologia { background-color: #001829 !important; color: var(--blue); }

        .btn-export { background: transparent; border: 1px solid var(--text-dim); color: var(--text-dim); padding: 4px 10px; font-size: 10px; cursor: pointer; font-family: 'JetBrains Mono'; transition: 0.2s;}
        .btn-export:hover { background: var(--text-main); color: #000; }

        .badge-terminal { font-weight: bold; font-family: 'Share Tech Mono', monospace; font-size: 11px; }
        .badge-wapp { color: var(--green); }
        .badge-corr { color: var(--blue); }
        .badge-call { color: #f59e0b; }
        .badge-ads { color: var(--amber); }
    </style>
</head>
<body>

<div class="war-room-grid">
    
    <!-- HEADER GLOBAL -->
    <div class="header-module">
        <div class="brand-title">CMSOLUCIONES_ <span>BÚNKER MULTI-NODO V10.0</span></div>
        <div class="sys-health">
            <div style="font-size: 11px; color: var(--text-dim);">UPTIME: 99.9% | CLUSTER: 3 NODOS</div>
            <div class="online-badge">
                <div class="pulse" id="global-pulse"></div>RED EN LÍNEA
            </div>
            <div class="online-badge" style="border-color: var(--text-main); color: var(--text-main);" id="espectadores-badge">
                👤 <span id="online-counter">0</span> ESPECTADORES EN NODO
            </div>
        </div>
    </div>

    <!-- TABS DE RED / SELECTOR DE SUCURSALES -->
    <div class="node-selector">
        <div class="node-tab active-centro" id="tab-centro" onclick="cambiarNodo('centro', 'var(--amber)')">
            <div class="node-indicator"></div> [ NODO 01: MATRIZ CENTRO ]
        </div>
        <div class="node-tab" id="tab-quiroga" onclick="cambiarNodo('quiroga', 'var(--green)')">
            <div class="node-indicator"></div> [ NODO 02: SUCURSAL QUIROGA ]
        </div>
        <div class="node-tab" id="tab-radiologia" onclick="cambiarNodo('radiologia', 'var(--blue)')">
            <div class="node-indicator"></div> [ NODO 03: RADIOLOGÍA DIGITAL ]
        </div>
    </div>

    <!-- METRICAS KPI DINÁMICAS -->
    <div class="panel">
        <div class="panel-header"><span id="lbl-total">> TRÁFICO_TOTAL_RUTEADO</span></div>
        <div class="kpi-value" id="kpi-total" style="color: var(--amber);">0</div>
        <div class="kpi-sub">Buffer secuencial del nodo seleccionado</div>
    </div>

    <div class="panel">
        <div class="panel-header"><span>> CONVERSIONES_WHATSAPP</span></div>
        <div class="kpi-value" id="kpi-wapp">0</div>
        <div class="kpi-sub">Redirecciones exitosas ejecutadas</div>
    </div>

    <div class="panel">
        <div class="panel-header"><span>> INTERACCIONES_ADS / FORM</span></div>
        <div class="kpi-value" id="kpi-ads">0</div>
        <div class="kpi-sub">Impactos capturados desde pauta/web</div>
    </div>

    <!-- RADAR SATELITAL -->
    <div class="panel radar-module" id="radar-panel" style="border-color: var(--amber);">
        <div class="panel-header">
            <span id="lbl-radar" style="color: var(--amber);">> RADAR_TÁCTICO_CENTRO</span>
        </div>
        <div class="map-container" id="map-border" style="border-color: var(--amber);">
            <iframe id="sat-iframe" src="https://maps.google.com/maps?q=Oaxaca+63,+Centro,+Hermosillo&t=k&z=15&ie=UTF8&iwloc=&output=embed" loading="lazy"></iframe>
        </div>
        <div class="target-feed" id="geo-label" style="color: var(--amber); border-color: var(--border-glow);">
            COORDENADAS: ESPERANDO TELEMETRÍA...
        </div>
    </div>

    <!-- GRÁFICA -->
    <div class="panel chart-module">
        <div class="panel-header"><span>> ESPECTRO_DE_CONVERSIÓN_POR_NODO</span></div>
        <div class="chart-container">
            <canvas id="bunkerChart"></canvas>
        </div>
    </div>

    <!-- TERMINAL VIVA -->
    <div class="panel terminal-module">
        <div class="panel-header">
            <span>> TERMINAL_FORENSE_LOCAL</span>
            <button class="btn-export" onclick="exportarExcel()">[⬇ VOLCADO EXCEL]</button>
        </div>
        <div class="log-panel-box">
            <div class="table-wrapper">
                <table id="bunker-table">
                    <thead>
                        <tr><th>TIMESTAMP</th><th>CANAL</th><th>UBICACIÓN</th></tr>
                    </thead>
                    <tbody id="bunker-tbody">
                        <tr><td colspan="3" style="text-align: center; color: var(--text-dim); padding: 20px;">[ CARGANDO FLUJO DE RED... ]</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
let bunkerChart = null;
let ubicacionesRadar = [];
let radarIndex = 0;
let nodoActivo = 'centro';
let colorActivo = 'var(--amber)';

const mapFilters = {
    'centro': 'grayscale(100%) invert(100%) sepia(100%) hue-rotate(0deg) saturate(400%) contrast(1.2)', 
    'quiroga': 'grayscale(100%) invert(100%) sepia(100%) hue-rotate(85deg) saturate(400%) contrast(1.2)', 
    'radiologia': 'grayscale(100%) invert(100%) sepia(100%) hue-rotate(180deg) saturate(500%) contrast(1.3)' 
};

const ctx = document.getElementById('bunkerChart').getContext('2d');
bunkerChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['INBOUND', 'ADS/FORM', 'LLAMADAS', 'WHATSAPP'],
        datasets: [{
            data: [0, 0, 0, 0],
            borderColor: '#ffb700',
            backgroundColor: 'rgba(255, 183, 0, 0.05)',
            borderWidth: 2,
            pointBackgroundColor: '#000',
            pointBorderColor: '#ffb700',
            pointBorderWidth: 2,
            pointRadius: 5,
            tension: 0,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { color: '#1f1f22' }, ticks: { color: '#71717a', font: { family: 'JetBrains Mono', size: 10 } } },
            y: { grid: { color: '#1f1f22' }, ticks: { color: '#71717a', font: { family: 'JetBrains Mono', size: 10 }, beginAtZero: true } }
        }
    }
});

function cambiarNodo(nodo, colorHex) {
    if (nodoActivo === nodo) return;
    
    document.querySelectorAll('.node-tab').forEach(tab => { tab.className = 'node-tab'; });
    
    nodoActivo = nodo;
    colorActivo = colorHex;
    document.getElementById(`tab-${nodo}`).classList.add(`active-${nodo}`);
    
    document.getElementById('kpi-total').style.color = colorHex;
    document.getElementById('radar-panel').style.borderColor = colorHex;
    document.getElementById('lbl-radar').style.color = colorHex;
    document.getElementById('lbl-radar').innerText = `> RADAR_TÁCTICO_${nodo.toUpperCase()}`;
    document.getElementById('map-border').style.borderColor = colorHex;
    document.getElementById('geo-label').style.color = colorHex;
    document.getElementById('global-pulse').style.backgroundColor = colorHex;
    document.getElementById('global-pulse').style.boxShadow = `0 0 8px ${colorHex}`;
    
    document.getElementById('sat-iframe').style.filter = mapFilters[nodo];

    bunkerChart.data.datasets[0].borderColor = colorHex;
    bunkerChart.data.datasets[0].pointBorderColor = colorHex;
    let bgColor = colorHex === 'var(--amber)' ? 'rgba(255, 183, 0, 0.05)' : 
                 (colorHex === 'var(--green)' ? 'rgba(0, 255, 65, 0.05)' : 'rgba(0, 229, 255, 0.05)');
    bunkerChart.data.datasets[0].backgroundColor = bgColor;
    bunkerChart.update();

    document.getElementById('bunker-tbody').innerHTML = `<tr><td colspan="3" style="text-align: center; color: ${colorHex}; padding: 20px;">[ RE-ENRUTANDO TELEMETRÍA AL NODO ${nodo.toUpperCase()}... ]</td></tr>`;
    
    actualizarBunkerEnVivo();
}

// 🎯 SOLUCIÓN AQUÍ: Se cambió de 'panel-control-v10.php' a 'panel-control.php' para coincidir con tu Plesk
async function actualizarBunkerEnVivo() {
    try {
        const response = await fetch(`panel-control.php?action=get_live_data&node=${nodoActivo}`);
        const data = await response.json();

        document.getElementById('online-counter').innerText = data.usuarios_online;
        document.getElementById('kpi-total').innerText = data.total_trafico;
        document.getElementById('kpi-wapp').innerText = data.clics_whatsapp;
        document.getElementById('kpi-ads').innerText = data.ordenes_correo;

        bunkerChart.data.datasets[0].data = [data.total_trafico, data.ordenes_correo, data.clics_llamadas, data.clics_whatsapp];
        bunkerChart.update();

        ubicacionesRadar = data.ultimas_ubicaciones;

        const tbody = document.getElementById('bunker-tbody');
        let htmlContent = '';
        
        if(data.leads.length === 0) {
            htmlContent = `<tr><td colspan="3" style="text-align: center; color: var(--text-dim); padding: 20px;">[ BUFFER ${nodoActivo.toUpperCase()} VACÍO ]</td></tr>`;
        } else {
            data.leads.forEach((l, idx) => {
                const tipo = (l.tipo || l.accion || 'TRAFICO').toLowerCase();
                let badgeStyle = 'badge-corr';
                if (tipo.includes('whatsapp')) badgeStyle = 'badge-wapp';
                if (tipo.includes('llamada')) badgeStyle = 'badge-call';
                if (tipo.includes('ads')) badgeStyle = 'badge-ads';

                const activeClass = idx === 0 ? `active-${nodoActivo}` : '';
                const ciudad = l.ciudad || l.ubicacion || 'Hermosillo, Sonora';
                const ts = l.fecha || l.fecha_hora || 'N/A';

                htmlContent += `
                    <tr class="${activeClass}" data-location="${encodeURIComponent(ciudad)}" onclick="fijarObjetivoMapa(this)">
                        <td style="color: ${colorActivo}; font-weight: bold;">${ts}</td>
                        <td><span class="badge-terminal ${badgeStyle}">${tipo.toUpperCase()}</span></td>
                        <td style="color: var(--text-dim); overflow: hidden; text-overflow: ellipsis; max-width: 100px;">> ${ciudad}</td>
                    </tr>
                `;
            });
        }
        
        tbody.innerHTML = htmlContent;

        if(data.leads.length > 0 && !document.querySelector('#bunker-table tbody tr:hover')) {
            const primerEnlace = document.querySelector('#bunker-table tbody tr');
            if (primerEnlace) fijarObjetivoMapa(primerEnlace);
        }

    } catch (error) {
        console.error("Falla en enlace de telemetría: ", error);
    }
}

function fijarObjetivoMapa(fila) {
    const locRaw = fila.getAttribute('data-location');
    if (!locRaw) return;
    
    document.querySelectorAll('#bunker-table tbody tr').forEach(r => {
        r.classList.remove('active-centro', 'active-quiroga', 'active-radiologia');
    });
    fila.classList.add(`active-${nodoActivo}`);
    
    const satIframe = document.getElementById('sat-iframe');
    const geoLabel = document.getElementById('geo-label');
    
    const urlDestino = `https://maps.google.com/maps?q=${locRaw}&t=k&z=15&ie=UTF8&iwloc=&output=embed`;
    if(satIframe.src !== urlDestino) {
        satIframe.src = urlDestino;
        geoLabel.innerText = `[TARGET LOCK] ${decodeURIComponent(locRaw).toUpperCase()}`;
    }
}

setInterval(() => {
    if(ubicacionesRadar.length === 0 || document.querySelector('#bunker-table tbody tr:hover')) return;
    const loc = ubicacionesRadar[radarIndex];
    document.getElementById('sat-iframe').src = `https://maps.google.com/maps?q=${encodeURIComponent(loc)}&t=k&z=15&ie=UTF8&iwloc=&output=embed`;
    document.getElementById('geo-label').innerText = `[RADAR PATRULLA] ${loc.toUpperCase()}`;
    radarIndex = (radarIndex + 1) % ubicacionesRadar.length;
}, 12000);

cambiarNodo('centro', 'var(--amber)'); 
setInterval(actualizarBunkerEnVivo, 4000);

function exportarExcel() {
    const html = document.getElementById("bunker-table").outerHTML;
    window.open('data:application/vnd.ms-excel;charset=utf-8,' + encodeURIComponent(html));
}
</script>
</body>
</html>