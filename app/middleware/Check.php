<?php

declare (strict_types=1);

namespace app\middleware;

use think\response\Redirect;

class Check
{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        if ('think' == $request->name) {
            $request->name = 'ThinkPHP';
        }

        return $next($request);
    }
}
