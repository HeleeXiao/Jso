<?php
namespace App\Repositories\Like;

use App\Traits\RepositoryCacheTrait;

class LikeCacheRepository extends LikeDBRepository
{
    use RepositoryCacheTrait;

    protected $cacheMinutes = 60;

    protected $cachePrefix = 'Likes:';

}