<?php
/**
 * CONFIGURACIÓN CENTRAL DEL PROYECTO MULTI-NODO
 * 
 * Este archivo define las rutas a los archivos de datos (logs JSON)
 * para cada nodo (dominio). Permite que los scripts principales
 * encuentren los datos sin importar la estructura de carpetas.
 * 
 * AJUSTA LAS RUTAS ('path') PARA QUE COINCIDAN CON TU ESTRUCTURA DE CARPETAS.
 */

define('NODE_CONFIG', [
    'centro' => [
        'path'   => __DIR__ . '/../data_centro/',
        'logs'   => 'leads_historico.json',
        'online' => 'online_users.json'
    ],
    'quiroga' => [
        'path'   => __DIR__ . '/../data_quiroga/',
        'logs'   => 'leads_quiroga.json',
        'online' => 'online_quiroga.json'
    ],
    'radiologia' => [
        'path'   => __DIR__ . '/../data_radiologia/',
        'logs'   => 'leads_radiologia.json',
        'online' => 'online_radiologia.json'
    ]
]);