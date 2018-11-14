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
use app\api\model\Category as CategoryModel;
use app\api\validate\Product as ProductValidate;

class Product extends Controller
{
    public function index()
    {
        $productsModel = new ProductModel();
        $products= $productsModel->getProductsByPage(15);
        echo $this->fetch('',['products'=>$products]);
//        echo '重启了php之后又可以打开了2';
    }



    public function listorder($id, $listorder)
    {
        $req=request();
        $productValidate = new ProductValidate();
        $data = [ 'id'=>$id, 'listorder'=>$listorder ];
        if(!$productValidate->scene('listorder')->check($data)){
            return jsonResult(0,'参数错误');
        }

        $product = ProductModel::get($id);
        if($product->listorder == $listorder)
            $this->result($_SERVER['HTTP_REFERER'], 2,'listorder not change');
        ///$_SERVER['HTTP_REFERER']是教程里面用来刷新页面的，这里没啥用

        $product->listorder = $listorder;
        $res = $product->save();
        //$categoryModel = new CategoryModel();
        //$res = $categoryModel->save(['order'=>$listorder], ['id'=>$id]);//save两个参数表示更新，第一个是更新的字段，第二个是where
        return resResult($res,'更新成功','更新失败');
    }


    public function add()//todo 这个还没改
    {
        $categoryModel = new CategoryModel();
        $categories =$categoryModel->getAllCategories();
        $product = ['name'=>'','id'=>-1,'price'=>'','stock'=>'',
            'main_img_url'=>'/static/images/chooseImage2.jpg'];//id = -1 表示新增，这里imgUrl是一个‘请添加图片的图’，实际还需要上传图片
        return $this->fetch('product/edit',['product'=>$product, 'categories'=>$categories, 'imgs'=>[]]);
    }

    public function edit($id,$name)
    {
        //todo 需要加validate
        $product = ProductModel::getProductDetail($id);
        $categoryModel = new CategoryModel();
        $categories =$categoryModel->getAllCategories();
        $imgs = $product->imgs;
        return $this->fetch('product/edit',['product'=>$product, 'categories'=>$categories, 'imgs'=>$imgs]);
    }


    //添加分类时在这里保存,表单提交的形式是post。
    public function save()
    {
        //todo: 刚复制过来
        $data = input('post.');
        $id = $data['id'];
        if($data['name'] == '')
            $this->error('分类名不能为空');

        //id = -1表示新增, 不等于-1表示编辑
        if($id == -1)
            return $this->addSave($data);
        else
            return $this->editSave($data, $id);
    }

    protected function addSave($data){
        $mainImg = request()->file('file');
        if(!$mainImg) return jsonResult(0,'未选择商品主图');
        $mainImgPath=moveImg($mainImg);

        $detailImgs = request()->file('files');
        foreach($detailImgs as $detailImg){
            echo 'aa';
        }

        if(!$detailImgs) return jsonResult(0,'未选择商品详情');
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