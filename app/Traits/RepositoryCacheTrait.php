<?php
namespace App\Traits;


use Illuminate\Support\Facades\Cache;

trait RepositoryCacheTrait
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    public function find($id)
    {
        $cacheKey = $this->getCacheKey($id);
        if (Cache::has($cacheKey)) {
            $this->currentInstance = Cache::get($cacheKey);
            return $this->currentInstance;
        }

        $currentInstance = parent::find($id);
        if ($currentInstance) {
            Cache::put($cacheKey, $currentInstance, $this->cacheMinutes);
        }

        return $currentInstance;
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    public function findOrFail($id)
    {
        $cacheKey = $this->getCacheKey($id);
        if (Cache::has($cacheKey)) {
            $this->currentInstance = Cache::get($cacheKey);
            return $this->currentInstance;
        }

        $currentInstance = parent::findOrFail($id);
        if ($currentInstance) {
            Cache::put($cacheKey, $currentInstance, $this->cacheMinutes);
        }

        return $currentInstance;
    }


    /**
     * @return bool
     */
    public function save()
    {
        if ($this->currentInstance && $this->currentInstance->id) {
            Cache::forget($this->getCacheKey($this->currentInstance->id));
        }
        return parent::save();
    }

    /**
     * 获取缓存键值
     *
     * @param integer $id
     *
     * @return string
     */
    public function getCacheKey($id)
    {
        return $this->cachePrefix . $id;
    }
}