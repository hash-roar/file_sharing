<?php

namespace app\index\controller;

use think\Controller;

class File extends Controller
{
    public function index()
    {
        return "logtest";
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
                "file_name"=>"book1",
                "file_id"=>"1",
                "file_upload_time" =>"201-7-18"
            ],
            [
                "file_name"=>"book2",
                "file_id"=>"2",
                "file_upload_time" =>"201-7-18"
            ],
        ];
        return json($data);
    }
    // 获取目录
    public function get_directory(){
        $data=[
            [
                "dir_id" => 1,
                "dir_name" => "dir1",
                " dir_create_time"=>date("Y-m-d")
            ],
            [
                "dir_id" => 2,
                "dir_name" => "dir2",
                " dir_create_time"=>date("Y-m-d")
            ],
        ];
        return json($data);
    }
    // 上传文件
    public function upload_file(){
        $success=[];
        $files =$this->request->file("filesinput");
        foreach($files as $file){
            $info = $file->move("./uploads/books/","");
            if($info){
                array_push($success,$info);
            }else{
                return $file->getError();
            }
        }
    }
   
}
