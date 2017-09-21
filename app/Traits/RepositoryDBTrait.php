<?php
namespace App\Traits;


trait RepositoryDBTrait
{
    /**
     * 根据主键 ID 查询单条记录，不存在则抛出异常
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function find($id)
    {
        //由于前后台同时使用 Repository 模式，
        //需要控制器捕获 ModelNotFundException 单独做 404 Not Found 功能
        $instance = $this->currentBuilder->find($id);
        $this->currentInstance = $instance;
        return $instance;
    }

    /**
     * 根据主键 ID 查询单条记录，不存在则抛出异常
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail($id)
    {
        //由于前后台同时使用 Repository 模式，
        //需要控制器捕获 ModelNotFundException 单独做 404 Not Found 功能
        $instance = $this->currentBuilder->findOrFail($id);
        $this->currentInstance = $instance;
        return $instance;
    }

    /**
     * 保存单条记录
     *
     * @return bool
     */
    public function save()
    {
        if ($this->currentInstance && $this->currentInstance->isDirty()) {
            return $this->currentInstance->save();
        }

        return false;
    }

    /**
     * 获取当前实例
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getCurrentInstance()
    {
        return $this->currentInstance ? $this->currentInstance: null;
    }

    /**
     * 指定当前连接至写库
     *
     * @return $this
     */
    public function write()
    {
        $this->currentBuilder->useWritePdo();
        return $this;
    }


    /**
     * Dynamically set attributes on the model.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function __set($key, $value)
    {
        if (! $this->currentInstance) {
            $this->currentInstance = clone $this->currentBuilder;
        }

        $this->currentInstance->setAttribute($key, $value);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function __get($key)
    {
        if (! $this->currentInstance && property_exists(self::class, $key)) {
            return $this->$key;
        }

        return $this->currentInstance->getAttribute($key);
    }
}