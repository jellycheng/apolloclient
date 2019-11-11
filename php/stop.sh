#!/bin/bash

cd $(dirname $0)
curpwd=`pwd`
echo $curpwd
#echo $1
ps -ef | grep "php $curpwd/bin/start.php $1 $2" |grep -v grep | awk '{print $2}' |xargs kill > /dev/null 2>&1
