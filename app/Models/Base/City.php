<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

/**
 * @Class City
 * @package App\Models\Base
 * @User: ???@jtrips.com
 * @property string $id 城市
 * @property string $cityId 城市id
 * @property string $province 省份
 * @property string $name 名称
 * @property string $englishName 英文名称
 * @property string $attr 额外参数
 * @property string $orderId 额外参数
 * @property string $createdAt 
 * @property string $updatedAt 
 *
 */

class City extends Model
{
    use Eloquence, Mappable;

    protected $table = 'city';

    protected $maps = [
        'cityId'         => 'city_id',        //城市id
        'englishName'    => 'english_name',   //英文名称
        'orderId'        => 'order_id',       //额外参数
    ];

}