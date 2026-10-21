<?php
header('Access-Control-Allow-Origin: *');
date_default_timezone_set('America/Hermosillo');

$nodo = strtolower(htmlspecialchars(strip_tags($_GET['nodo'] ?? 'centro'), ENT_QUOTES, 'UTF-8'));
$ip = $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

require_once __DIR__ . '/config.php';
$node_cfg = NODE_CONFIG[$nodo] ?? NODE_CONFIG['centro'];
$archivo = $node_cfg['path'] . $node_cfg['online'];
$activos = file_exists($archivo) ? json_decode(file_get_contents($archivo), true) : [];
if (!is_array($activos)) { $activos = []; }

$activos[$ip] = time();

// Limpiar antiguos (30s)
$limite = time() - 30;
foreach($activos as $k => $v) { if($v < $limite) unset($activos[$k]); }

file_put_contents($archivo, json_encode($activos), LOCK_EX);
echo json_encode(["status" => "ok"]);
