<?php
namespace App\Repositories\Ad;

use App\Traits\RepositoryCacheTrait;

class AdCacheRepository extends AdDBRepository
{
    use RepositoryCacheTrait;

    protected $cacheMinutes = 60;

    protected $cachePrefix = 'ad:';

}