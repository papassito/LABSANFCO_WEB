<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { exit(0); }

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("HTTP/1.1 404 Not Found");
    exit();
}

header('Content-Type: application/json');
date_default_timezone_set('America/Hermosillo'); 

$nodo = strtolower(htmlspecialchars(strip_tags($_POST['nodo'] ?? 'centro'), ENT_QUOTES, 'UTF-8'));
$tipo = htmlspecialchars(strip_tags($_POST['tipo'] ?? 'WhatsApp'), ENT_QUOTES, 'UTF-8');
$detalle = htmlspecialchars(strip_tags($_POST['detalle'] ?? 'Clic directo'), ENT_QUOTES, 'UTF-8');
$ip = filter_var($_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP) ? ($_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']) : '0.0.0.0';
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Desconocido';

// 1. Geolocalización Express
$ciudad = 'Desconocida'; $estado = 'Desconocido';
if ($ip !== '127.0.0.1' && $ip !== '0.0.0.0') {
    $ctx = stream_context_create(['http' => ['timeout' => 1]]);
    $geo_api = @file_get_contents("http://ip-api.com/json/" . $ip, false, $ctx);
    if ($geo_api) {
        $geo_data = json_decode($geo_api, true);
        if (($geo_data['status'] ?? '') === 'success') {
            $ciudad = $geo_data['city'] ?? 'Desconocida';
            $estado = $geo_data['regionName'] ?? 'Desconocido';
        }
    }
}

$nuevo_lead = [
    "fecha_hora" => date('Y-m-d H:i:s'),
    "dia"        => date('l'), 
    "tipo"       => $tipo,
    "detalle"    => $detalle,
    "ip"         => $ip,
    "ciudad"     => $ciudad,
    "estado"     => $estado,
    "dispositivo"=> substr($user_agent, 0, 80) 
];

// 2. GUARDA EN TUS ARCHIVOS JSON LOCALES (SIN BORRAR NADA)
require_once __DIR__ . '/config.php';

$node_cfg = NODE_CONFIG[$nodo] ?? NODE_CONFIG['centro'];
$archivo_json = $node_cfg['path'] . $node_cfg['logs'];

$leads_actuales = [];
if (file_exists($archivo_json)) {
    $contenido = file_get_contents($archivo_json);
    $leads_actuales = json_decode($contenido, true) ?? [];
}
array_unshift($leads_actuales, $nuevo_lead);
file_put_contents($archivo_json, json_encode($leads_actuales, JSON_PRETTY_PRINT), LOCK_EX);


// 3. ENVÍA UNA COPIA A LA BASE DE DATOS DE SOLUSOL.NET
try {
    $trackerUrl = 'https://solusol.net/tracker.php';
    $esWa = (strpos(strtolower($tipo), 'whatsapp') !== false || strpos(strtolower($detalle), 'chat') !== false);

    $payload = [
        'domain'     => 'laboratoriosanfrancisco.com',
        'site_key'   => 'sol_live_3b9e3319a6be5d0e3f6d48e06451592b',
        'event_type' => $esWa ? 'WHATSAPP_CLICK' : 'PAGE_VIEW',
        'action_url' => $detalle,
        'ip_address' => $ip
    ];

    $ch = curl_init($trackerUrl);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => json_encode($payload),
        CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
        CURLOPT_TIMEOUT        => 2,
        CURLOPT_SSL_VERIFYPEER => false
    ]);
    curl_exec($ch);
    curl_close($ch);
} catch (\Throwable $e) {}

echo json_encode(["status" => "success"]);