<?php
namespace Qylinfly\ActionLog\Repositories;

use Qylinfly\ActionLog\Services\clientService;
class ActionLogRepository {


    /**
     * 记录用户操作日志
     * @param $type
     * @param $content
     * @param ActionLog $actionLog
     * @return bool
     */
    public function createActionLog($type,$content)
    {
        $enable = config("actionlog.enable",false);
        if($enable) {
            $actionLog = new \Qylinfly\ActionLog\Models\ActionLog();
            if (auth()->check()) {
                $actionLog->uid = auth()->user()->id;
                $actionLog->username = auth()->user()->name;
            } else {
                $actionLog->uid = 0;
                $actionLog->username = "访客";
            }

            if(isset($_SERVER['HTTP_USER_AGENT'])) {
                $actionLog->user_agent=$_SERVER['HTTP_USER_AGENT'];
                $actionLog->browser = clientService::getBrowser($_SERVER['HTTP_USER_AGENT'], true);
                $actionLog->system = clientService::getPlatForm($_SERVER['HTTP_USER_AGENT'], true);
            }
            $actionLog->url = request()->getRequestUri();
            $actionLog->ip = request()->getClientIp();
            $actionLog->method = request()->method();
            $actionLog->type = $type;
            $actionLog->content = $content;
            $res = $actionLog->save();

            return $res;
        }

        return false;
    }
}