<?php
namespace App\Repositories\MobileDisabled;

use App\Traits\RepositoryCacheTrait;

class MobileDisabledCacheRepository extends MobileDisabledDBRepository
{
    use RepositoryCacheTrait;

    protected $cacheMinutes = 60;

    protected $cachePrefix = 'mobile_disabled:';

}