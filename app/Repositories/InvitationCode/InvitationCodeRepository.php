<?php

namespace App\Repositories\InvitationCode;


use App\Models\Base\InvitationCode;

/**
 * Interface InvitationCodeRepository
 * @package  App\Repositories\InvitationCode
 * @property string $id 邀请码表
 * @property string $code 邀请码
 * @property string $userId 用户id
 * @property string $status 状态 0 正常 1:标记已经使用
 * @property string $createdAt 
 * @property string $updatedAt 
 */

interface InvitationCodeRepository
{
    /**
     * @param int $id
     *
     * @return InvitationCode
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
     * @return InvitationCode
     */
    public function getCurrentInstance();

    public function init();

}