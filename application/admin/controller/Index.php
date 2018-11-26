<?php
/**
 * Created by PhpStorm.
 * User: liugao
 * Date: 10/2/2018
 * Time: 14:18
 */

namespace app\admin\controller;


use think\Controller;
use think\Cookie;

class Index extends BaseAdminController
{
    public function index()
    {
        $this->checkAuth();
        echo $this->fetch();
    }

    public function login()
    {
        return $this->fetch();
    }

    public function loginGrantToken(){
        $username = '22';
        $password = 'eee';
        $passwordDateMd5 = md5(md5($password).date('Y-m-d',time()) );//密码eee的md5值，加上data字符串，合起来之后再md5加密
        $data = input('post.');
        if($data['password'] == $passwordDateMd5)
        {
            $token = $this->generateAdminToken();
            $expire = config('setting.admin_token_expire');
            Cookie::set('adminToken',$token,$expire);
            $res = cache('adminToken', $token, $expire);//cache的expire时间相对创建时间的，不是相对上一次访问时间的
            return boolResult($res,'登录成功','服务器异常，登陆失败');
        }
        else
            return codeResult(0,'密码错误');
    }



    public function generateAdminToken(){
        $randChar = getRandChar(32);
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        $tokenSalt = config('secure.admin_token_salt');
        return md5($randChar . $timestamp . $tokenSalt);
    }


    public function welcome()
    {
        echo 'welcome';
    }
}