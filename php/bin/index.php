<?php
/**
 * 获取单个应用的开发者配置
 * php bin/index.php 应用名 集群名即开发者 命名空间
 *
 */
require_once dirname(__DIR__) . '/bootstrap/autoload.php';
$apolloAppConfig = require_once APOLLOCLIENT_ROOT . '/app/Config/ApolloApp.php';
var_export($_ENV);


