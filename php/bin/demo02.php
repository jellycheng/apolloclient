<?php
/**
 * php bin/demo02.php 应用名
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
$tmp_config_dir = $apolloAppConfig[$appname]['tmp_config_dir'];
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
$releaseKey = '';//上一次releaseKey值
$res = $apollo->getConfigfiles4NoCache($releaseKey);
//var_export($res);
if(!$res['code']) {

    App\Util\checkAndCreateDir($tmp_config_dir);
    $data = $res['data'];
    $saveFile = sprintf('%s/%s_%s_%s.php' ,
                        $tmp_config_dir,
                        $data['appId'],
                        $data['cluster'],
                        $data['namespaceName']
                        );

    $content = '<?php return ' . var_export($data, true) . ';';
    file_put_contents($saveFile, $content);
    var_export($data);
    //保存env todo

} else {
    echo $res['msg'] . PHP_EOL;
}
echo PHP_EOL . 'finish' . PHP_EOL . PHP_EOL;

