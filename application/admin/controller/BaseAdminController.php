<?php
/**
 * Created by PhpStorm.
 * User: liugao
 * Date: 10/10/2018
 * Time: 20:16
 */

namespace app\admin\controller;


use think\Controller;
use think\Request;

class BaseAdminController extends Controller
{
    //设置默认返回类型为html，在模块下面的config.php里设置了，这里注释掉
    public function _initialize(){
//        \think\Config::set('default_return_type', 'html');
    }

    //用result返回数据时，设置默认返回为json，不然有时候会报错。
    public function result($data, $code = 0, $msg = '', $type = '', array $header = [])
    {
        \think\Config::set('default_return_type', 'json');
        parent::result($data, $code, $msg, $type, $header);
    }


    //回复操作成功和操作失败的提示
    public function echoResultResponse($res){
        if($res)
            $this->success('操作成功');
        else
            $this->error('操作失败');

    }

    public function echoResultMsg($res){
        if($res)
            echo '   操作成功   ';
        else

            echo '   操作失败   ';
    }

    //设置 $this->success 和 $this->error 的等待时间为2
    public function success($msg = '', $url = null, $data = '', $wait = 1, array $header = [])
    {
        parent::success($msg,$url,$data,$wait,$header);
    }

    public function error($msg = '', $url = null, $data = '', $wait = 1, array $header = [])
    {
        parent::error($msg.$url,$data,$wait,$header);
    }

}