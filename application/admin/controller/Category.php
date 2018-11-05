<?php
/**
 * Created by PhpStorm.
 * User: liugao
 * Date: 10/2/2018
 * Time: 14:18
 */

namespace app\admin\controller;


use think\Controller;
use app\api\validate\Category as CategoryValidate;
use app\api\model\Category as CategoryModel;
use think\File;
use think\Request;
use app\api\model\Image as ImageModel;
use think\Db;

class Category extends BaseAdminController
{

    private $categoryModel;

    public function _initialize()
    {
        $this->categoryModel = new CategoryModel();
        parent::_initialize();
    }

    public function index()
    {
        $pageNum = config('setting.category_page_num');
//        $categoryValidate = new CategoryValidate();
//        $checkResult = $categoryValidate->isPositiveInteger($pageNum);    //这个是用来测试BaseValidate中函数的调用的。直接用里面的函数挺方便。
//        if(!$checkResult)
//            return '分页参数错误';

        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getCategoriesByPage($pageNum);
//        return 'aa';
        echo $this->fetch('',['categories'=>$categories]);
    }

    public function add()
    {
        $category = ['name'=>'','id'=>-1,'imgUrl'=>'/static/images/chooseImage2.jpg', ];//id = -1 表示新增，这里imgUrl是一个‘请添加图片的图’，实际还需要上传图片
        return $this->fetch('category/edit',['category'=>$category]);
    }

    public function edit($id,$name)
    {
        $category = CategoryModel::get($id);
        $image = ImageModel::get($category->topic_img_id);
        $imgUrl = $image->url;
        $category = ['name'=>$name, 'id'=>$id, 'imgUrl'=>$imgUrl];
        return $this->fetch('category/edit',['category'=>$category]);
    }

    //添加分类时在这里保存,表单提交的形式是post。
    public function save()
    {
        //todo: validate，待完善
        $data = input('post.');
        $id = $data['id'];
        if($data['name'] == '')
            $this->error('分类名不能为空');

        //id = -1表示新增, 否则表示编辑
        if($id == -1)
            return $this->addSave($data);
        else
            return $this->editSave($data, $id);
    }

    protected function addSave($data){
        //将接收的图片放在/public/images目录下。
        $file = Request::instance()->file('file');
        if(!$file) return jsonResult(0,'未选择图片');

        $info = $file->move('images');
        $pathInfo = $info->getPathname();
        $pathInfo = '/'.str_replace('\\', '/',  $pathInfo);//在windows下调试的时候，获取的pathname是 \ ，但是最后是要部署到linux上的，是 / ，而windows上两个都行，所有换成 /

        //将img信息存入数据库
        $image = new ImageModel;
        $res = $image->mySave($pathInfo,1,'useless');
        if(!$res)  return jsonResult(0,'图像路径存入数据库时产生异常');

        //将category信息存入数据库
        $category = new CategoryModel;
        $res = $category->mySave($data['name'],$image->id);
        if(!$res)  return jsonResult(0,'数据库存储时产生异常');

        $image->usage_comment = 'image for category id = '.($category->id);
        $image->save();

        return jsonResult(1,'保存成功');
    }

    protected function editSave($data, $id)
    {
        $category = CategoryModel::get($id);
        $file = Request::instance()->file('file');//这里需要判断是不是有文件，没有的话就用原来的图片，有的话就用新的图片，并删掉原来的。

        if(!$file){//说明没有改图片
            $res = $category->mySave($data['name']);
            return resResult($res,'保存成功','数据库存储时产生异常');
        }
        else{//有文件，说明改了图片，先保存category，再尝试删掉原来的图片。

            //获取旧图片的url
            $oldImg=ImageModel::get($category->topic_img_id);
            $oldImgUrl=$oldImg->url;

            //保存img文件
            $info = $file->move('images');
            $pathInfo = $info->getPathname();
            $pathInfo = '/'.str_replace('\\', '/',  $pathInfo);//在windows下，获取的pathname是 \ ，但是最后是要部署到linux上的，是 / ，而windows上两个都行，所有换成 /

            //将img信息存入数据库
            $image = new ImageModel;
            $res = $image->mySave($pathInfo,1, 'image for category id = '.($category->id));
            if(!$res)  return jsonResult(0,'图像路径存入数据库时产生异常');

            //保存category信息
            $res = $category->mySave($data['name'],$image->id);
            if(!$res)  return jsonResult(0,'数据库存储时产生异常');

            //尝试删除旧图片，不成功也没关系，仍然返回成功代码1，但是做出提示
            if(!tryDelete($oldImgUrl))
                return jsonResult(1,'分类删除成功,但是分类图片删除失败');

            return jsonResult(1,'保存成功');
        }
    }

        public function delete()
        {
            //todo:校验
            $data = input('post.');
            $id = $data['id'];
            $category = CategoryModel::get($id);
            $image = ImageModel::get($category->topic_img_id);
            $imagePath = $_SERVER['DOCUMENT_ROOT'].$image->url;

            $res = CategoryModel::destroy(intval($category->id));
            if(!$res)  return jsonResult(0,'删除失败');

            try{
                ImageModel::destroy(intval($image->id));
                unlink($imagePath);
            }catch (\Exception $e){
                return jsonResult(0,'分类删除成功,但是分类图片删除失败');
            }

            return jsonResult(1,'删除成功');
        }


    public function listorder($id, $listorder)
    {
        $req=request();
        $categoryValidate = new CategoryValidate();
        $data = [ 'id'=>$id, 'listorder'=>$listorder ];
        if(!$categoryValidate->scene('listorder')->check($data)){
            return jsonResult(0,'参数错误');
        }

        $category = CategoryModel::get($id);
        if($category->listorder == $listorder)
            return jsonResult(2,'listorder not change');
        ///$_SERVER['HTTP_REFERER']是教程里面用来刷新页面的，这里没啥用

        $category->listorder = $listorder;
        $res=$category->save();
        //$categoryModel = new CategoryModel();
        //$res = $categoryModel->save(['order'=>$listorder], ['id'=>$id]);//save两个参数表示更新，第一个是更新的字段，第二个是where
        return resResult($res,'更新成功','更新失败');
    }

}