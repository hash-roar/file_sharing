<?php

namespace app\index\controller;

use think\Controller;
use app\index\model\Directory as DirModel;
use app\index\model\File as FileModel;

class File extends Controller
{
    protected $Rootpath = "./uploads/";
    protected $uploads_path = "uploads";
    protected $uploading_path = "uploads/uploading_temp";
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
    public function upload()
    {
        $post =  (array)json_decode($this->request->param("post"));
        //错误抛出
        $dir_now = $post["dir_now"];
        $dir_now = (array)$dir_now;
        if (!$dir_now) return "directory not found";
        $file = $this->request->file("slice");
        if (!$file) return "file not upload";
        //根据md5名字建立临时文件夹
        $md5_name = md5($post["file_name"]);
        $uploading_path_name = $this->uploading_path . "/" . $md5_name;
        if (!file_exists($uploading_path_name)) {
            mkdir($uploading_path_name);
        }
        //移动文件
        $info  = $file->move($uploading_path_name, $post["index"] . "", true, false);
        // 当文件夹里有所有文件时合并文件
        if (count(scandir($uploading_path_name)) == $post["chunk_num"] + 2) {
            $file_path = $dir_now["dir_acu_path"];
            if(!file_exists($file_path))
            {
                mkdir($file_path,0777,true);
            }
            for ($i = 0; $i < $post["chunk_num"]; $i++) {
                $temp_data = file_get_contents($uploading_path_name . "/" . $i);
                file_put_contents($file_path . "/" . $post["file_name"], $temp_data, FILE_APPEND);
            }
            //数据库操作
            $filetype = explode(".", $post["file_name"]);
            $insertData = [
                "file_name" => $post["file_name"],
                "file_dir_id" => $dir_now["dir_id"],
                "file_acu_path" => $dir_now["dir_acu_path"] . "/" . $post["file_name"],
                "file_upload_time" => date("Y-m-d H:i:s"),
                "file_size"     => $post["file_total_size"],
                "file_md5_name" => md5($post["file_name"]),
                "file_type"      => array_pop($filetype)
            ];
            $fileMod = new FileModel();
            $insert_result = $fileMod->save($insertData);
            if (!$insert_result) {
                return "文件信息插入失败";
            }
            //让文件夹下文件数量加1,在redis上操作更合适,现在直接在mysql数据库上操作
            $dirMod = new DirModel();
            $dirMod->where("dir_id", $dir_now["dir_id"])->setInc("dir_file_num", 1);
            return "文件上传成功";
        } else {
            return "分片" . $post["index"] . "上传成功";
        }
    }
    //删除文件夹
    public function deleteAll()
    {
        $temp_dir_array = scandir($this->uploading_path);
        foreach ($temp_dir_array as $dir) {
            if ($dir != "." && $dir != "..") {
                $temp_file_array = scandir($this->uploading_path . "/" . $dir);
                foreach ($temp_file_array as $file) {
                    if ($file != "." && $file != "..") {
                        unlink($this->uploading_path . "/" . $dir . "/" . $file);
                    }
                }
                rmdir($this->uploading_path . "/" . $dir);
            }
        }
        return "删除成功";
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
