<?php
/**
 * Created by PhpStorm.
 * User: liugao
 * Date: 10/10/2018
 * Time: 20:16
 */

namespace app\admin\controller;


use app\lib\exception\CodeException;
use think\Controller;
use think\Request;

class BaseAdminController extends Controller
{
    //所有admin的controller都从这里走一下initialize
    public function _initialize(){
//        \think\Config::set('default_return_type', 'html');//设置默认返回类型为html，在模块下面的config.php里设置了，这里注释掉
    }


    // 检查管理员身份，查看cookie中Token是否有效
    public function checkAuth()
    {
        $cookieAdminToken = cookie('adminToken');
        $cacheAdminToken = cache('adminToken');
        if($cookieAdminToken = $cacheAdminToken)
        {
            return true;
        }
        else
        {
            //这里之所以要throw Exception，是因为如果return的话，调用它的函数还要return，不方便，所以用throw Exception，
            //在全局异常处理函数中，CodeException就return一个json的result，没干别的事。
            $this->redirect('admin/index/login');//如果前端不是ajax请求，则直接redirect。如果是，则下面return一个codeException
            throw new CodeException(3,'登录过期或失效，请重新登录',null,302);

        }

    }
}