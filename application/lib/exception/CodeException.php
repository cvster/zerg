<?php
/**
 * Created by PhpStorm.
 * User: liugao
 * Date: 11/26/2018
 * Time: 15:55
 */

namespace app\lib\exception;
use think\Exception;

class CodeException extends Exception
{
    public $resultCode = 0;
    public $resultMsg = 'This is a CodeException';
    public $resultData = [];
    public $httpCode = 400;

    /**
     * 构造函数，接收一个关联数组
     * @param array $params 关联数组只应包含code、msg和errorCode，且不应该是空值
     */
    public function __construct($resultCode=null, $resultMsg=null,$resultData=null,$httpCode=null)
    {
        if($resultCode!=null) $this->resultCode = $resultCode;
        if($resultMsg!=null)  $this->resultMsg = $resultMsg;
        if($resultData!=null) $this->resultData = $resultData;
        if($httpCode!=null)   $this->httpCode = $httpCode;
    }
}