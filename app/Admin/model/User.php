<?php

namespace app\Admin\model;

use think\Model;

class User extends Model
{
    protected $table = 'user';
    public function getList()
    {
//        $data = $this->where('user_id in (1,12)')->column('user_id');

        /*
        我们可以全部用户表数据进行分批处理，每次处理 100 个用户记录：
        $data = $this->chunk(100, function ($users) {
            foreach ($users as $user) {
              //
            }
        },'user_id');
        */

        /**
         * 如果你需要处理大量的数据，可以使用新版提供的游标查询功能，该查询方式利用了PHP的生成器特性，可以大幅减少大量数据查询的内存开销问题
         */
        $cursor = $this->where('is_leave', 1)->cursor();

        foreach ($cursor as $user) {
            echo $user['name'];
        }

//
//        echo $this->getLastSql();
//        return $data;
    }


    /**
     * 添加数据
     * @param $data
     * @return int
     */
    public function addUser($data)
    {
        return $this->replace()->insertAll($data);
    }


    /**
     * 更新数据
     * @param array $data
     * @return bool
     */
    public function updateUser($id, $data = [])
    {
        if (!empty($data) && count($data) > 0 && $id) {
//            $result = $this->where("id = {$id}")->update($data);
//            $result = $this->save(['id' => $id, 'status' => 1]);
//            $result = $this->where("id", $id)->data($data)->update();
//            $result = $this->where('id',1)->exp('user_name','UPPER(user_name)')->update();

            //inc("字段名",增加数) 字段值自增 增加数默认为1
//            $result = $this->where("id", $id)->inc("num", 1)->update();

            //dec("字段名",减少数) 字段值自减 减数默认为1
            $result = $this->where('id', $id)->dec("num", 1)->update();

            if ($result) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    /**
     * 删除数据
     * @param $id
     */
    public function deleteUser(int $id)
    {
        if($id){
            //根据主键删除
            $result = $this->delete($id);
            if($result){
                return true;
            }else{
                return false;
            }
        }
    }

}