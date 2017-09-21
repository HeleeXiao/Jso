<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;
use Zizaco\Entrust\EntrustRole;

/**
 * @Class Roles
 * @package App\Models\Base
 * @User: ???@jtrips.com
 * @property string $id 
 * @property string $name 
 * @property string $nameZh 
 * @property string $nameJp 
 * @property string $description 
 * @property string $status 状态：0正常，1废弃
 * @property string $createdAt 
 * @property string $updatedAt 
 *
 */

class Role extends EntrustRole
{

    protected $table = 'roles';
    protected $fillable = [ 'name','name_zh','name_jp','description','status'];
    protected $maps = [
        'nameZh'         => 'name_zh',        //
        'nameJp'         => 'name_jp',        //
    ];

}