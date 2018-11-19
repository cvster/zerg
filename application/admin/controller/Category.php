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

    public function edit($id)
    {
        $category = CategoryModel::get($id);
        $imgUrl = $category->img_url;
        $category = ['name'=>$category->name, 'id'=>$id, 'imgUrl'=>$imgUrl];
        return $this->fetch('category/edit',['category'=>$category]);
    }

    //添加分类时在这里保存,表单提交的形式是post。
    public function save()
    {
        //todo: validate，待完善
        $data = input('post.');
        $id = $data['id'];
        $name = $data['name'];
        if($data['name'] == '')
            $this->error('分类名不能为空');

        //id = -1表示新增, 不等于-1表示编辑
        if($id == -1)
            return $this->addSave($name);
        else
            return $this->editSave($name, $id);
    }

    protected function addSave($name){
        //将接收的图片放在/public/images目录下。
        $file = request()->file('file');
        if(!$file) return codeResult(0,'未选择图片');
        $imgPathInfo=moveImg($file);

        //将category信息存入数据库
        $category = new CategoryModel;
        $res = $category->easySave($name,$imgPathInfo);
        return boolResult($res,'保存成功','保存失败');
    }

    protected function editSave($name, $id)
    {
        $category = CategoryModel::get($id);
        $imgFile = Request::instance()->file('file');//这里需要判断是不是有文件，没有的话就用原来的图片，有的话就用新的图片，并删掉原来的。

        if(!$imgFile){//说明没有改图片
            $res = $category->easySave($name);
            return boolResult($res,'保存成功','数据库存储时产生异常');
        }
        else{//有文件，说明改了图片，先保存category，再尝试删掉原来的图片。

            $oldImgPath=$category->img_url;//获取旧图片的url
            $newImgPath = moveImg($imgFile);//保存新的img文件

            //保存category信息
            $res = $category->easySave($name,$newImgPath);
            if(!$res)  return codeResult(0,'数据库存储时产生异常');

            //保存成功之后，再尝试删除旧图片，不成功也没关系，仍然返回成功代码1，但是做出提示
            if(!tryDelete($oldImgPath))
                return codeResult(1,'分类删除成功,但是分类图片删除失败');

            return codeResult(1,'保存成功');
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
            if(!$res)  return codeResult(0,'删除失败');

            try{
                ImageModel::destroy(intval($image->id));
                unlink($imagePath);
            }catch (\Exception $e){
                return codeResult(0,'分类删除成功,但是分类图片删除失败');
            }

            return codeResult(1,'删除成功');
        }


    public function listorder($id, $listorder)
    {
        $req=request();
        $categoryValidate = new CategoryValidate();
        $data = [ 'id'=>$id, 'listorder'=>$listorder ];
        if(!$categoryValidate->scene('listorder')->check($data)){
            return codeResult(0,'参数错误');
        }

        $category = CategoryModel::get($id);
        if($category->listorder == $listorder)
            return codeResult(2,'listorder not change');
        ///$_SERVER['HTTP_REFERER']是教程里面用来刷新页面的，这里没啥用

        $category->listorder = $listorder;
        $res=$category->save();
        //$categoryModel = new CategoryModel();
        //$res = $categoryModel->save(['order'=>$listorder], ['id'=>$id]);//save两个参数表示更新，第一个是更新的字段，第二个是where
        return boolResult($res,'更新成功','更新失败');
    }

}