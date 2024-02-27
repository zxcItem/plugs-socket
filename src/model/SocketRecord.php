<?php

namespace plugin\socket\model;

use think\admin\Model;
use think\model\relation\HasOne;

/**
 * 通信记录模型
 */
class SocketRecord extends Model
{
    /**
     * 格式化输出时间
     * @param mixed $value
     * @return string
     */
    public function getCreateTimeAttr($value): string
    {
        return format_datetime($value);
    }

    /**
     * 时间写入格式化
     * @param mixed $value
     * @return string
     */
    public function setCreateTimeAttr($value): string
    {
        return is_string($value) ? str_replace(['年', '月', '日'], ['-', '-', ''], $value) : $value;
    }

    /**
     * @return HasOne
     */
    public function socketMaster(): HasOne
    {
        return $this->hasOne(SocketMaster::class,'code','code');
    }
}