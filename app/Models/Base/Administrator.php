<?php

namespace App\Models\Base;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

/**
 * @Class Administrators
 * @package App\Models\Base
 * @User: ???@jtrips.com
 * @property string $id 
 * @property string $name 
 * @property string $email 
 * @property string $password 
 * @property string $head 
 * @property string $status 状态：0正常，1废弃,2冻结
 * @property string $type 
 * @property string $rememberToken 
 * @property string $createdAt 
 * @property string $updatedAt 
 *
 */

class Administrator extends Authenticatable
{
    use Eloquence, Mappable;

    protected $table = 'administrators';

    protected $fillable = ['name','email','password'];

    protected $maps = [
        'rememberToken'  => 'remember_token', //
    ];

}