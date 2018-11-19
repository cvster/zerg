<?php

namespace app\api\model;

use think\Model;

class Image extends BaseModel
{
    protected $hidden = ['delete_time', 'id', 'from'];

    public function getUrlAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
    }

    //调用该函数时，需先通过 xxModel::get($id) 或者 new xxModel 创建 model对象。
    public function easySave($url=null, $from=null, $usage_comment=null){

        if($url!=null)
            $data['url'] = $url;
        if($from!=null)
            $data['from'] = $from;
        if($usage_comment != null)
            $data['usage_comment'] = $usage_comment;

        return $this->save($data);
    }
}

