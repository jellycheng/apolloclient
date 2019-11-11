<?php
/**
 * 阿波罗应用 - 一个开发者的模板配置示例
 * 一个 appid+集群名开发者 一个配置key
 */
return [
    'mobile-api_{$cloud_name}'=>[
                'appid'=>'mobile-api', //应用ID
                'cluster_name'=>'{$cluster_name}', //集群名，默认写default
                'namespace_name'=>['application', {$namespace_name}],//命名空间，默认写 application
                'client_ip'=>'127.0.0.1',
                'intro'=>'移动api',
    ],
    'manage-api_{$cloud_name}'=>[
        'appid'=>'manage-api',
        'cluster_name'=>'{$cluster_name}',
        'namespace_name'=>['application', {$namespace_name}],
        'client_ip'=>'127.0.0.1',
        'intro'=>'总后台api',
    ],
    'user-service_{$cloud_name}'=>[
        'appid'=>'user-service',
        'cluster_name'=>'{$cluster_name}',
        'namespace_name'=>['application', {$namespace_name}],
        'client_ip'=>'127.0.0.1',
        'intro'=>'用户服务',
    ],
    'coupon-service_{$cloud_name}'=>[
        'appid'=>'coupon-service',
        'cluster_name'=>'{$cluster_name}',
        'namespace_name'=>['application', {$namespace_name}],
        'client_ip'=>'127.0.0.1',
        'intro'=>'优惠券服务',
    ],
    'order-service_{$cloud_name}'=>[
        'appid'=>'order-service',
        'cluster_name'=>'{$cluster_name}',
        'namespace_name'=>['application', {$namespace_name}],
        'client_ip'=>'127.0.0.1',
        'intro'=>'订单服务',
    ],

];
