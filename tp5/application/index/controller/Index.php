<?php
namespace app\index\controller;

use think\facade\Log;

class Index
{
    public function index()
    {
        return "logtest";
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
}
