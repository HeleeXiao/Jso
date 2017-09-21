<?php

namespace App\Repositories\City;


use App\Models\Base\City;

/**
 * Interface CityRepository
 * @package  App\Repositories\City
 * @property string $id 城市
 * @property string $cityId 城市id
 * @property string $province 省份
 * @property string $name 名称
 * @property string $englishName 英文名称
 * @property string $attr 额外参数
 * @property string $orderId 额外参数
 * @property string $createdAt 
 * @property string $updatedAt 
 */

interface CityRepository
{
    /**
     * @param int $id
     *
     * @return City
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
     * @return City
     */
    public function getCurrentInstance();

    public function init();

}