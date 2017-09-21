<?php
namespace App\Repositories\Permission;

use App\Traits\RepositoryCacheTrait;

class PermissionCacheRepository extends PermissionDBRepository
{
    use RepositoryCacheTrait;

    protected $cacheMinutes = 60;

    protected $cachePrefix = 'permissions:';

}