<?php

namespace app\index\controller;

use app\BaseController;
use think\App;
use app\index\model\UserModel;

class Index extends BaseController
{
    protected $one;

    public function __construct(UserModel $one)
    {
        $this->one = $one;
    }

    public function index()
    {
        return $this->one->name;
    }

}
