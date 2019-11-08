<?php
/**
 * php bin/demo03.php 应用名_集群名
 * php bin/demo03.php mobile-api_default
 * php bin/demo03.php manage-api_devci01
 */
require_once dirname(__DIR__) . '/bootstrap/autoload.php';
$apolloAppidClusterConfig = require_once APOLLOCLIENT_ROOT . '/app/Config/AppidCluster.php';
$apolloAppConfig = require_once APOLLOCLIENT_ROOT . '/app/Config/ApolloApp.php';

use App\Util\Apollo;
$apollo = new Apollo();
$appname = isset($_SERVER['argv'][1])?$_SERVER['argv'][1]:'manage_api'; //应用 manage_api mobile_api
if(!isset($apolloAppidClusterConfig[$appname])) {
    exit('appname=' . $appname . ' 未配置' . PHP_EOL);
}

$apolloServer = env('APOLLO_SERVER', "http://127.0.0.1:8080");
$apollo->setConfigServer($apolloServer);
$apollo->setAppId($apolloAppidClusterConfig[$appname]['appid']);

$clientIp = $apolloAppidClusterConfig[$appname]['client_ip'];
if ($clientIp) {
    $apollo->setClientIp($clientIp);
}
$cluster_name = $apolloAppidClusterConfig[$appname]['cluster_name'];
if($cluster_name) {
    $apollo->setClusterName($cluster_name);
}
/**
$notifications = [
                ['namespaceName'=>'application', 'notificationId'=>'-1'],
                ['namespaceName'=>'PHP.feature_app2.1.0_20191030', 'notificationId'=>'-1'],
                ];
 */
$notifications = [];
$namespace_name = $apolloAppidClusterConfig[$appname]['namespace_name'];
foreach ($namespace_name as $k=>$v) {
    $notifications[] = ['namespaceName'=>$v, 'notificationId'=>'-1'];
}

$formatNotifications = \App\Util\formatNotificationsHandle($notifications);
/**
$loop = \CjsSignal\Loop::getInstance();
$i = 0;
while($loop()){
    $i++;
    echo $i . PHP_EOL;
    //
}
*/

$isLoop = true;
while($isLoop) {
    $res = $apollo->getNotificationsData($formatNotifications, function($info) use ($apollo, &$formatNotifications,$apolloAppConfig){
        //echo "====" . var_export($info, true) . PHP_EOL;
        $apollo->setNamespaceName($info['namespaceName']);
        $resData = $apollo->getConfigfiles4Cache();
        //var_export($resData);
        if(!$resData['code']) {
            $formatNotifications[$info['namespaceName']]['notificationId'] = $info['notificationId'];
            //appid+集群名+命名空间
            $tmpKey = sprintf('%s_%s_%s',
                                $apollo->getAppId(),
                                $apollo->getClusterName(),
                                $info['namespaceName']
                                );
            if(isset($apolloAppConfig[$tmpKey])) {
                $saveFile = $apolloAppConfig[$tmpKey]['env_file'];
                echo "保存env文件：" . $saveFile . PHP_EOL;
                \App\Util\checkAndCreateDir(dirname($saveFile));
                \App\Util\saveEnvData($saveFile, $resData['data']);
            } else {
                echo "不知道env文件要保存到哪里" . PHP_EOL;
            }

        }
    });

    if(!$res['code']) {
        echo 'ok' . PHP_EOL;
    } else {
        echo $res['msg'] . PHP_EOL;
    }
}

echo PHP_EOL . 'finish' . PHP_EOL . PHP_EOL;

