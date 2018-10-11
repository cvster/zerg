<?php
/**
 * Created by PhpStorm.
 * User: liugao
 * Date: 10/2/2018
 * Time: 14:18
 */

namespace app\admin\controller;


use think\Controller;
use app\api\controller\v1\Category as CategoryApi;
use app\api\validate\Category as CategoryValidate;
use app\api\model\Category as CategoryModel;

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
        $data = input('post.');
        if($data['name'] == '')
            $this->error('分类名不能为空');

        $category = new CategoryModel;
        $category->name = $data['name'];
        $res = $category->save();
        $this->echoResultResponse($res);
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

        public function delete($id)
        {
            $res = CategoryModel::destroy($id);
            $this->echoResultResponse($res);
        }


    public function listorder($id, $listorder)
    {
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