<?php

namespace Qylinfly\ActionLog\Repositories;

use Adldap\Models\Model;
use Qylinfly\ActionLog\Models\ActionLog;
use Qylinfly\ActionLog\Services\clientService;

class ActionLogRepository
{

    /**
     * @param $type
     * @param Model|string $content
     * @return bool
     */
    public function createActionLog(string $type, $content)
    {
        if (!config("actionlog.enable", false)) {
            return false;
        }

        $actionLog = new ActionLog();
        $actionLog->user_id = auth()->id();
        $actionLog->type = $type;
        $this->setClientData($actionLog);
        $this->setRequestData($actionLog);
        $this->setContent($actionLog, $content);

        return $actionLog->save();
    }

    /**
     * @param ActionLog $actionLog
     */
    protected function setClientData(ActionLog &$actionLog)
    {
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $actionLog->browser = clientService::getBrowser($_SERVER['HTTP_USER_AGENT'], true);
            $actionLog->system = clientService::getPlatForm($_SERVER['HTTP_USER_AGENT'], true);

            //save user_agent when  no browser and system
            if ($actionLog->browser == '' || $actionLog->system == '') {
                $actionLog->user_agent = $_SERVER['HTTP_USER_AGENT'];
            }

            $actionLog->ip = request()->getClientIp();
        }
    }

    /**
     * @param ActionLog $actionLog
     */
    protected function setRequestData(ActionLog &$actionLog)
    {
        $actionLog->url = urldecode(request()->getRequestUri());
        $actionLog->method = request()->method();
    }

    protected function setContent(ActionLog &$actionLog, $content)
    {
        if (is_string($content)) {
            $actionLog->content = $content;
        } else {
            $this->setContentFromModel($actionLog, $content);
        }
    }

    protected function setContentFromModel(ActionLog &$actionLog, $model)
    {
        $actionLog->action_logable_type = get_class($model);
        $actionLog->action_logable_id = $model->id;

        $content = '';
        $fillable = $model->getFillable();
        $hidden = $model->getHidden();

        foreach ($model->toArray() as $key => $value) {
            if (in_array($key, $fillable) && !in_array($key, $hidden)) {
                $content .= $key . ': ' . $value . '; ';
            }
        }

        $actionLog->content = $content;
    }
}