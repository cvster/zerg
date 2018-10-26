<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
//输入1正常，0待审，其他删除，输出html标签
function htmlStatus($status) {
    if($status == 1) {
        $str = "<span class='label label-success radius'>正常</span>";
    }elseif($status ==0) {
        $str = "<span class='label label-danger radius'>待审</span>";
    }else {
        $str = "<span class='label label-danger radius'>删除</span>";
    }
    return $str;
}



function jsonResult($code, $msg='', $data=[]) {
    return [
        'code' => intval($code),
        'msg' => $msg,
        'data' => $data,
    ];
}

function resResult($res, $successMsg='' , $errorMsg='', $data=[]) {
    return [
        'code' => $res? 1:0,
        'msg' => $res? $successMsg:$errorMsg,
        'data' => $data,
    ];
}

/**
 * @param $deleteFileUrl, 要删除的文件路径，相对于public目录来说的。因为$_SERVER['DOCUMENT_ROOT']是public路径
 * @return bool, 删除成功或者失败
 */
function tryDelete($deleteFileUrl){
    $deleteImagePath = $_SERVER['DOCUMENT_ROOT'].$deleteFileUrl;
    try{
        unlink($deleteImagePath);
    }catch (\Exception $e){
        return false;
    }
    return true;
}