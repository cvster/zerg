<?php
/**
 * Created by 七月.
 * Author: 七月
 * 微信公号：小楼昨夜又秋风
 * 知乎ID: 七月在夏天
 * Date: 2017/2/20
 * Time: 1:34
 */

namespace app\api\model;


use think\Model;

class ProductImage extends BaseModel
{
    protected $hidden = ['img_id', 'delete_time', 'product_id'];
    public function imgUrl()
    {
        return $this->belongsTo('Image', 'img_id', 'id');
    }

    //调用该函数时，需先通过 xxModel::get($id) 或者 new xxModel 创建 model对象。
    public function easySave($img_url=null, $order=null, $product_id){

        if($img_url != null)             $data['img_url'] = $img_url;
        if($order != null)                $data['order']= $order;
        if($product_id != null)            $data['product_id']= $product_id;

        return $this->save($data);
    }

}