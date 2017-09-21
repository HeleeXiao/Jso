<?php

namespace App\Repositories\MobileDisabled;


use App\Models\Base\MobileDisabled;

/**
 * Interface MobileDisabledRepository
 * @package  App\Repositories\MobileDisabled
 * @property string $id 被禁用的手机
 * @property string $mobile 号码
 * @property string $createdAt 
 * @property string $updatedAt 
 */

interface MobileDisabledRepository
{
    /**
     * @param int $id
     *
     * @return MobileDisabled
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
     * @return MobileDisabled
     */
    public function getCurrentInstance();

    public function init();

}