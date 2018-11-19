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
use app\api\model\ProductImage as ProductImageModel;

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
            return codeResult(0,'参数错误');
        }

        $product = ProductModel::get($id);
        if($product->listorder == $listorder)
            $this->result($_SERVER['HTTP_REFERER'], 2,'listorder not change');

        $product->listorder = $listorder;
        $res = $product->save();
        return boolResult($res,'更新成功','更新失败');
    }


    public function add()
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
        $categories =$categoryModel->getAllCategories();//获取所有category供编辑时选择
        $imgs = $product->imgs;//商品详情图片,hasMany 'ProductImage'
        return $this->fetch('product/edit',['product'=>$product, 'categories'=>$categories, 'imgs'=>$imgs]);
    }


    //添加分类时在这里保存,表单提交的形式是post。
    public function save()
    {
        //todo 加validate
        $data = input('post.');

        //id = -1表示新增, 不等于-1表示编辑
        if($data['id'] == -1)
            return $this->addSave($data);
        else
            return $this->editSave($data, $data['id']);
    }

    protected function addSave($data){
        //保存商品主图
        $mainImg = request()->file('file');
        if(!$mainImg) return codeResult(0,'未选择商品主图');
        $mainImgPath=moveImg($mainImg);

        //存储数据库
        $product = new ProductModel();
        unset($data['id']);
        $data['main_img_url'] = $mainImgPath;
        $res = $product->allowField(true)->save($data);
        if(!$res) return codeResult(0, '数据库存储异常');

        //如果有商品详情图片，则存储
        $detailImgs = request()->file('files');
        if($detailImgs){
            foreach ($detailImgs as $index => $detailImg) {
                $detailImgPath = moveImg($detailImg);
                $productImageModel = new ProductImageModel();
                $productImageModel->easySave($detailImgPath,$index,$product->id);
            }
        }
        return codeResult(1,'保存成功');
    }

    protected function editSave($data)
    {
        $product = ProductModel::where('id',$data['id'])->with('imgs')->find();//find返回结果是单个对象，select返回结果是数组

        //存储main_img
        $mainImg = request()->file('file');//这里需要判断是不是有文件，没有的话就用原来的图片，有的话就用新的图片，并删掉原来的。
        if($mainImg){
            $data['main_img_url'] = moveImg($mainImg);//保存新的主图片
            tryDelete($product->main_img_url);//删除旧的主图片
        }

        //保存product信息，（除detailImgs之外的）
        $res = $product->allowField(true)->save($data);
        if(!$res)  return codeResult(0,'数据库存储时产生异常');

        //保存detailImgs信息并删除旧的detailImgs
        $detailImgs = request()->file('files');
        if($detailImgs){
            $oldDetailimgs = ProductImageModel::where('product_id',$product->id)->select();
            //删除旧的detailImgs
            foreach($oldDetailimgs as $oldDetailimg){
                tryDelete($oldDetailimg->img_url);
                $oldDetailimg->delete();
            }
            //保存新的detailImgs
            foreach ($detailImgs as $index => $detailImg) {
                $detailImgPath = moveImg($detailImg);
                $productImageModel = new ProductImageModel();
                $productImageModel->easySave($detailImgPath,$index,$product->id);
            }
        }
        return codeResult(1,'保存成功');
    }

}