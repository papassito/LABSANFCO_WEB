<?php
// 🐝 HONEYBOT DEFENDER - SOLUSOL BÚNKER & LOCAL DUAL
header("HTTP/1.1 403 Forbidden");
date_default_timezone_set('America/Hermosillo');

$ip = $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
$agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Bot Desconocido';
$ruta_intentada = $_SERVER['REQUEST_URI'] ?? 'desconocida';

$amenaza = [
    "fecha_hora" => date('Y-m-d H:i:s'),
    "dia"        => date('l'),
    "tipo"       => "BOT_TRAPPED",
    "detalle"    => "Escaneo ilícito en: " . $ruta_intentada,
    "ip"         => $ip,
    "ciudad"     => "AMENAZA BLOQUEADA",
    "estado"     => "BOT",
    "dispositivo"=> substr($agent, 0, 80)
];

// 1. Guardar localmente en el JSON para el panel de control
$archivo = __DIR__ . '/leads_historico.json';
$actuales = file_exists($archivo) ? json_decode(file_get_contents($archivo), true) : [];
if (!is_array($actuales)) { $actuales = []; }
array_unshift($actuales, $amenaza);
file_put_contents($archivo, json_encode($actuales, JSON_PRETTY_PRINT), LOCK_EX);

// 2. Notificar a la API central de Solusol
$bunker_endpoint = 'https://solusol.net/api/v1/telemetry.php';
$api_key         = 'bunker_key_998877665544332211';
$ch = curl_init($bunker_endpoint);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'type'       => 'BOT_TRAPPED',
    'domain'     => $_SERVER['HTTP_HOST'] ?? 'desconocido',
    'ip'         => $ip,
    'path'       => $ruta_intentada,
    'user_agent' => $agent
]));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'X-API-KEY: ' . $api_key]);
curl_setopt($ch, CURLOPT_TIMEOUT_MS, 150);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
curl_close($ch);

echo "<h1>403 Forbidden</h1>Access denied by Security System.";
exit();
