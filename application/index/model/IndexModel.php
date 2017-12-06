<?php

namespace app\index\model;

use think\Model;

class IndexModel extends Model
{
    // 确定链接表名
    protected $table = 'snake_order';

    /**
     * 根据搜索条件获取用户列表信息
     * @param $where
     * @param $offset
     * @param $limit
     */
    public function getByWhere($where, $offset, $limit)
    {
        return $this->where($where)->limit($offset, $limit)->order('id desc')->select();
    }

    /**
     * 根据搜索条件获取所有的用户数量
     * @param $where
     */
    public function getAll($where)
    {
        return $this->where($where)->count();
    }


    /**
     * 根据管理员id获取角色信息
     * @param $id
     */
    public function getOne($id)
    {
        return $this->where('id', $id)->find();
    }



    /**
     * 根据用户名获取管理员信息
     * @param $name
     */
    public function findByName($name)
    {
        return $this->where('name', $name)->find();
    }


}