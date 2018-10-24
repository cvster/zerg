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
        echo $this->fetch('',['categories'=>$categories]);
    }

    public function add()
    {
        echo $this->fetch();
    }


    //添加分类时在这里保存,表单提交的形式是post。现在只有一个name
    public function addSave()
    {
        //todo: validate，待完善
        $data = input('post.');
        if($data['name'] == '')
            $this->error('分类名不能为空');

        //将接收的图片放在/public/images目录下。
        $file = Request::instance()->file('file');
        $info = $file->move('images');
        if(!$info)  return jsonResult(0,'文件上传存储失败');
        $pathInfo = $info->getPathname();
        $pathInfo = '/'.str_replace('\\', '/',  $pathInfo);//在windows下调试的时候，获取的pathname是 \ ，但是最后是要部署到linux上的，是 / ，而windows上两个都行，所有换成 /

        //将img信息存入数据库
        $image = new ImageModel;
        $image->url = $pathInfo;
        $image->from = 1;//来自本地
        $image->useage_comment = 'useless';
        $res = $image->save();
        if(!$res)  return jsonResult(0,'图像路径存入数据库时产生异常');

        //将category信息存入数据库
        $category = new CategoryModel;
        $category->name = $data['name'];
        $category->topic_img_id = $image->id;
        $res = $category->save();
        if(!$res)  return jsonResult(0,'分类信息存入数据库时产生异常');

        $image->useage_comment = 'image for category id = '.($category->id);
        $image->save();

        return jsonResult(1,'保存成功');
    }




    public function edit($id,$name)
    {
        $category = ['name'=>$name, 'id'=>$id];
        return $this->fetch('',['category'=>$category]);
    }

    public function editSave()
    {
        $data = input('post.');//['id', 'name']
        $validate = new CategoryValidate();
        if(!$validate->scene('edit')->check($data)){
            $this->error($validate->getError());
        }
        $category = CategoryModel::get($data['id']);

        $category->name = $data['name'];
        $res = $this->categoryModel->save($data,['id'=>$data['id']]);
        $this->echoResultMsg($res);
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
            return json('参数错误');
        }

        $category = CategoryModel::get($id);
        if($category->order == $listorder)
            $this->result($_SERVER['HTTP_REFERER'], 2,'listorder not change');
        ///$_SERVER['HTTP_REFERER']是教程里面用来刷新页面的，这里没啥用

        $category->order = $listorder;
        $res=$category->save();
        //$categoryModel = new CategoryModel();
        //$res = $categoryModel->save(['order'=>$listorder], ['id'=>$id]);//save两个参数表示更新，第一个是更新的字段，第二个是where
        if($res) {
            $this->result($_SERVER['HTTP_REFERER'], 1,'success');
        }else {
            $this->result($_SERVER['HTTP_REFERER'], 0, '更新失败');
        }
    }

}