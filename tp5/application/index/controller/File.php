<?php

namespace app\index\controller;

use think\Controller;
use app\index\model\Directory as DirModel;

class File extends Controller
{
    protected $Rootpath = "./uploads/";
    public function index()
    {
        $test = DirModel::get(1);
        return "$test";
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
    // 获取文件目录
    public function get_file_list()
    {
        $data = [
            [
                "file_name" => "book1",
                "file_id" => "1",
                "file_upload_time" => "201-7-18"
            ],
            [
                "file_name" => "book2",
                "file_id" => "2",
                "file_upload_time" => "201-7-18"
            ],
        ];
        return json($data);
    }
    // 获取目录
    public function get_directory()
    {
        $dir_now = $this->request->param("dir_now");
        $dir_id = $dir_now["dir_id"];
        //getdata
        $result = DirModel::where('dir_parentid',$dir_id)->select();
        return json($result);
    }
    //获取目录导航
    public function get_nav(){
        $dir_now = $this->request->param("dir_now");
        // 循环得到导航数组
        $NavArray=[];
        // 入栈
        $dir_parentid = $dir_now["dir_parentid"];
        array_unshift($NavArray,$dir_now);
        while($dir_parentid!=0){
            $temp_result = DirModel::where("dir_id",$dir_parentid)
                                    ->select();

            // halt($temp_result);
            $dir_parentid = $temp_result[0]["dir_parentid"];
            array_unshift($NavArray,$temp_result[0]);
        }
        return json($NavArray);
    }
    // 上传文件
    public function upload_file()
    {
        $success = [];
        $files = $this->request->file("filesinput");
        foreach ($files as $file) {
            $info = $file->move("./uploads/books/", "");
            if ($info) {
                array_push($success, $info);
            } else {
                return $file->getError();
            }
        }
    }
    //添加目录
    public function add_directory()
    {
        $dir_info = $this->request->param('dir_info');
        $dir_adding_name = $this->request->param('dir_adding_name');
        $dir_acu_path = $dir_info['dir_acu_path'] . "/" . $dir_adding_name;
        $insertData = [
            "dir_parentid" => $dir_info["dir_id"],
            "dir_name"      => $dir_adding_name,
            "dir_acu_path" => $dir_acu_path,
            "dir_create_time" => date("Y-m-d"),
        ];
        $result=DirModel::create($insertData);
            return $result;
    }
}
