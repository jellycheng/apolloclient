<?php
/**
 * php bin/index.php
 */
require_once dirname(__DIR__) . '/bootstrap/autoload.php';
$apolloAppConfig = require_once APOLLOCLIENT_ROOT . '/app/Config/ApolloApp.php';
var_export($_ENV);


$apolloServer = env('APOLLO_SERVER', "http://127.0.0.1:8080");

$appname = 'mobile_api'; //应用
$namespaces = $apolloAppConfig[$appname]['namespaces']; //命名空间
$namespaces = explode(',', $namespaces);

$apollo = new \App\Util\ApolloClient($apolloServer, $apolloAppConfig[$appname]['appid'], $namespaces);
$clientIp = $apolloAppConfig[$appname]['client_ip'];
if ($clientIp) {
    $apollo->setClientIp($clientIp);
}
$cluster = $apolloAppConfig[$appname]['cluster'];
if($cluster) {
    $apollo->setCluster($cluster);
}

$saveDir = $apolloAppConfig[$appname]['config_file'];
if($saveDir) {
    $apollo->setSaveDir($saveDir);
}

ini_set('memory_limit','128M');

$restart = true;
do {
    $error = $apollo->start();
    if ($error) echo('error:'.$error."\n");
}while($error && $restart);
