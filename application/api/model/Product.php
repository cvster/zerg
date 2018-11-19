<?php

namespace app\api\model;

use think\Model;

class Product extends BaseModel
{
    protected $autoWriteTimestamp = 'datetime';
    protected $hidden = [
        'delete_time', 'main_img_id', 'pivot', 'from',
        'create_time', 'update_time'];

    /**
     * 图片属性
     */
    public function imgs()
    {
        return $this->hasMany('ProductImage', 'product_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('Category', 'category_id', 'id');
    }

    public function getMainImgUrlAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
    }


    public function properties()
    {
        return $this->hasMany('ProductProperty', 'product_id', 'id');
    }

    /**
     * 获取某分类下商品
     * @param $categoryID
     * @param int $page
     * @param int $size
     * @param bool $paginate
     * @return \think\Paginator
     */
    public static function getProductsByCategoryID(
        $categoryID, $paginate = true, $page = 1, $size = 30)
    {
        $query = self::where('category_id', '=', $categoryID);
        if (!$paginate)
        {
            return $query->select();
        }
        else
        {
            // paginate 第二参数true表示采用简洁模式，简洁模式不需要查询记录总数
            return $query->paginate(
                $size, true, [
                'page' => $page
            ]);
        }
    }

    //$num,每页显示的数量 for admin, 分页显示，不是简洁模式 todo: 复制了还没怎么改。
    public function getProductsByPage($num)
    {
//        $products = self::with('products,img')
//            ->order('order')
//            ->paginate($num);
        $products = self::with('category')
            ->order('listorder')
            ->paginate($num);
        return $products;
    }

    /**
     * 获取商品详情
     * @param $id
     * @return null | Product
     */
    public static function getProductDetail($id)
    {
        //千万不能在with中加空格,否则你会崩溃的
        //        $product = self::with(['imgs' => function($query){
        //               $query->order('index','asc');
        //            }])
        //            ->with('properties,imgs.imgUrl')
        //            ->find($id);
        //        return $product;

        $product = self::with(
            [
                'imgs' => function ($query)
                {
                    $query->with(['imgUrl'])
                        ->order('order', 'asc');
                }])
            ->with('properties')
            ->find($id);
        return $product;
    }

    public static function getMostRecent($count)
    {
        $products = self::limit($count)
            ->order('create_time desc')
            ->select();
        return $products;
    }

    //调用该函数时，需先通过 xxModel::get($id) 或者 new xxModel 创建 model对象。
    public function easySave($name=null, $price=null, $stock=null, $category_id=null, $main_img_url=null, $summary=null){
        //不能用$this->name = $name; $this->save(),因为这样$this->name改变的是category类的name

        if($name != null)             $data['name'] = $name;
        if($price != null)            $data['price']= $price;
        if($stock != null)            $data['stock']= $stock;
        if($category_id != null)      $data['category_id']= $category_id;
        if($main_img_url != null)     $data['main_img_url']= $main_img_url;
        if($summary != null)          $data['summary']= $summary;

        return $this->save($data);
    }
}
