<?php
/**
 * 按开发者创建配置：
 *   格式：php bin/createconfig.php 开发者（即集群名）
 *   示例：php bin/createconfig.php devci99
 *        php bin/createconfig.php default
 *   备注：default账号不按开发者目录部署
 *
 */
require_once dirname(__DIR__) . '/bootstrap/autoload.php';
$brachNameConfig = require_once APOLLOCLIENT_ROOT . '/app/Config/branchname.php';

$cloudname = isset($_SERVER['argv'][1])?$_SERVER['argv'][1]:''; //开发者
if(!$cloudname) {
    exit('开发者不能为空' . PHP_EOL);
}
$clusterTplFile = isset($_SERVER['argv'][2])?$_SERVER['argv'][2]:''; //模板文件
if(!$clusterTplFile) {
    $clusterTplFile = "AppidCluster.tpl";
}
$isSpecialAccount = checkIsSpecialAccount($cloudname)?true:false; //是否特殊处理的账号
$clusterTplFile = APOLLOCLIENT_ROOT . '/app/Config/Tpl/' . $clusterTplFile;
if(!file_exists($clusterTplFile)) {
    exit("模板文件不存在" . PHP_EOL);
}
$appidClusterTpl = file_get_contents($clusterTplFile);

$appendNamespace_name = '';
if($isSpecialAccount) {//特殊处理账号才追加命名空间
    foreach ($brachNameConfig as $_tmpK=>$_tmpV) {
        $appendNamespace_name .= "'PHP.{$_tmpV}',";
    }
}
//开发者与集群名一致
$appidClusterContent = str_replace(['{$cloud_name}', '{$cluster_name}', '{$namespace_name}'],
                                    [$cloudname, $cloudname, $appendNamespace_name],
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
    if(isset($_v1['env_dir_prefix']) && $_v1['env_dir_prefix']) {
        $env_dir_prefix = $_v1['env_dir_prefix'];
    } else {
        $env_dir_prefix = '/data1/www';
    }
    foreach ($_v1['namespace_name'] as $_k2=>$_v2) {
        $namespace_name = $_v2;
        if($namespace_name) {
            $tmpAppName = $_v1['appid']; //git仓库名，对应部署目录名
//            if($tmpAppName == 'mobile-api') {//特殊处理的项目
//                $tmpAppName = 'api';
//            } else if($tmpAppName == 'user-service') {
//                $tmpAppName = 'user';
//            }
            if($isSpecialAccount) { //特殊账号按分支部署
                if($namespace_name=='application') {
                    $branchName = 'master';
                } else {
                    $branchName = mb_substr($namespace_name, 4);
                }
                $tmpEnvFile = sprintf('%s/%s/%s/%s/.env',
                                        $env_dir_prefix,
                                        $cloudname,
                                        $tmpAppName,
                                        $branchName //分支名
                                        );
            } else if($cloudname == 'default') {
                $tmpEnvFile = sprintf('%s/%s/.env',
                                    $env_dir_prefix,
                                    $tmpAppName);
            } else {
                $tmpEnvFile = sprintf('%s/%s/%s/.env',
                                        $env_dir_prefix,
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

