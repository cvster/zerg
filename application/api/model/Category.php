<?php

namespace app\api\model;

use think\Model;

class Category extends BaseModel
{
    public function products()
    {
        return $this->hasMany('Product', 'category_id', 'id');
    }

    public function img()
    {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }

    public static function getCategories($ids)
    {
        $categories = self::with('products')
            ->with('products.img')
            ->select($ids);
        return $categories;
    }

    public static function getCategory($id)
    {
        $category = self::with('products')
            ->with('products.img')
            ->find($id);
        return $category;
    }

    //$num,每页显示的数量
    public function getCategoriesByPage($num)
    {
        $categories = self::with('products,img')
            ->order('listorder')
            ->paginate($num);
        return $categories;
    }

    public function mySave($name=null, $topic_img_id=null){
        //不能用$this->name = $name; $this->save(),因为这样$this->name改变的是category类的name

        if($name != null)
            $data['name'] = $name;
        if($topic_img_id != null)
            $data['topic_img_id']= $topic_img_id;

        return $this->save($data);
    }
}
