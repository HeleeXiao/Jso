<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

/**
 * @Class Category
 * @package App\Models\Base
 * @User: ???@jtrips.com
 * @property string $id 分类表
 * @property string $name 名称
 * @property string $englishName 英文名称
 * @property string $parentEnglishName 父级分类名称
 * @property string $level 分类层级
 * @property string $meta 省份
 * @property string $attr 额外参数
 * @property string $orderId 额外参数
 * @property string $createdAt 
 * @property string $updatedAt 
 *
 */

class Category extends Model
{
    use Eloquence, Mappable;

    protected $table = 'category';

    protected $maps = [
        'englishName'    => 'english_name',   //英文名称
        'parentEnglishName'=> 'parent_english_name',//父级分类名称
        'orderId'        => 'order_id',       //额外参数
    ];

}