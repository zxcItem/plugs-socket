<?php

namespace plugin\socket\model;

use think\admin\Model;
use think\model\relation\HasOne;

/**
 * 通信记录模型
 */
class PluginSocketRecord extends Model
{
    /**
     * @return HasOne
     */
    public function socketMaster(): HasOne
    {
        return $this->hasOne(PluginSocketMaster::class,'code','code');
    }
}