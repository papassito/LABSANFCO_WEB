<?php
/**
 * WP-LURE (SEÑUELO HONEYPOT) V1.0
 * Este script actúa como un señuelo para bots que escanean en busca de
 * vulnerabilidades de WordPress.
 *
 * CÓMO FUNCIONA:
 * 1. El servidor web (vía .htaccess) redirige los intentos de acceso a /wp-admin o /wp-login.php a este script.
 * 2. El script captura la IP, User-Agent y la URL solicitada por el bot.
 * 3. Envía estos datos de forma interna a `log_lead.php` para que queden registrados como "BOT_TRAPPED".
 * 4. Devuelve una respuesta "403 Forbidden" al bot para bloquearlo.
 */

date_default_timezone_set('America/Hermosillo');

// --- DATOS DEL BOT ---
$ip = filter_var($_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP) ?: '0.0.0.0';
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Bot Desconocido';
$request_uri = $_SERVER['REQUEST_URI'] ?? 'Ruta Desconocida';

// --- PREPARAR PAYLOAD PARA log_lead.php ---
$payload = [
    'nodo'    => 'centro', // Los bots se registran en el nodo principal
    'tipo'    => 'BOT_TRAPPED',
    'detalle' => 'Escaneo ilícito en: ' . $request_uri
];

// --- ENVIAR REGISTRO A log_lead.php USANDO cURL ---
// Determinar la URL completa de log_lead.php
$scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$log_lead_url = $scheme . '://' . $host . dirname($_SERVER['PHP_SELF']) . '/log_lead.php';

$ch = curl_init($log_lead_url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => http_build_query($payload), // Enviamos como form-data, como espera log_lead.php
    CURLOPT_TIMEOUT_MS     => 500, // Timeout corto, no queremos que el bot espere
    CURLOPT_SSL_VERIFYPEER => false // Necesario si usas SSL y cURL tiene problemas para verificar
]);

// Ejecutamos la petición y cerramos la conexión. No nos importa la respuesta.
curl_exec($ch);
curl_close($ch);

// --- RESPONDER AL BOT ---
// Enviamos una cabecera de "Prohibido" y terminamos la ejecución.
header("HTTP/1.1 403 Forbidden");
echo "<h1>403 Forbidden</h1>";
exit();