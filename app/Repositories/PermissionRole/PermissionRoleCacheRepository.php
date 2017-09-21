<?php
namespace App\Repositories\PermissionRole;

use App\Traits\RepositoryCacheTrait;

class PermissionRoleCacheRepository extends PermissionRoleDBRepository
{
    use RepositoryCacheTrait;

    protected $cacheMinutes = 60;

    protected $cachePrefix = 'permission_role:';

}