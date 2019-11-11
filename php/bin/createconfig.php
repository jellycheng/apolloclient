<?php
/**
 * 创建配置：
 *   格式：php bin/createconfig.php 开发者
 *   示例：php bin/createconfig.php devci01
 *
 */
require_once dirname(__DIR__) . '/bootstrap/autoload.php';
//$apolloAppConfig = require_once APOLLOCLIENT_ROOT . '/app/Config/ApolloApp.php';
$brachNameConfig = require_once APOLLOCLIENT_ROOT . '/app/Config/branchname.php';

$cloudname = isset($_SERVER['argv'][1])?$_SERVER['argv'][1]:''; //开发者
if(!$cloudname) {
    exit('开发者不能为空' . PHP_EOL);
}
$isSpecialAccount = checkIsSpecialAccount($cloudname)?true:false; //是否特殊处理的账号
$appidClusterTpl = file_get_contents(APOLLOCLIENT_ROOT . '/app/Config/Tpl/AppidCluster.tpl');

$appendNamespace_name = '';
if($isSpecialAccount) {//特殊处理账号，追加命名空间
    foreach ($brachNameConfig as $_tmpK=>$_tmpV) {
        $appendNamespace_name .= "'PHP.{$_tmpV}',";
    }
}
$appidClusterContent = str_replace(['{$cloud_name}', '{$cluster_name}', '{$namespace_name}'],
                                    [$cloudname,$cloudname, $appendNamespace_name],
                                    $appidClusterTpl
                                );

$saveDeveloperClusterFile = APOLLOCLIENT_ROOT . '/app/Config/Developer/' . ucfirst($cloudname) . '/AppidCluster.php';
\App\Util\checkAndCreateDir(dirname($saveDeveloperClusterFile));
file_put_contents($saveDeveloperClusterFile, $appidClusterContent);

echo $saveDeveloperClusterFile . PHP_EOL;
$appidClusterConfig = include $saveDeveloperClusterFile;
$apolloAppFile = APOLLOCLIENT_ROOT . '/app/Config/Developer/' . ucfirst($cloudname) . '/ApolloApp.php';
\App\Util\checkAndCreateDir(dirname($apolloAppFile));
$apolloAppContent = [];
foreach ($appidClusterConfig as $_k1=>$_v1) {
    foreach ($_v1['namespace_name'] as $_k2=>$_v2) {
        $namespace_name = $_v2;
        if($namespace_name) {
            $tmpAppName = $_v1['appid'];
            if($tmpAppName == 'mobile-api') {//特殊处理的项目
                $tmpAppName = 'api';
            } else if($tmpAppName == 'user-service') {//特殊处理的项目
                $tmpAppName = 'user';
            }
            if($isSpecialAccount) { //特殊处理的账号
                if($namespace_name=='application') {
                    $branchName = 'master';
                }
                $tmpEnvFile = sprintf('%s/%s/%s/%s/.env',
                                        '/data1/www',
                                        $cloudname,
                                        $tmpAppName,
                                        $branchName //分支名
                                        );
            } else {
                $tmpEnvFile = sprintf('%s/%s/%s/.env',
                                    '/data1/www',
                                        $cloudname,
                                        $tmpAppName);
            }

            $tmpKey = sprintf('%s_%s_%s', $_v1['appid'], $_v1['cluster_name'], $namespace_name); //appid+集群名+命名空间
            $apolloAppContent[$tmpKey] = [
                                        'appid'=>$_v1['appid'],
                                        'cluster_name'=>$_v1['cluster_name'],
                                        'namespace_name'=>$namespace_name,//命名空间
                                        'client_ip'=>isset($_v1['client_ip'])?$_v1['client_ip']:'127.0.0.1',
                                        'tmp_config_dir'=>APOLLOCLIENT_ROOT . 'logs/' . $_v1['appid'], //配置文件保存位置
                                        'env_file'=>$tmpEnvFile, //.env文件
                                        'intro'=>isset($_v1['intro'])?$_v1['intro']:'',
                                    ];
        }

    }
}
$content = '<?php return ' . var_export($apolloAppContent, true) . ';';
file_put_contents($apolloAppFile, $content);
echo $apolloAppFile . PHP_EOL;

echo 'finsh' . PHP_EOL;

