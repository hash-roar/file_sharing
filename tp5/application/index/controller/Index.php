<?php
namespace app\index\controller;

use think\Controller;
use think\facade\Log;

class Index extends Controller
{
    public function index()
    {
        return $this->fetch();;
    }
}
