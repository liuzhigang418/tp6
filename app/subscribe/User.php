<?php
declare (strict_types = 1);

namespace app\subscribe;

use think\Event;


class User
{
    public function onUserLogin($user)
    {
        //UserLogin事件响应处理
    }
    public function onUserLogout($user)
    {
        //UserLogout事件响应处理
    }

    public function subscribe(Event $event)
    {
        $event->listen('UserLogin', [$this,'onUserLogin']);
        $event->listen('UserLogout',[$this,'onUserLogout']);
    }
}
