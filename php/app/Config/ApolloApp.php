<?php
/**
 * 阿波罗应用
 * 一个appid+集群名+命名空间 一个配置key
 */
return [
    'mobile-api_default_application'=>[
        'appid'=>'mobile-api', //应用ID
        'cluster_name'=>'default', //集群名，默认写default
        'namespace_name'=>'application',//命名空间，默认写 application
        'client_ip'=>'127.0.0.1', //
        'tmp_config_dir'=>APOLLOCLIENT_ROOT . 'logs/mobile_api/', //配置文件保存位置
        'env_file'=>APOLLOCLIENT_ROOT . 'logs/mobile_api/default/application/.env', //.env文件
        'intro'=>'移动api',
    ],
    'mobile_api'=>[
                'appid'=>'mobile-api', //应用ID
                'cluster_name'=>'default', //集群名，默认写default
                'namespace_name'=>'application',//命名空间，默认写 application
                'client_ip'=>'127.0.0.1', //
                'tmp_config_dir'=>APOLLOCLIENT_ROOT . 'logs/mobile_api/', //配置文件保存位置
                'env_file'=>APOLLOCLIENT_ROOT . 'logs/mobile_api/.env', //.env文件
                'intro'=>'移动api',
    ],
    'manage_api'=>[//master代码部署
        'appid'=>'manage-api', //应用ID
        'cluster_name'=>'devci01', //集群名，默认写default
        'namespace_name'=>'application',//命名空间，默认写 application
        'client_ip'=>'127.0.0.1', //
        'tmp_config_dir'=>APOLLOCLIENT_ROOT . 'logs/manage_api/', //配置文件保存位置
        'env_file'=>APOLLOCLIENT_ROOT . 'logs/manage_api/.env', //.env文件
        'intro'=>'总后台api',
    ],
    'manage-api_devci01_application'=>[
        'appid'=>'manage-api', //应用ID
        'cluster_name'=>'devci01', //集群名，默认写default
        'namespace_name'=>'application',//命名空间，默认写 application
        'client_ip'=>'127.0.0.1', //
        'tmp_config_dir'=>APOLLOCLIENT_ROOT . 'logs/manage_api/', //配置文件保存位置
        'env_file'=>APOLLOCLIENT_ROOT . 'logs/manage_api/devci01/application/.env', //.env文件
        'intro'=>'总后台api',
    ],
    'manage-api_devci01_PHP.feature_app2.1.0_20191030'=>[
        'appid'=>'manage-api', //应用ID
        'cluster_name'=>'devci01', //集群名，默认写default
        'namespace_name'=>'PHP.feature_app2.1.0_20191030',//命名空间，默认写 application
        'client_ip'=>'127.0.0.1', //
        'tmp_config_dir'=>APOLLOCLIENT_ROOT . 'logs/manage_api/', //配置文件保存位置
        'env_file'=>APOLLOCLIENT_ROOT . 'logs/manage_api/devci01/feature_app2.1.0_20191030/.env', //.env文件
        'intro'=>'总后台api',
    ],

];
