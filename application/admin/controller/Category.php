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

//    //添加分类时在这里保存,表单提交的形式是post。现在只有一个name
//    public function addSave()
//    {
//        //todo: 加validate
//        $data = input('post.');
//        if($data['name'] == '')
//            $this->error('分类名不能为空');
//
//        Db::startTrans();
//        try{
//            $category = new CategoryModel;
//            $category->name = $data['name'];
//            $category->topic_img_id = $data['imgId'];
//            $res = $category->save();
//            if($res){
//                $image = ImageModel::get($data['imgId']);
//                $imgId = $image->id;
//                $image->useage_comment = 'image for category id = '.$imgId;
//                $res2=$image->save();
//            }
//        }
//        catch (\Exception $exception){
//            //错误信息
//            $this->result(null,0,'数据存储错误');
//            Db::rollback();
//            //应该加入log
//        }
//
//        $this->result(null,$res&&$res2 ? 1:0);
//    }


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
            $data = input('post.');
            $res = CategoryModel::destroy(intval($data['id']));
            $this->result(null,$res?1:0);
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

    public function imageUpload(){
        $req=request();
        $data=input('post.');
        $file = Request::instance()->file('file');
        //将接收的图片放在一个目录下。
        $info = $file->move('images');
        if($info || $info->getPathname()){
            $pathInfo = $info->getPathname();
            $pathInfo = str_replace('\\', '/',  $pathInfo);//在windows下调试的时候，获取的pathname是 \ ，但是最后是要部署到linux上的，是 / ，而windows上两个都行，所有换成 /
            $pathInfo = '/'.$pathInfo;

            //将img信息存入数据库
            $image = new ImageModel;
            $image->url = $pathInfo;
            $image->from = 1;//来自本地
            $image->useage_comment = 'useless';

            $res = $image->save();
            if($res)
                return json([
                    'imgUrl'=>$pathInfo,
                    'imgId'=>$image->id,
                    'code'=>1,
                    'msg'=>'success'
                ]);
        }else{
            return json([
                'code'=>1,
                'msg'=>'upload error'
            ]);
        }
    }
}