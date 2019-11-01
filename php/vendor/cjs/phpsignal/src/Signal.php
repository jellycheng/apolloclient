<?php
namespace CjsSignal;

class Signal
{
    use Singleton;

    //调用等待信号的处理器，返回bool值，是等待信号通过pcntl_signal() 安装的处理器
    public function dispatch()
    {
        pcntl_signal_dispatch();
    }

    /**
     * 安装一个信号处理器
     * @param $signo 信号
     * @param $handler 信号处理函数
     */
    public function on($signo, $handler)
    {
        pcntl_signal($signo, $handler, false);
    }

    public function off($signo)
    {   //SIG_DFL默认信号处理程序
        pcntl_signal($signo, SIG_DFL, false);
    }

    public function ignore($signo)
    {   //SIG_IGN忽略信号处理程序
        pcntl_signal($signo, SIG_IGN, false);
    }
}
