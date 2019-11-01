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

$res = $abc();
var_dump($res);
echo PHP_EOL;

$i = 0;
while($abc()){//死循环,自动重启，按ctrl + c 或者 kill掉进程可退出循环
    $i++;
    echo $i . PHP_EOL;
    if($i>=50000) {
        $abc->stop();//停止，但永远停止不掉，因为while调用之后自动重启，只能通过信号停止，如：ctrl+c停止
    }
}

echo 'finish' . PHP_EOL;
