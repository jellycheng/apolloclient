<?php
/**
 * 应用名 可由 appid+集群名即开发者+命名空间 组成
 * php bin/demo01.php Config/ApolloApp.php文件的配置key名
 * php bin/demo01.php manage_api
 * php bin/demo01.php mobile-api_default_application
 * php bin/demo01.php manage-api_devci01_application
 * php bin/demo01.php manage-api_devci01_PHP.feature_app2.1.0_20191030
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
//$namespace_name = "PHP.feature_app2.1.0_20191030";
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
    \App\Util\checkAndCreateDir(dirname($saveFile));
    $data = $res['data'];
    \App\Util\saveEnvData($saveFile, $data);
}
echo PHP_EOL . 'finish' . PHP_EOL . PHP_EOL;

