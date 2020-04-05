<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2020/4/5
 * Time: 13:25
 */

namespace app\util;


class StatusCode
{
    /**
     * 非正常状态
     * @var int
     */
    public static $delete = 4;

    /**
     * 正常状态
     * @var int
     */
    public static $stand = 5;

    public static $college = [
        1 => '计算机学院',
        2 => '工程学院',
        3 => '汉语言学院'
    ];
}