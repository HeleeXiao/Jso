<?php
namespace App\Repositories\Attachment;

use App\Traits\RepositoryCacheTrait;

class AttachmentCacheRepository extends AttachmentDBRepository
{
    use RepositoryCacheTrait;

    protected $cacheMinutes = 60;

    protected $cachePrefix = 'attachment:';

    public function findByUidAndType($uid, $type)
    {
        $cacheKey = $this->getCacheKey($type . $uid);
        if (\Cache::has($cacheKey)) {
            $this->currentInstance = \Cache::get($cacheKey);
            return $this->currentInstance;
        }

        $currentInstance = parent::findByUidAndType($uid, $type);
        if ($currentInstance) {
            \Cache::put($cacheKey, $currentInstance, $this->cacheMinutes);
        }

        return $currentInstance;
    }
}