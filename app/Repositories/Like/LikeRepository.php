<?php

namespace App\Repositories\Like;


use App\Models\Base\Like;

/**
 * Interface LikeRepository
 * @package  App\Repositories\Like
 * @property string $id 关注的，喜欢的
 * @property string $likeData 数据集
 * @property string $createdAt 
 * @property string $updatedAt 
 */

interface LikeRepository
{
    /**
     * @param int $id
     *
     * @return Like
     */
    public function find($id);

    /**
     *
     * @return bool
     */
    public function save();

    /**
     * @return $this
     */
    public function write();

    /**
     * @return Like
     */
    public function getCurrentInstance();

    public function init();

}