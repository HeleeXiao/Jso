<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

/**
 * @Class PermissionRole
 * @package App\Models\Base
 * @User: ???@jtrips.com
 * @property string $permissionId 
 * @property string $roleId 
 *
 */

class PermissionRole extends Model
{

    protected $table = 'permission_role';

    protected $maps = [
        'permissionId'   => 'permission_id',  //
        'roleId'         => 'role_id',        //
    ];

}