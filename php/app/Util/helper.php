<?php
namespace App\Util;


function checkAndCreateDir($dir) {
    if($dir && !is_dir($dir)) {
        mkdir($dir, 0775, true);
    }
}


function saveEnvData($saveFile, $data=[]) {
    $envContent = '';
    foreach ($data as $k=>$v) {
        $envContent .= $k . '=' . $v . PHP_EOL;
    }
    file_put_contents($saveFile, $envContent);
}

/**
$notifications = [
    ['namespaceName'=>'application', 'notificationId'=>'-1'],
    ['namespaceName'=>'PHP.feature_app2.1.0_20191030qq', 'notificationId'=>'-1'],
];
*/
function formatNotificationsHandle($notifications=[]) {
    $ret = [];
    foreach ($notifications as $k=>$v) {
        $ret[$v['namespaceName']] = $v;
    }
    return $ret;
}

/**
 * 返回数据格式：
 * [
 *   ['namespaceName'=>'application', 'notificationId'=>'-1'],
 *   ['namespaceName'=>'PHP.feature_app2.1.0_20191030qq', 'notificationId'=>'-1'],
 * ];
 * @param $data
 * @return array
 *
 */
function notificationsData($data) {
    $ret = [];
    foreach ($data as $k=>$v) {
        $ret[] = ['namespaceName'=>isset($v['namespaceName'])?$v['namespaceName']:'',
                  'notificationId'=>isset($v['notificationId'])?$v['notificationId']:'-1'
                ];
    }
    return $ret;
}

