#!/bin/bash

cd /data1/www/devci01/apolloclient/php

bash start.sh mobile-api devci01
bash start.sh coupon-service devci01
bash start.sh user-service devci01
bash start.sh order-service devci01
bash start.sh marketing-service devci01
bash start.sh goods-service devci01
bash start.sh stock-service devci01
bash start.sh manage-api devci01
bash start.sh sms-api devci01
