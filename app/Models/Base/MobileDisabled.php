<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

/**
 * @Class MobileDisabled
 * @package App\Models\Base
 * @User: ???@jtrips.com
 * @property string $id 被禁用的手机
 * @property string $mobile 号码
 * @property string $createdAt 
 * @property string $updatedAt 
 *
 */

class MobileDisabled extends Model
{
    use Eloquence, Mappable;

    protected $table = 'mobile_disabled';

    protected $maps = [
    ];

}