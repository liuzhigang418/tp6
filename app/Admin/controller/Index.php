<?php

namespace app\Admin\controller;

use app\Admin\model\AppVersion;
use app\Admin\model\User;
use app\BaseController;
use app\index\Model\UserModel;
use ClassesWithParents\D;
use think\db\connector\Mysql;
use think\db\Query;
use think\facade\Db;
use think\facade\View;
use think\exception\ValidateException;

//use think\Request;

//请求对象操作 方法注入引入
use think\facade\Request;

//请求对象静态调用 引入
class Index extends BaseController
{

    // 开启批量验证
//    protected $batchValidate = true;

    protected $user = null;

    public function initialize()
    {
        $this->user = $this->user ?: new User();
    }

    //请求对象操作方法注入
    public function index(Request $request)
    {
//        try {
//            $this->validate([
//                'name' => 'thinkphp',
//                'email' => 'thinkphp@qq.com',
//            ], 'app\admin\validate\User');
//        } catch (ValidateException $e) {
//            //验证失败 输出错误信息
//            dump($e->getError());
//        }
        view::assign('name', '测试');

        //访问协议
//        echo $request->scheme().'<br/>';
//        //访问端口
//        echo $request->port().'<br/>';
//        //访问IP地址域名
//        echo  $request->host().'<br/>';
//        //当前url
//        echo $request->url().'<br/>';
//        //当前控制器
//        echo $request->controller().'<br/>';
//        echo $request->action();

//        $b = $request->has('id', 'get');
//        $a = $request->has('name','post');
//        var_dump($a);
//        var_dump($b);

        //修饰符	作用
        //Request::变量类型('变量名/修饰符');
        //s	强制转换为字符串类型
        //d	强制转换为整型类型
        //b	强制转换为布尔类型
        //a	强制转换为数组类型
        //f	强制转换为浮点类型
//        echo $request->get('id/d');

        //判断变量是否定义
//        var_dump(input('?get.id'));
//        var_dump(input('?post.name'));

        //获取param参数
        var_dump(input('param.name')); // 获取单个参数
        var_dump(input('param.')); // 获取全部参数

        /**
         * 获取get参数
         * */
        echo '<br/>获取get参数';
        var_dump(input('get.id'));
        //获取全部变量
        var_dump(input('get.'));

        $data = ['name' => 'thinkphp', 'status' => '1'];

        /**
         * 获取当前http请求头信息
         */
        echo '</br>当前http请求头信息:';
        $info = $request->header();
        echo $info['accept'] . '<br/>';
        echo $info['accept-encoding'] . '<br/>';
        echo $info['user-agent'] . '<br/>';

        /**
         * 获取当前伪静态后缀
         */
        echo '<br/>获取当前伪静态后缀<br/>';
        $ext = $request->ext();

        //设置cookie值
        response()->cookie('name', '他妈', 600);

//        return $data['name'].'---'.$data['status'];
//        response()->data($data);
//        json()->data($data);
        json($data, 201);
    }

    //参数绑定
    public function read($userId = 0)
    {
//        echo Request::cookie('name');//获取cookie
        return "id=" . $userId;
    }


    //请求对象静态调用
    public function index1()
    {
        var_dump(Request::host());
        return Request::param('name');
    }

    //请求对象 助手函数
    public function index2()
    {
        return request()->param('name');
    }


    public function hello($name = 'ThinkPHP6')
    {
        //redirect助手函数重定向  站外地址
//        return redirect('http://www.thinkphp.cn');

        // 记住当前地址并重定向
        return redirect('hello')
            ->with('name', 'thinkphp')
            ->remember();

        //站内重定向
        redirect('/index/hello/name/thinkphp');

        //传参 自动生成url
        redirect((string)url('hello', ['name' => 'think']));
    }

    //文件下载
    public function download()
    {
        // download是系统封装的一个助手函数
        //方法	描述
        //name	命名下载文件
        //expire	下载有效期
        //isContent	是否为内容下载
        //mimeType	设置文件的mimeType类型
        //force	是否强制下载（V6.0.3+）
        return download('robots.txt', 'my.txt')->expire(300);
    }

    public function data()
    {
        $user = new User();
        $data = $user->getList();
        var_dump($data);
    }


    public function addData()
    {
        $data = [
            ['user_name' => '测试用户11', 'phone' => '18938291659', 'ctime' => time()],
            ['user_name' => '测试用户12', 'phone' => '18338291668', 'ctime' => time()],
            ['user_name' => '测试用户13', 'phone' => '18538291677', 'ctime' => time()],
        ];
        $user = new User();

        $result = $user->addUser($data);

//        $result = $user
        var_dump($result);
    }

    /**
     * 更新数据
     */
    public function updateData()
    {
        $id = Request::param('id');
        $user_name = Request::param('name');
        $data = array(
            'status' => 1,
            'ctime' => time()
        );
        $user = new User();
        $result = $user->updateUser($id, $data);
        if ($result) {
            $this->ajaxSuccess('更新成功');
        } else {
            $this->ajaxError('更新失败');
        }
    }


    public function deleteUser()
    {
        $id = Request::get('id');
        $user = new User();
        $result = $user->deleteUser($id);
        if ($result) {
            $this->ajaxSuccess('删除成功');
        } else {
            $this->ajaxError('删除失败');
        }
    }

    //查询表达式
    public function selectBds()
    {
        $appVersion = new AppVersion();
        $res = $appVersion->where("")->select();
    }
    public function select()
    {
        $userInfo = $this->user->where('user_id','=',38)->find();
        dump($userInfo);
    }

    public function update()
    {
//        $update = $this->user->where('user_id','=',38)->update(['user_name'=>'ahudj1671']);
//        $update = $this->user->where('user_id','=',38)->data(['user_name'=>'ahudj1761'])->update();
        //用户角色
        $update = $this->user->where('user_id','=',38)->dec('level',1)->update();//inc 自增 ；dec自减
        dump( $update);
    }

    public function selectBs()
    {
        $user = $this->user->where('user_id','=',24)->select();
    }

    public function bds()
    {
//        $user = $this->user->whereLike('user_name','ahudj17%')->select()->toArray();
        $user = $this->user->whereBetween('')->select()->toArray();
        dump($user);
    }

    //
    public function shiwu()
    {
    }


}
