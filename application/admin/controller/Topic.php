<?php
/**
 * 课题管理111111
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

    /**
     * 指导老师我的课题
     * @return array
     * @throws \think\exception\DbException
     */
    public function myList()
    {
        $limit = $this->request->get('size', config('apiadmin.ADMIN_LIST_DEFAULT'));
        $start = $this->request->get('page', 1);
        $objAdminTopic = new AdminTopic();
        $dbResult = $objAdminTopic->where('addPeopleId', $this->userInfo['id'])->order('createTime DESC')
            ->paginate($limit, false, ['page' => $start])->toArray();
        return $this->buildSuccess([
            'list'  => $dbResult['data'],
            'count' => $dbResult['total'],
        ]);
    }

    /**
     * 指导老师课题的启用/禁用
     * @return array
     */
    public function updateEnableStatus()
    {
        $id = $this->request->get('id');
        $enableStatus = $this->request->get('enableStatus');
        $res = AdminTopic::update([
            'id'     => $id,
            'enableStatus' => $enableStatus
        ]);
        if ($res === false) {
            return $this->buildFailed(ReturnCode::DB_SAVE_ERROR);
        }
        return $this->buildSuccess();
    }

    /**
     * 指导老师编辑课题
     */
    public function editTopic()
    {
        $postData = $this->request->post();
        if (empty($postData)) return $this->buildFailed(ReturnCode::EMPTY_PARAMS);
        $data = [
            'title'        => isset($postData['title']) ? $postData['title'] : '',
            'code'         => isset($postData['code']) ? $postData['code'] : '',
            'collegeId'    => isset($postData['college']) ? $postData['college'] : '',
            'college'      => isset(StatusCode::$college[$postData['college']]) ? StatusCode::$college[$postData['college']] : '',
            'taskBookDes'  => isset($postData['taskBookDes']) ? $postData['taskBookDes'] : '',
            'taskBook'     => isset($postData['taskBook']) ? $postData['taskBook'] : '',
            'enableStatus' => isset($postData['enableStatus']) ? $postData['enableStatus'] : StatusCode::$delete,
            'id'           => isset($postData['id']) ? $postData['id'] : '',
        ];
        foreach ($data as $key => $val) {
            if (empty($val) || $val == '') {
                return $this->buildFailed(ReturnCode::EMPTY_PARAMS, '缺少参数' . $key);
            }
        }
        $res = AdminTopic::update($data);
        if ($res === false) {
            return $this->buildFailed(ReturnCode::DB_SAVE_ERROR);
        }
        return $this->buildSuccess();
    }
}