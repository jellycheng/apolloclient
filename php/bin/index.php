<?php
/**
 * 获取单个应用的开发者配置
 * 格式：php bin/index.php 应用名 集群名即开发者 命名空间
 * 示例：php bin/index.php mobile-api devci01
 *      php bin/index.php mobile-api devci01 application
 */
require_once dirname(__DIR__) . '/bootstrap/autoload.php';
$apolloAppConfig = require_once APOLLOCLIENT_ROOT . '/app/Config/ApolloApp.php';

use App\Util\Apollo;
$apollo = new Apollo();
$applyname = isset($_SERVER['argv'][1])?$_SERVER['argv'][1]:''; //应用名、appid
if(!$applyname) {
    exit('应用名不能为空：php bin/index.php 应用名 开发者 命名空间' . PHP_EOL);
}

$cloudname = isset($_SERVER['argv'][2])?trim($_SERVER['argv'][2]):''; //开发者、集群名
if(!$cloudname) {
    //$cloudname = 'devci01'; //默认开发者
    exit("开发者不能为空：php bin/index.php 应用名 开发者 命名空间" . PHP_EOL);
}
$namespace_name = isset($_SERVER['argv'][3])?trim($_SERVER['argv'][3]):''; //命名空间
if(!$namespace_name) {
    $namespace_name = 'application'; //默认application
}
$developerApolloAppFile = sprintf('%s/app/Config/Developer/%s/ApolloApp.php',
                            APOLLOCLIENT_ROOT,
                                ucfirst($cloudname)
                                );
$apolloAppConfig = require_once $developerApolloAppFile;
$appname = $applyname . '_' . $cloudname . '_' . $namespace_name;
if(!isset($apolloAppConfig[$appname])) {
    exit("配置文件：" . $developerApolloAppFile . " 未配置" . $appname . PHP_EOL);
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
    echo $saveFile . PHP_EOL;
    \App\Util\checkAndCreateDir(dirname($saveFile));
    $data = $res['data'];
    \App\Util\saveEnvData($saveFile, $data);
} else {
    echo "生成失败" . PHP_EOL;
}
echo PHP_EOL . 'finish' . PHP_EOL . PHP_EOL;
