<?php
/**
 * php bin/demo01.php 应用名
 * php bin/demo01.php manage_api
 */
require_once dirname(__DIR__) . '/bootstrap/autoload.php';
$apolloAppConfig = require_once APOLLOCLIENT_ROOT . '/app/Config/ApolloApp.php';

use App\Util\Apollo;
$apollo = new Apollo();
$appname = isset($_SERVER['argv'][1])?$_SERVER['argv'][1]:'manage_api'; //应用 manage_api mobile_api
if(!isset($apolloAppConfig[$appname])) {
    exit('appname=' . $appname . ' 未配置' . PHP_EOL);
}

$apolloServer = env('APOLLO_SERVER', "http://127.0.0.1:8080");
$apollo->setConfigServer($apolloServer);
$apollo->setAppId($apolloAppConfig[$appname]['appid']);

$namespace_name = $apolloAppConfig[$appname]['namespace_name']; //命名空间
$apollo->setNamespaceName($namespace_name);

$clientIp = $apolloAppConfig[$appname]['client_ip'];
if ($clientIp) {
    $apollo->setClientIp($clientIp);
}
$cluster_name = $apolloAppConfig[$appname]['cluster_name'];
if($cluster_name) {
    $apollo->setClusterName($cluster_name);
}

$res = $apollo->getConfigfiles4Cache();
//var_export($res);
if(!$res['code']) {
    $saveFile = $apolloAppConfig[$appname]['env_file'];
    App\Util\checkAndCreateDir(dirname($saveFile));
    $data = $res['data'];
    \App\Util\saveEnvData($saveFile, $data);
}
echo PHP_EOL . 'finish' . PHP_EOL . PHP_EOL;

