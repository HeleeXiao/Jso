<?php

namespace App\Services;
use App\Models\Base\Permission;
use App\Repositories\Permission\PermissionRepository;

class PermissionService
{
    /**
     * @return array
     * @other <Helee>
     */
    public static function getMenu(){
        $permissionsIds = Permission::where('status',0)->where('type',0)->select(['id'])->get();
        $permissionsRepository = app()->make(PermissionRepository::class);
        $permissions = $permissionsRepository->findByIds($permissionsIds->pluck('id')->toArray());
        $parentPermission = [];
        $childPermission = [];
        foreach ($permissions as $permission) {
            if(!$permission->pid) {
                array_push($parentPermission,$permission->toArray());
            }else{
                array_push($childPermission,$permission->toArray());
            }
        }
        foreach ($parentPermission as $key => $parent) {
            $parentPermission[$key]['children'] = [];
            foreach ($childPermission as $permission) {
                if($permission['pid'] == $parent['id'])
                {
                    $parentPermission[$key]['children'][] = $permission;
                }
            }

        }
        return $parentPermission;
    }
}