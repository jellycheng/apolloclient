<?php
namespace App\Util;

use CjsCurl\Curl;
class Apollo
{
    protected $configServer; //apollo服务端地址,监听8080端口,示例：http://127.0.0.1:8080
    protected $appId; //apollo配置项目的appid
    protected $clusterName = 'default'; //集群名
    protected $clientIp = '127.0.0.1'; //绑定IP做灰度发布用
    protected $namespaceName = 'application'; //默认值 application
    protected $pullTimeout = 10; //获取某个namespace配置的请求超时时间
    protected $is_debug = true;

    public function __construct()
    {
    }

    public function getConfigServer()
    {
        return $this->configServer;
    }

    public function setConfigServer($configServer)
    {
        $this->configServer = $configServer;
        return $this;
    }

    public function getAppId()
    {
        return $this->appId;
    }

    public function setAppId($appId)
    {
        $this->appId = $appId;
        return $this;
    }

    public function getClusterName()
    {
        return $this->clusterName;
    }

    public function setClusterName($clusterName)
    {
        $this->clusterName = $clusterName;
    }

    public function getNamespaceName()
    {
        return $this->namespaceName;
    }

    public function setNamespaceName($namespaceName)
    {
        $this->namespaceName = $namespaceName;
    }


    public function getClientIp()
    {
        return $this->clientIp;
    }

    public function setClientIp($clientIp)
    {
        $this->clientIp = $clientIp;
        return $this;
    }

    //===== 接口封装
    //通过带缓存的Http接口从Apollo读取配置
    public function getConfigfiles4Cache() {
        $ret = [
                'code'=>'',
                'msg'=>'',
                'data'=>'',
        ];
        $url = sprintf('%s/configfiles/json/%s/%s/%s?ip=%s',
                        rtrim($this->getConfigServer(), '/'),
                        $this->getAppId(),
                        $this->getClusterName(),
                        $this->getNamespaceName(),
                        $this->getClientIp()
                        );
        //echo $url . PHP_EOL;
        $curlObj = Curl::boot()->get($url);
        $ret['code'] = $curlObj->getErrno();
        $content = '';
        if(!$ret['code']) {
            $content = $curlObj->getResponse();
            $content = \json_decode($content, true);
            if(isset($content['status']) && $content['status'] == 404
                && isset($content['error']) && $content['error'] == 'Not Found'
            ) {
                //发生错误，todo log
                $content = '';
                $ret['code'] = 9999;
                //echo "ERROR:" . __FILE__ . PHP_EOL;
            }
        } else {
            $ret['msg'] = $curlObj->getErrmsg();
        }
        $ret['data'] = $content;
        return $ret;
    }

    //通过不带缓存的Http接口从Apollo读取配置
    public function getConfigfiles4NoCache($releaseKey='') {
        $ret = [
            'code'=>'',
            'msg'=>'',
            'data'=>'',
        ];
        $url = sprintf('%s/configs/%s/%s/%s?releaseKey=%s&ip=%s',
                        rtrim($this->getConfigServer(), '/'),
                        $this->getAppId(),
                        $this->getClusterName(),
                        $this->getNamespaceName(),
                        $releaseKey,
                        $this->getClientIp()
                    );
        $curlObj = Curl::boot()->get($url);
        $ret['code'] = $curlObj->getErrno();
        $content = '';
        if(!$ret['code']) {
            $content = $curlObj->getResponse();
            $content = \json_decode($content, true);
            if(isset($content['status']) && $content['status'] == 404
                && isset($content['error']) && $content['error'] == 'Not Found'
            ) {
                //发生错误，todo log
                $content = '';
                $ret['code'] = 9999;
                //echo "ERROR:" . __FILE__ . PHP_EOL;
            }
        } else {
            $ret['msg'] = $curlObj->getErrmsg();
        }
        $ret['data'] = $content;
        return $ret;
    }

    //长链接监听，服务端会hold住请求60秒
    public function getNotificationsData($notifications = [], $callback = null) {
        $ret = [
            'code'=>'',
            'msg'=>'',
            'data'=>'',
        ];
        $notifications = \App\Util\notificationsData($notifications);
        $formatNotifications = \App\Util\formatNotificationsHandle($notifications);
        $url = sprintf('%s/notifications/v2?appId=%s&cluster=%s&notifications=%s',
                        rtrim($this->getConfigServer(), '/'),
                        $this->getAppId(),
                        $this->getClusterName(),
                        urlencode(json_encode($notifications))
                    );
        //echo $url . PHP_EOL;exit;
        $curlObj = Curl::boot()->get($url);
        $ret['code'] = $curlObj->getErrno();
        $content = '';
        if(!$ret['code']) {
            $content = $curlObj->getResponse();
            $content = \json_decode($content, true);
            if(is_array($content)) {
                foreach ($content as $k=>$v) {
                    if(isset($v['namespaceName']) && isset($formatNotifications[$v['namespaceName']])
                        && $v['notificationId']!=$formatNotifications[$v['namespaceName']]['notificationId']
                    ) {
                        //有变化，重新生成env
                        //echo '有变化，重新生成env=' . $v['notificationId'] . PHP_EOL;
                        if($callback instanceof \Closure) {
                            call_user_func($callback, $v);
                        }
                    }
                }
            }
        } else {
            $ret['msg'] = $curlObj->getErrmsg();
        }
        $ret['data'] = $content;
        return $ret;
    }

}
