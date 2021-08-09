<?php

namespace app\index\controller;

use think\facade\Cookie;
use think\Controller;
use app\index\model\AdminUser;

class Admin extends Controller
{
    //登录处理
    public function login(){
        $name = $this->request->param('name');
        $password = $this->request->param('password');
        //实例化
        $userMod = new AdminUser();
        $query = $userMod->where("user_name", $name)->select();
        if (count($query)==0) {
            return "没有此账户";
        }
        if ($password != $query[0]['user_password']) {
            return "密码错误";
        }
        Cookie::set("admin_user", $name);
        return "success";
    }

}
