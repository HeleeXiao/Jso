<?php

namespace App\Repositories\User;


use App\Models\Base\User;

/**
 * Interface UserRepository
 * @package  App\Repositories\User
 * @property string $userId 用户ID
 * @property string $nickname 昵称
 * @property string $email E-mail
 * @property string $password 密码
 * @property string $description 描述
 * @property string $attr 额外参数
 * @property string $registerIp 注册Ip
 * @property string $mobile 
 * @property string $type 玩家类型:0 普通用户 1游戏转入的推广员 2 专业推广员
 * @property string $rememberToken 
 * @property string $createdAt 
 * @property string $updatedAt 
 */

interface UserRepository
{
    /**
     * @param int $id
     *
     * @return User|null
     */
    public function find($id);

    /**
     * @param int $id
     *
     * @return User
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail($id);

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
     * @return User
     */
    public function getCurrentInstance();

    public function init();

}