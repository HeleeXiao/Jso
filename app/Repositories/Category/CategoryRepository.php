<?php

namespace App\Repositories\Category;


use App\Models\Base\Category;

/**
 * Interface CategoryRepository
 * @package  App\Repositories\Category
 * @property string $id 分类表
 * @property string $name 名称
 * @property string $englishName 英文名称
 * @property string $parentEnglishName 父级分类名称
 * @property string $level 分类层级
 * @property string $meta 省份
 * @property string $attr 额外参数
 * @property string $orderId 额外参数
 * @property string $createdAt 
 * @property string $updatedAt 
 */

interface CategoryRepository
{
    /**
     * @param int $id
     *
     * @return Category
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
     * @return Category
     */
    public function getCurrentInstance();

    public function init();

}