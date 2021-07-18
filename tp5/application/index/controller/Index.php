<?php
namespace app\index\controller;

use think\facade\Log;

class Index
{
    public function index()
    {
        Log::record("test","error");
        return "logtest";
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
}
