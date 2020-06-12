<?php
/**
 * 阿波罗应用 - 一个开发者的模板配置示例
 * 一个 appid（仓库名）+集群名（可以是开发者名） 一个配置key
 * 如果是集群，一个开发者一个集群
 */
return [
    'mobile-api_{$cloud_name}'=>[
                'appid'=>'mobile-api', //应用ID，git仓库名
                'cluster_name'=>'{$cluster_name}', //集群名，默认写default
                'namespace_name'=>['application', {$namespace_name}],//命名空间，默认写 application
                'client_ip'=>'127.0.0.1',
                'env_dir_prefix'=>'/data/www', //指定项目目录前缀，默认 /data1/www
                'intro'=>'移动api',
    ],
    'manage-api_{$cloud_name}'=>[
        'appid'=>'manage-api',
        'cluster_name'=>'{$cluster_name}',
        'namespace_name'=>['application', {$namespace_name}],
        'client_ip'=>'127.0.0.1',
        'env_dir_prefix'=>'/data/www',
        'intro'=>'运营后台api，总后台',
    ],
    'shop-api_{$cloud_name}'=>[
        'appid'=>'shop-api',
        'cluster_name'=>'{$cluster_name}',
        'namespace_name'=>['application', {$namespace_name}],
        'client_ip'=>'127.0.0.1',
        'env_dir_prefix'=>'/data/www',
        'intro'=>'商家后台api',
    ],
    'supplier-api_{$cloud_name}'=>[
        'appid'=>'supplier-api',
        'cluster_name'=>'{$cluster_name}',
        'namespace_name'=>['application', {$namespace_name}],
        'client_ip'=>'127.0.0.1',
        'env_dir_prefix'=>'/data/www',
        'intro'=>'供应商后台api',
    ],
    'permission-service_{$cloud_name}'=>[
        'appid'=>'permission-service',
        'cluster_name'=>'{$cluster_name}',
        'namespace_name'=>['application', {$namespace_name}],
        'client_ip'=>'127.0.0.1',
        'env_dir_prefix'=>'/data/www',
        'intro'=>'权限服务',
    ],
    'user-service_{$cloud_name}'=>[
        'appid'=>'user-service',
        'cluster_name'=>'{$cluster_name}',
        'namespace_name'=>['application', {$namespace_name}],
        'client_ip'=>'127.0.0.1',
        'env_dir_prefix'=>'/data/www',
        'intro'=>'用户服务',
    ],
    'coupon-service_{$cloud_name}'=>[
        'appid'=>'coupon-service',
        'cluster_name'=>'{$cluster_name}',
        'namespace_name'=>['application', {$namespace_name}],
        'client_ip'=>'127.0.0.1',
        'env_dir_prefix'=>'/data/www',
        'intro'=>'优惠券服务',
    ],
    'cart-service_{$cloud_name}'=>[
        'appid'=>'cart-service',
        'cluster_name'=>'{$cluster_name}',
        'namespace_name'=>['application', {$namespace_name}],
        'client_ip'=>'127.0.0.1',
        'env_dir_prefix'=>'/data/www',
        'intro'=>'购物车服务',
    ],
    'order-service_{$cloud_name}'=>[
        'appid'=>'order-service',
        'cluster_name'=>'{$cluster_name}',
        'namespace_name'=>['application', {$namespace_name}],
        'client_ip'=>'127.0.0.1',
        'env_dir_prefix'=>'/data/www',
        'intro'=>'订单服务',
    ],
    'sms-service_{$cloud_name}'=>[
        'appid'=>'sms-service',
        'cluster_name'=>'{$cluster_name}',
        'namespace_name'=>['application', {$namespace_name}],
        'client_ip'=>'127.0.0.1',
        'env_dir_prefix'=>'/data/www',
        'intro'=>'短信服务',
    ],
    'goods-service_{$cloud_name}'=>[
        'appid'=>'goods-service',
        'cluster_name'=>'{$cluster_name}',
        'namespace_name'=>['application', {$namespace_name}],
        'client_ip'=>'127.0.0.1',
        'env_dir_prefix'=>'/data/www',
        'intro'=>'商品服务',
    ],
    'marketing-service_{$cloud_name}'=>[
        'appid'=>'marketing-service',
        'cluster_name'=>'{$cluster_name}',
        'namespace_name'=>['application', {$namespace_name}],
        'client_ip'=>'127.0.0.1',
        'env_dir_prefix'=>'/data/www',
        'intro'=>'营销中心',
    ],
    'stock-service_{$cloud_name}'=>[
        'appid'=>'stock-service',
        'cluster_name'=>'{$cluster_name}',
        'namespace_name'=>['application', {$namespace_name}],
        'client_ip'=>'127.0.0.1',
        'env_dir_prefix'=>'/data/www',
        'intro'=>'库存中心',
    ],
    'message-service_{$cloud_name}'=>[
        'appid'=>'message-service',
        'cluster_name'=>'{$cluster_name}',
        'namespace_name'=>['application', {$namespace_name}],
        'client_ip'=>'127.0.0.1',
        'env_dir_prefix'=>'/data/www',
        'intro'=>'消息中心',
    ],
    'search-service_{$cloud_name}'=>[
        'appid'=>'search-service',
        'cluster_name'=>'{$cluster_name}',
        'namespace_name'=>['application', {$namespace_name}],
        'client_ip'=>'127.0.0.1',
        'env_dir_prefix'=>'/data/www',
        'intro'=>'搜索服务',
    ],
    'catalog-service_{$cloud_name}'=>[
        'appid'=>'catalog-service',
        'cluster_name'=>'{$cluster_name}',
        'namespace_name'=>['application', {$namespace_name}],
        'client_ip'=>'127.0.0.1',
        'env_dir_prefix'=>'/data/www',
        'intro'=>'字典、地址库等服务',
    ],
    'at-service_{$cloud_name}'=>[
        'appid'=>'at-service',
        'cluster_name'=>'{$cluster_name}',
        'namespace_name'=>['application', {$namespace_name}],
        'client_ip'=>'127.0.0.1',
        'env_dir_prefix'=>'/data/www',
        'intro'=>'第三方令牌服务，如微信登录',
    ],

];
