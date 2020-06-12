<?php
/**
 * 格式：php bin/start.php 应用名 开发者
 * 示例：php bin/start.php mobile-api devci01
 *      php bin/start.php mobile-api default
 * 
 */
require_once dirname(__DIR__) . '/bootstrap/autoload.php';
use App\Util\Apollo;
$apollo = new Apollo();

$applyname = isset($_SERVER['argv'][1])?trim($_SERVER['argv'][1]):''; //应用名,git仓库名
if(!$applyname) {
    $applyname = 'mobile-api'; //默认应用名
}

$cloudname = isset($_SERVER['argv'][2])?trim($_SERVER['argv'][2]):''; //开发者
if(!$cloudname) {
    exit("开发者不能为空：php bin/start.php 应用名 开发者 " . PHP_EOL);
}

//获取开发者的配置
$developerAppidClusterFile = sprintf('%s/app/Config/Developer/%s/AppidCluster.php',
                                APOLLOCLIENT_ROOT,
                                    ucfirst($cloudname)
                                );
if(!file_exists($developerAppidClusterFile)) {
    exit("开发者配置文件不存在：" . $developerAppidClusterFile . PHP_EOL);
}
$apolloAppidClusterConfig = require_once $developerAppidClusterFile;

$developerApolloAppFile = sprintf('%s/app/Config/Developer/%s/ApolloApp.php',
                                APOLLOCLIENT_ROOT,
                                     ucfirst($cloudname)
                                );
$apolloAppConfig = require_once $developerApolloAppFile;
$appname = $applyname . '_' . $cloudname;
if(!isset($apolloAppidClusterConfig[$appname])) {
    exit("配置文件：" . $developerAppidClusterFile . " 未配置" . $appname . PHP_EOL);
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

$loop = \CjsSignal\Loop::getInstance();
$i = 0;
while($loop()){
    $i++;
    if($i%100==0){
       sleep(3);
       $i = 0;
    }
    //echo $cloudname . $i . PHP_EOL;
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
