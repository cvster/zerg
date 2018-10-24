<?php

namespace app\api\model;

use think\Model;

class Image extends BaseModel
{
    protected $hidden = ['delete_time', 'id', 'from'];

    public function absUrl()//获取相对于public的绝对路径，就是不加前缀prefix
    {
        return $this->url;
    }

    public function getUrlAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
    }
}

