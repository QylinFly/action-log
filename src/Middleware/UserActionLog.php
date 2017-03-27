<?php

namespace Qylinfly\ActionLog\Middleware;

use Closure;
use ActionLog;

class UserActionLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $enable = config("actionlog.enable",false);
        if($enable){
            $request_methods = config("actionlog.request_methods",[]);
            $method = $request->method();
            if(in_array($method,$request_methods)) {
                $content = json_encode($request->all());
                ActionLog::createActionLog('request',$content);
            }
        }

        return $next($request);
    }

}
