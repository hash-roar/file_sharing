<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\File as FileMod;
class Search extends Controller
{
    public function index()
    {
        return $this->fetch();;
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
    public function get_book_list(){
        $book_name = $this->request->param("book_name");
        $fileMod = new FileMod();
        $result = $fileMod->wherelike("file_name","%".$book_name."%")->limit(15)->select();
        return json($result);
    }
}
