<?php
ini_set('date.timezone', 'Asia/Shanghai');
$loader = require dirname(__DIR__) . '/vendor/autoload.php';
define('APOLLOCLIENT_ROOT', dirname(__DIR__) . '/');

if(file_exists(APOLLOCLIENT_ROOT . '/.env')) {
    \CjsEnv\EnvLoader::load(APOLLOCLIENT_ROOT);
} else if(file_exists(APOLLOCLIENT_ROOT . '/.env.example')) {
    \CjsEnv\EnvLoader::load(APOLLOCLIENT_ROOT, '.env.example');
}


//判断是否特殊账号,特殊账号按分支部署代码
function checkIsSpecialAccount($cloudname) {
    if(in_array($cloudname, ['chengjinsheng', 'devci99'])) {
        return true;
    }
    return false;
}
