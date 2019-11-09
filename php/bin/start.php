<?php
/**
 * php bin/start.php 应用名 命名空间 集群名
 *
 */
require_once dirname(__DIR__) . '/bootstrap/autoload.php';
$apolloAppConfig = require_once APOLLOCLIENT_ROOT . '/app/Config/ApolloApp.php';
var_export($_ENV);


$loop = \CjsSignal\Loop::getInstance();
$i = 0;
while($loop()){
    $i++;
    sleep(3);
    echo $i . PHP_EOL;
    //
}
