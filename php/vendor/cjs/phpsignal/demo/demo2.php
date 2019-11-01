<?php
/**
 * Created by PhpStorm.
 * User: jelly
 * Date: 2019-09-11
 * Time: 01:25
 */

require_once __DIR__ . '/common.php';

function loop()
{
    return \CjsSignal\Loop::getInstance();
}

$abc = loop();

$abc->start();//启动

$i = 0;
while($abc->running()){//死循环,按ctrl + c 或者 kill掉进程可退出循环,或者通过调用代码停止
    $i++;
    echo $i . PHP_EOL;
    if($i>=500000) {
        echo PHP_EOL . '主动触发stop' . PHP_EOL;
        $abc->stop();//停止
    }
}

echo 'finish' . PHP_EOL;
