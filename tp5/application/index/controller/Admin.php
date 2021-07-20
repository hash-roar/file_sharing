<?php

namespace app\index\controller;

use think\facade\Cookie;
use think\Controller;
use app\index\model\AdminUser;

class Admin extends Controller
{
    public function index(){
        if (!Cookie::has('admin_user')) {
            $this->redirect(url("/index/admin/login_page"));
        }
        return $this->fetch("index");
    }
    public function login_page(){
        return $this->fetch("login_page");
    }
    //登录处理
    public function login(){
        $name = $this->request->param('name');
        $password = $this->request->param('password');
        //实例化
        $userMod = new AdminUser();
        $query = $userMod->where("user_name", $name)->select();
        if (count($query)==0) {
            echo "<script>alert('没有此账户');</script>";
            // redirect(url("/index/index/login_page"));
            return $this->login_page();
        }
        if ($password != $query[0]['user_password']) {
            echo "<script>alert('密码错误');</script>";
            // redirect(url("/index/index/login_page"));
            return $this->login_page();
        }
        Cookie::set("admin_user", $name);
        $this->redirect("/index/admin/index");
    }

}
