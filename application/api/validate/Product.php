<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2018/11/3
 * Time: 22:01
 */

namespace app\api\validate;


class Product extends BaseValidate
{

    protected  $rule = [
        ['name', 'require|max:1000', '分类名必须传递|分类名不能超过10个字符'],
        ['id', 'isPositiveInteger'],
        ['listorder', 'number'],
    ];

    /**场景设置**/
    protected  $scene = [
        'add' => ['name', 'id'],// 添加, 这里id没有require，所以可以没有id
        'edit' => ['name', 'id'],// 编辑
        'listorder' => ['id', 'listorder'], //排序
    ];

}