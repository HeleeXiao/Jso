<?php
namespace App\Repositories;


use App\Exceptions\BaseException;
use App\Models\CommonCode;
use App\Models\ErrorCode;
use App\Models\Ret;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected static $instances = [];

    protected $model;

    protected $currentBuilder;

    /**
     * @var Model
     */
    public $currentInstance;

    public function __construct()
    {
        $this->currentBuilder = $this->setCurrentBuilder();
    }

    /**
     * 设置当前查询实例
     *
     * @return Model
     */
    protected function setCurrentBuilder()
    {
        if (! isset(static::$instances[$this->model])) {
            static::$instances[$this->model] = $this->createModel();
        }
        return static::$instances[$this->model];
    }

    /**
     * 实例化指定模型
     *
     * @return Model
     *
     * @throws BaseException
     */
    public function createModel()
    {
        if (! class_exists('\\' . ltrim($this->model, '\\'))) {
            Ret::throwError(ErrorCode::REPO_MODEL_NOT_EXIST, $this->model . '类不存在', CommonCode::BASE_EXCEPTION);
        }

        $model = app()->make($this->model);
        if (! $model instanceof Model) {
            Ret::throwError(ErrorCode::REPO_INSTANCE_NOT_EXTEND_MODEL, $this->model . '未继承Model', CommonCode::BASE_EXCEPTION);
        }
        return $model;
    }

    public function getCurrentBuilder()
    {
        return $this->currentBuilder;
    }

    public function init()
    {
        $this->currentInstance = null;
    }
}