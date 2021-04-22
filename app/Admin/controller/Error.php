<?php

namespace app\Admin\controller;

class Error
{

    public function __call($name, $arguments)
    {
        return 'error request';
    }
}