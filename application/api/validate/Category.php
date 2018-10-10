<?php
/**
 * Created by PhpStorm.
 * User: liugao
 * Date: 10/9/2018
 * Time: 12:44
 */

namespace app\api\validate;


class Category extends BaseValidate
{
    protected  $rule = [
        ['name', 'require|max:1000', '分类名必须传递|分类名不能超过10个字符'],
        ['parent_id','number'],
        ['id', 'number'],
        ['status', 'number|in:-1,0,1','状态必须是数字|状态范围不合法'],
        ['listorder', 'number'],
    ];

    /**场景设置**/
    protected  $scene = [
        'add' => ['name', 'parent_id', 'id'],// 添加
        'listorder' => ['id', 'listorder'], //排序
        'status' => ['id', 'status'],
    ];

}