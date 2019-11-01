<?php
/**
 * 阿波罗应用
 */
return [
    'mobile_api'=>[
                'appid'=>'mobile-api', //应用ID
                'namespaces'=>'application',//命名空间，默认写 application
                'cluster_name'=>'default', //集群名，默认写default
                'client_ip'=>'127.0.0.1', //
                'config_file'=>APOLLOCLIENT_ROOT . 'logs/mobile_api/', //配置文件保存位置
    ],
];
