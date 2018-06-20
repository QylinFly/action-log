<?php

namespace Qylinfly\ActionLog\Repositories;

use Qylinfly\ActionLog\Services\clientService;

class ActionLogRepository
{

    /**
     * @param $type
     * @param Model|string $content
     * @return bool
     */
    public function createActionLog($type, $content)
    {
        $enable = config("actionlog.enable", false);
        if ($enable) {
            $actionLog = new \Qylinfly\ActionLog\Models\ActionLog();

            $actionLog->user_id = auth()->id();
            if (isset($_SERVER['HTTP_USER_AGENT'])) {
                $actionLog->browser = clientService::getBrowser($_SERVER['HTTP_USER_AGENT'], true);
                $actionLog->system = clientService::getPlatForm($_SERVER['HTTP_USER_AGENT'], true);

                //save user_agent when  no browser and system
                if ($actionLog->browser == '' || $actionLog->system == '') {
                    $actionLog->user_agent = $_SERVER['HTTP_USER_AGENT'];
                }
            }

            $actionLog->url = urldecode(request()->getRequestUri());
            $actionLog->ip = request()->getClientIp();
            $actionLog->method = request()->method();
            $actionLog->type = $type;
            $actionLog->content = $content;

            if (is_object($content)) {
                $actionLog->action_logable_type = get_class($content);
                $actionLog->action_logable_id = $content->id;

                $actionLog->content = '';
                $fillable = $content->getFillable();
                $hidden = $content->getHidden();

                foreach ($content->toArray() as $key => $value) {
                    if (in_array($key, $fillable) && !in_array($key, $hidden)) {
                        $actionLog->content .= $key . ': ' . $value . '; ';
                    }
                }
            }

            $res = $actionLog->save();

            return $res;
        }

        return false;
    }
}