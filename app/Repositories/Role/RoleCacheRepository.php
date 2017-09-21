<?php
namespace App\Repositories\Role;

use App\Traits\RepositoryCacheTrait;

class RoleCacheRepository extends RoleDBRepository
{
    use RepositoryCacheTrait;

    protected $cacheMinutes = 60;

    protected $cachePrefix = 'roles:';

}