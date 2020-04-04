<?php
/**
 * 课题管理
 */
namespace app\admin\controller;


class Topic extends Base
{
    public function index()
    {
        $data=[
            [
                'code'=>'TOPIC1000001',
                'title' => '课题题目',
                'college'=>'计算机学院',
                'taskBook'=>'任务书',
                'addPeople'=>'小明',
                'auditStatus'=>4
            ],
            [
                'code'=>'TOPIC1000001',
                'title' => '课题题目',
                'college'=>'计算机学院',
                'taskBook'=>'任务书',
                'addPeople'=>'小明',
                'auditStatus'=>4
            ]
        ];
        return $this->buildSuccess([
            'list'  => $data,
            'count' => 2
        ]);
    }
}