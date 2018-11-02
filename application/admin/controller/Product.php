<?php
/**
 * Created by PhpStorm.
 * User: liugao
 * Date: 10/2/2018
 * Time: 14:18
 */

namespace app\admin\controller;


use think\Controller;
use app\api\model\Product as ProductModel;

class Product extends Controller
{
    public function index()
    {
//        $productsModel = new ProductModel();
//        $products= $productsModel->getProductsByPage(15);
//        echo $this->fetch('',['products'=>$products]);
        echo 'aa';
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