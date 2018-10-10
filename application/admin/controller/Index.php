<?php
/**
 * Created by PhpStorm.
 * User: liugao
 * Date: 10/2/2018
 * Time: 14:18
 */

namespace app\admin\controller;


use think\Controller;

class Index extends Controller
{
    public function index()
    {
        echo $this->fetch();
    }
    public function welcome()
    {
        echo '欢迎来到测试后台界面';
    }
}