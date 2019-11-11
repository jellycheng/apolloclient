#!/bin/bash

cd $(dirname $0)
curpwd=`pwd`
echo $curpwd

if [ -f "$curpwd/bin/start.php" ]; then
    apollo_ps=$(ps aux | grep -c "php $curpwd/bin/start.php $1 $2")
    if [ $apollo_ps -eq 1 ]; then
       nohup php $curpwd/bin/start.php $1 $2 &
    fi
fi
