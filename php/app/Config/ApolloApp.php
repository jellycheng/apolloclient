<?php
/**
 * 阿波罗应用
 */
return [
    'mobile_api'=>[
                'appid'=>'mobile-api', //应用ID
                'namespace_name'=>'application',//命名空间，默认写 application
                'cluster_name'=>'default', //集群名，默认写default
                'client_ip'=>'127.0.0.1', //
                'tmp_config_dir'=>APOLLOCLIENT_ROOT . 'logs/mobile_api/', //配置文件保存位置
                'env_file'=>APOLLOCLIENT_ROOT . 'logs/mobile_api/.env', //.env文件
                'intro'=>'移动api',
    ],
    'manage_api'=>[
        'appid'=>'manage-api', //应用ID
        'namespace_name'=>'application',//命名空间，默认写 application
        'cluster_name'=>'devci01', //集群名，默认写default
        'client_ip'=>'127.0.0.1', //
        'tmp_config_dir'=>APOLLOCLIENT_ROOT . 'logs/manage_api/', //配置文件保存位置
        'env_file'=>APOLLOCLIENT_ROOT . 'logs/manage_api/.env', //.env文件
        'intro'=>'总后台api',
    ],
];
