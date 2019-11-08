<?php
/**
 * 阿波罗应用
 * 一个appid+集群名 一个配置key
 */
return [
    'mobile-api_default'=>[
                'appid'=>'mobile-api', //应用ID
                'cluster_name'=>'default', //集群名，默认写default
                'namespace_name'=>['application'],//命名空间，默认写 application
                'client_ip'=>'127.0.0.1', //
                'intro'=>'移动api',
    ],
    'manage-api_devci01'=>[//master代码部署
        'appid'=>'manage-api', //应用ID
        'cluster_name'=>'devci01', //集群名，默认写default
        'namespace_name'=>['application', 'PHP.feature_app2.1.0_20191030'],//命名空间，默认写 application
        'client_ip'=>'127.0.0.1', //
        'intro'=>'总后台api',
    ],

];
