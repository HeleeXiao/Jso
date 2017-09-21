<?php
namespace App\Repositories\Administrator;

use App\Traits\RepositoryCacheTrait;

class AdministratorCacheRepository extends AdministratorDBRepository
{
    use RepositoryCacheTrait;

    protected $cacheMinutes = 60;

    protected $cachePrefix = 'administrators:';

}