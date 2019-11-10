#!/bin/bash

cd $(dirname $0)
curpwd=`pwd`
echo $curpwd

if [ -f "$curpwd/bin/start.php" ]; then
    apollo_ps=$(ps aux | grep -c "php $curpwd/bin/start.php")
    if [ $apollo_ps -eq 1 ]; then
        php $curpwd/bin/start.php &
    fi
fi
