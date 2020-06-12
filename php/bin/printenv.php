<?php
/**
 * php bin/printenv.php
 *
 */
require_once dirname(__DIR__) . '/bootstrap/autoload.php';
$apolloAppConfig = require_once APOLLOCLIENT_ROOT . '/app/Config/ApolloApp.php';
var_export($_ENV);
echo PHP_EOL;


