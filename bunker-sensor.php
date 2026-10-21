<?php
// BÚNKER ANALYTICS & CONVERSION SENSOR V2
function runBunkerSensor() {
    $bunker_endpoint = 'https://solusol.net/api/v1/telemetry.php';
    $api_key         = 'bunker_key_998877665544332211';

    $ip        = $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
    $referrer  = $_SERVER['HTTP_REFERER'] ?? '';
    $domain    = $_SERVER['HTTP_HOST'] ?? 'desconocido';
    $path      = $_SERVER['REQUEST_URI'] ?? '/';

    // 1. Detectar Dispositivo
    $isMobile = preg_match('/(android|bb\d+|meego).+mobile|blackberry|iphone|ipod|palm|pocket|psp|series(4|6)0|symbian|windows ce|xda/i', $userAgent);
    $device   = $isMobile ? 'Mobile' : 'Desktop';

    // 2. Detectar Navegador
    $browser = 'Otros';
    if (strpos($userAgent, 'Chrome') !== false) $browser = 'Chrome';
    elseif (strpos($userAgent, 'Safari') !== false) $browser = 'Safari';
    elseif (strpos($userAgent, 'Firefox') !== false) $browser = 'Firefox';
    elseif (strpos($userAgent, 'Edge') !== false) $browser = 'Edge';

    // 3. Detectar Fuente de Tráfico
    $source = 'Directo';
    if (!empty($referrer)) {
        if (strpos($referrer, 'google') !== false) $source = 'Google Search';
        elseif (strpos($referrer, 'facebook') !== false || strpos($referrer, 'instagram') !== false) $source = 'Redes Sociales';
        elseif (strpos($referrer, 'wa.me') !== false || strpos($referrer, 'whatsapp') !== false) $source = 'WhatsApp';
        else $source = 'Referral (' . parse_url($referrer, PHP_URL_HOST) . ')';
    }

    $payload = [
        'type'           => 'PAGEVIEW',
        'domain'         => $domain,
        'path'           => $path,
        'ip'             => $ip,
        'visitor_hash'   => md5($ip . $userAgent),
        'user_agent'     => substr($userAgent, 0, 250),
        'referrer'       => substr($referrer, 0, 250),
        'traffic_source' => $source,
        'device'         => $device,
        'browser'        => $browser
    ];

    // Envío en segundo plano
    $ch = curl_init($bunker_endpoint);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'X-API-KEY: ' . $api_key]);
    curl_setopt($ch, CURLOPT_TIMEOUT_MS, 150);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);

    // 4. Inyectar rastreador de clics de WhatsApp/Teléfono en la página
    register_shutdown_function(function() use ($bunker_endpoint, $api_key, $domain, $ip) {
        echo "<script>
        document.addEventListener('click', function(e) {
            let a = e.target.closest('a');
            if (!a) return;
            let href = a.getAttribute('href') || '';
            let eventType = null;
            if (href.includes('wa.me') || href.includes('whatsapp.com')) eventType = 'WHATSAPP_CLICK';
            else if (href.startsWith('tel:')) eventType = 'PHONE_CLICK';
            
            if (eventType) {
                navigator.sendBeacon('$bunker_endpoint', JSON.stringify({
                    api_key: '$api_key',
                    type: eventType,
                    domain: '$domain',
                    path: window.location.pathname,
                    target_url: href,
                    ip: '$ip'
                }));
            }
        });
        </script>";
    });
}

runBunkerSensor();