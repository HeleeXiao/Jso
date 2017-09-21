<?php

namespace App\Models\Base;

use Zizaco\Entrust\EntrustPermission;

/**
 * @Class Permissions
 * @package App\Models\Base
 * @User: ???@jtrips.com
 * @property string $id 
 * @property string $pid 父级：0无
 * @property string $name 
 * @property string $nameZh 
 * @property string $nameJp 
 * @property string $displayName 
 * @property string $description 
 * @property string $status 状态：0正常，1废弃
 * @property string $type 状态：0菜单，1功能
 * @property string $createdAt 
 * @property string $updatedAt 
 *
 */

class Permission extends EntrustPermission
{

    public $fillable = ['pid','name_zh','name','name_jp','display_name','type'];
    protected $maps = [
        'nameZh'         => 'name_zh',        //
        'nameJp'         => 'name_jp',        //
        'displayName'    => 'display_name',   //
    ];
    /** 获取父级权限
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parent()
    {
        return $this->belongsTo($this,'pid','id');
    }

    /**获取所属组
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function role()
    {
        return $this->belongsToMany(Role::class,'permission_role');
    }

    /** 获取子级权限
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany($this,'pid','id');
    }

}