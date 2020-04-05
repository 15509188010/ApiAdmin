<?php
/**
 * 课题管理
 */

namespace app\admin\controller;


use app\model\AdminTopic;
use app\util\ReturnCode;
use app\util\StatusCode;

class Topic extends Base
{
    /**
     * 超管课题列表
     * @return array
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $limit = $this->request->get('size', config('apiadmin.ADMIN_LIST_DEFAULT'));
        $start = $this->request->get('page', 1);
        $objAdminTopic = new AdminTopic();
        $dbResult = $objAdminTopic->where('enableStatus', StatusCode::$stand)->order('createTime DESC')
            ->paginate($limit, false, ['page' => $start])->toArray();
        return $this->buildSuccess([
            'list'  => $dbResult['data'],
            'count' => $dbResult['total'],
        ]);
    }

    /**
     * 公共字段
     * @return array
     */
    public function commonField()
    {
        $postData = $this->request->post();
        if (empty($postData)) return $this->buildFailed(ReturnCode::EMPTY_PARAMS);

        $data = [
            'title'        => isset($postData['title']) ? $postData['title'] : '',
            'code'         => 'TOPIC' . uniqid(),
            'collegeId'    => isset($postData['college']) ? $postData['college'] : '',
            'college'      => isset(StatusCode::$college[$postData['college']]) ? StatusCode::$college[$postData['college']] : '',
            'taskBookDes'  => isset($postData['taskBookDes']) ? $postData['taskBookDes'] : '',
            'taskBook'     => isset($postData['taskBook']) ? $postData['taskBook'] : '',
            'addPeople'    => isset($this->userInfo['nickname']) ? $this->userInfo['nickname'] : '',
            'addPeopleId'  => isset($this->userInfo['id']) ? $this->userInfo['id'] : '',
            'enableStatus' => isset($postData['enableStatus']) ? $postData['enableStatus'] : StatusCode::$delete,
        ];
        foreach ($data as $key => $val) {
            if (empty($val) || $val == '') {
                return $this->buildFailed(ReturnCode::EMPTY_PARAMS, '缺少参数' . $key);
            }
        }
        return $data;
    }


    /**
     * 指导老师添加课题
     * @return array
     */
    public function add()
    {
        $data = self::commonField();
        $objAdminTopic = new AdminTopic();
        $dbResult = $objAdminTopic->allowField(true)->insert($data);
        return $this->buildSuccess($dbResult);
    }
}