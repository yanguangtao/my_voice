<?php

namespace app\index\controller;

use think\Controller;
use app\index\model\IndexModel;

class Index extends Controller
{
    public function index()
    {
        if (request()->isAjax()) {
            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (!empty($param['searchText'])) {
                $where['phone'] = $param['searchText'];
            }
            $user = new IndexModel();
            $selectResult = $user->getByWhere($where, $offset, $limit);

            $return['total'] = $user->getAll($where);  //总数据
            $return['rows'] = $selectResult;

            return json($return);
        }


        return $this->fetch();
    }

    public function login()
    {
        return 0 + 2;
    }
}
