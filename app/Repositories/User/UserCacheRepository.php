<?php
namespace App\Repositories\User;

use App\Traits\RepositoryCacheTrait;

class UserCacheRepository extends UserDBRepository
{
    use RepositoryCacheTrait;

    protected $cacheMinutes = 60;

    protected $cachePrefix = 'users:';

    /**
     * @return bool
     */
    public function save()
    {
        if ($this->currentInstance && $this->currentInstance->userId) {
            \Cache::forget($this->getCacheKey($this->currentInstance->userId));
        }
        return parent::save();
    }

}