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

    public function mySave($url=null, $from=null, $usage_comment=null){

        if($url!=null)
            $data['url'] = $url;
        if($from!=null)
            $data['from'] = $from;
        if($usage_comment != null)
            $data['usage_comment'] = $usage_comment;

        return $this->save($data);
    }
}

