<?php

namespace app\api\model;

use think\Model;

class Category extends BaseModel
{
    public function products()
    {
        return $this->hasMany('Product', 'category_id', 'id');
    }

//    public function img()
//    {
//        return $this->belongsTo('Image', 'topic_img_id', 'id');
//    }

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
        $categories = self::order('listorder')//with('products,img')
            ->paginate($num);
        return $categories;
    }

    //$num,每页显示的数量
    public function getAllCategories()
    {
        $categories = self::with('products')
            ->order('listorder')->select();
        return $categories;
    }

    //调用该函数时，需先通过 xxModel::get($id) 或者 new xxModel 创建 model对象。
    public function easySave($name=null, $img_url=null){
        //不能用$this->name = $name; $this->save(),因为这样$this->name改变的是category类的name

        if($name != null)
            $data['name'] = $name;
        if($img_url != null)
            $data['img_url']= $img_url;

        return $this->save($data);
    }
}
