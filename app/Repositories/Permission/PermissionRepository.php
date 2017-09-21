<?php

namespace App\Repositories\Permission;


use App\Models\Base\Permission;

/**
 * Interface PermissionRepository
 * @package  App\Repositories\Permission
 * @property string $id 
 * @property string $pid 父级：0无
 * @property string $name 
 * @property string $nameZh 
 * @property string $nameJp 
 * @property string $displayName 
 * @property string $description 
 * @property string $status 状态：0正常，1废弃
 * @property string $type 状态：0菜单，1功能
 * @property string $createdAt 
 * @property string $updatedAt 
 */

interface PermissionRepository
{
    /**
     * @param int $id
     *
     * @return Permission
     */
    public function find($id);

    /**
     * @param $ids
     * @return mixed
     * @auther <Helee>
     */
    public function findByIds($ids);
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
     * @return Permission
     */
    public function getCurrentInstance();

    public function init();

}