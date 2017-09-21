<?php

namespace App\Repositories\Administrator;


use App\Models\Base\Administrator;

/**
 * Interface AdministratorRepository
 * @package  App\Repositories\Administrator
 * @property string $id 
 * @property string $name 
 * @property string $email 
 * @property string $password 
 * @property string $head 
 * @property string $status 状态：0正常，1废弃,2冻结
 * @property string $type 
 * @property string $rememberToken 
 * @property string $createdAt 
 * @property string $updatedAt 
 */

interface AdministratorRepository
{
    /**
     * @param int $id
     *
     * @return Administrator
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
     * @return Administrator
     */
    public function getCurrentInstance();

    public function init();

}