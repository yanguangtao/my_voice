<?php
/**
 * Created by PhpStorm.
 * User: tgy
 * Date: 2017/12/7
 * Time: 21:32
 */
namespace app\index\model;

use think\Model;
class BaseModel extends Model{

    /**
     * 根据搜索条件获取分页
     * @param $where
     * @param $page
     * @param $limit
     * @return list
     */
    public function getByWhere($where, $page, $limit){
        $list= $this->where($where)->page($page, $limit)->order('id desc')->select();
        $total = $this->getAll($where);
        return array("list"=>$list, "total"=>$total);
    }

    /**
     * 根据搜索条件获取所有的用户数量
     * @param $where
     * @return total
     */
    public function getAll($where)
    {
        return $this->where($where)->count();
    }


    /**
     * 根据管理员id获取角色信息
     * @param $id
     * @return one
     */
    public function getOne($id)
    {
        return $this->where('id', $id)->find();
    }


}