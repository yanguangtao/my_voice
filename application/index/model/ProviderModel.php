<?php

namespace app\index\model;

use think\Model;

class ProviderModel extends Model
{
    // 确定链接表名
    protected $table = 'snake_provider';

    /**
     * 根据搜索条件获取 列表信息
     * @param $where
     * @param $offset
     * @param $limit
     * @return object
     */
    public function getByWhere($where, $offset, $limit)
    {
        return $this->where($where)->limit($offset, $limit)->order('id desc')->select();
    }

    /**
     * 根据搜索条件获取所有的 数量
     * @param $where
     * @return number
     */
    public function getAll($where)
    {
        return $this->where($where)->count();
    }

    /**
     * 插入 信息
     * @param $param
     * @return object
     */
    public function insert($param)
    {
        try{
            $result =  $this->validate('ProviderValidate')->save($param);
            if(false === $result){
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            }else{

                return msg(1, $result, '添加成功');
            }
        }catch(PDOException $e){

            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 编辑 信息
     * @param $param
     * @return object
     */
    public function edit($param)
    {
        try{

            $result =  $this->validate('ProviderValidate')->save($param, ['id' => $param['id']]);

            if(false === $result){
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            }else{

                return msg(1, url('order/index'), '编辑成功');
            }
        }catch(PDOException $e){
            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 根据 id 获取 信息
     * @param $id
     * @return object
     */
    public function getOne($id)
    {
        return $this->where('id', $id)->find();
    }

    /**
     * 删除
     * @param $id
     * @return object
     */
    public function del($id)
    {
        try{
            $this->where('id', $id)->delete();
            return msg(1, '', '删除成功');
        }catch( PDOException $e){
            return msg(-1, '', $e->getMessage());
        }
    }

    /**
     * 根据phone获取管理员信息
     * @param $phone
     * @return object
     */
    public function findByPhone($phone)
    {
        return $this->where('phone', $phone)->find();
    }

    /**
     * 更新 信息
     * @param array $param
     * @param string $uid
     * @return object
     */
    public function updateStatus($param = [], $uid)
    {
        try{
            $this->where('id', $uid)->update($param);
            return msg(1, '', 'ok');
        }catch (\Exception $e){
            return msg(-1, '', $e->getMessage());
        }
    }
}