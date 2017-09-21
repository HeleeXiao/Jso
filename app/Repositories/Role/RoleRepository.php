<?php

namespace App\Repositories\Role;


use App\Models\Base\Role;

/**
 * Interface RoleRepository
 * @package  App\Repositories\Role
 * @property string $id 
 * @property string $name 
 * @property string $nameZh 
 * @property string $nameJp 
 * @property string $description 
 * @property string $status 状态：0正常，1废弃
 * @property string $createdAt 
 * @property string $updatedAt 
 */

interface RoleRepository
{
    /**
     * @param int $id
     *
     * @return Role
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
     * @return Role
     */
    public function getCurrentInstance();

    public function init();

}