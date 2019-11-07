<?php
namespace App\Util;


function checkAndCreateDir($dir) {
    if($dir && !is_dir($dir)) {
        mkdir($dir, 0775, true);
    }
}


function saveEnvData($saveFile, $data=[]) {
    $envContent = '';
    foreach ($data as $k=>$v) {
        $envContent .= $k . '=' . $v . PHP_EOL;
    }
    file_put_contents($saveFile, $envContent);
}
