<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

/**
 * @Class Likes
 * @package App\Models\Base
 * @User: ???@jtrips.com
 * @property string $id 关注的，喜欢的
 * @property string $likeData 数据集
 * @property string $createdAt 
 * @property string $updatedAt 
 *
 */

class Like extends Model
{
    use Eloquence, Mappable;

    protected $table = 'Likes';

    protected $maps = [
        'likeData'       => 'like_data',      //数据集
    ];

}