<?php
namespace CjsSignal;

class Loop
{
    use Singleton;

    private $running; //标记是否在运行

    protected function __construct()
    {
        $this->reset();//标记未运行
        $this->start();//

        $signal = Signal::getInstance();
        $signal->on(SIGHUP, SIG_IGN);
        $signal->on(SIGPIPE, SIG_IGN);
        $signal->on(SIGINT, [$this, 'stop']);//停止信号，Ctrl+C
        $signal->on(SIGQUIT, [$this, 'stop']);//退出
        $signal->on(SIGTERM, [$this, 'stop']);//kill 命令杀掉进程
    }
    //等待信号处理同时返回是否运行状态
    public function running()
    {
        Signal::getInstance()->dispatch();
        return $this->running;
    }

    /**
     * 停止运行
     */
    public function stop()
    {
        $this->running = false;
    }
    //标记为运行状态，启动
    public function start()
    {
        $this->running = true;
        return $this;
    }
    //标记未运行，重置
    public function reset()
    {
        $this->running = false;
        return $this;
    }

    public function __invoke()
    {
        if (!$this->running) {
            $this->start();
        }

        return $this->running();
    }
}
