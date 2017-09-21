<?php

namespace App\Repositories\PermissionRole;


use App\Models\Base\PermissionRole;

/**
 * Interface PermissionRoleRepository
 * @package  App\Repositories\PermissionRole
 * @property string $permissionId 
 * @property string $roleId 
 */

interface PermissionRoleRepository
{
    /**
     * @param int $id
     *
     * @return PermissionRole
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
     * @return PermissionRole
     */
    public function getCurrentInstance();

    public function init();

}