#!/bin/bash

cd $(dirname $0)
pwd
if [ -f "./bin/start.php" ]; then
    apollo_ps=$(ps aux | grep -c "php ./bin/start.php")
    if [ $apollo_ps -eq 1 ]; then
        php ./bin/start.php &
    fi
fi
