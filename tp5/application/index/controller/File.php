<?php

namespace app\index\controller;

use think\Controller;
use app\index\model\Directory as DirModel;
use app\index\model\File as FileModel;

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
        $dir_now = $this->request->param("dir_now");
        $fileMod = new FileModel();
        $result =  $fileMod->where("file_dir_id", $dir_now["dir_id"])->select();
        return json($result);
        // return json($data);
    }
    // 获取目录
    public function get_directory()
    {
        $dir_now = $this->request->param("dir_now");
        $dir_id = $dir_now["dir_id"];
        //getdata
        $result = DirModel::where('dir_parentid', $dir_id)->select();
        return json($result);
    }
    //获取目录导航
    public function get_nav()
    {
        $dir_now = $this->request->param("dir_now");
        // 循环得到导航数组
        $NavArray = [];
        // 入栈
        $dir_parentid = $dir_now["dir_parentid"];
        array_unshift($NavArray, $dir_now);
        while ($dir_parentid != 0) {
            $temp_result = DirModel::where("dir_id", $dir_parentid)
                ->select();

            // halt($temp_result);
            $dir_parentid = $temp_result[0]["dir_parentid"];
            array_unshift($NavArray, $temp_result[0]);
        }
        return json($NavArray);
    }
    // 上传文件
    public function upload_file()
    {
        $files = $this->request->file("filesinput");
        //没有文件
        if (!$files) {
            return "files not found";
        }
        $dir_now = (array)json_decode($this->request->param("dir_now"));
        //没有目录
        if (!$dir_now) {
            return "directory not found";
        }
        $path = $dir_now["dir_acu_path"] . "/";
        //判断有无目录,没有则创建
        if (!is_dir($path)) {
            $mkdir_result = mkdir($path, 0777, true);
            if (!$mkdir_result) {
                return "mkdir fail";
            }
        }
        //实例化文件模型对象

        //完成文件移动及数据库入库操作
        foreach ($files as $file) {
            $info = $file->move($path, "");
            if ($info) {
                $file_info = $info->getInfo();
                $name = $info->getSavename();
                $dir_acu_path = $path . $name;
                $insertData = [
                    "file_name" => $file_info["name"],
                    "file_dir_id" => $dir_now["dir_id"],
                    "file_acu_path" => $dir_acu_path,
                    "file_upload_time" => date("Y-m-d H:i:s"),
                    "file_size"     => $file_info["size"],
                    "file_md5_name" => $name,
                    "file_type"      => $file_info["type"]
                ];
                $fileMod = new FileModel();
                $insert_result = $fileMod->save($insertData);
                if (!$insert_result) {
                    return "文件信息插入失败";
                }
            } else {
                return $file->getError();
            }
        }
        //文件夹数据库新增文件数
        $dirMod = new DirModel();
        $dirMod->where("dir_id", $dir_now["dir_id"])->setInc("dir_file_num", count($files));
        return "success";
    }
    //文件下载
    public function download_file()
    {
        
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
        $result = DirModel::create($insertData);
        return $result;
    }
}
