<?php
namespace App\Repositories\Category;

use App\Traits\RepositoryCacheTrait;

class CategoryCacheRepository extends CategoryDBRepository
{
    use RepositoryCacheTrait;

    protected $cacheMinutes = 60;

    protected $cachePrefix = 'category:';

}