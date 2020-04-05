<?php
/**
 * 选题表
 * Created by PhpStorm.
 * User: Admin
 * Date: 2020/4/5
 * Time: 13:15
 */

namespace app\model;

class AdminTopic extends Base
{
    protected $autoWriteTimestamp = true;
    protected $updateTime = 'updateTime';
    protected $createTime = 'createTime';
}