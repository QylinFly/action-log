<?php

namespace Qylinfly\ActionLog\Models;

use Illuminate\Database\Eloquent\Model;

class ActionLog extends Model
{
    /**
     * The name of table
     * @var string
     */
    protected $table = "action_log";

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        "user_id",
        "action_logable_type",
        "action_logable_id",
        "type",
        "method",
        "ip",
        "browser",
        "system",
        "user_agent",
        "url",
        "content",
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function actionLogable()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(config('actionlog.user_model'));
    }
}