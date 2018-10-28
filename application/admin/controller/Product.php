<?php
/**
 * Created by PhpStorm.
 * User: liugao
 * Date: 10/2/2018
 * Time: 14:18
 */

namespace app\admin\controller;


use think\Controller;

class Product extends Controller
{
    public function index()
    {
        echo $this->fetch();
    }

//    public function add()
//    {
//        echo $this->fetch();
//    }

//    public function save()
//    {
//        return input('post.');
//    }

}