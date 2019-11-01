<?php
ini_set('date.timezone', 'Asia/Shanghai');
$loader = require dirname(__DIR__) . '/vendor/autoload.php';
define('APOLLOCLIENT_ROOT', dirname(__DIR__) . '/');

if(file_exists(APOLLOCLIENT_ROOT . '/.env')) {
    \CjsEnv\EnvLoader::load(APOLLOCLIENT_ROOT);
}



