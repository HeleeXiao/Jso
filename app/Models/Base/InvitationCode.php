<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

/**
 * @Class InvitationCode
 * @package App\Models\Base
 * @User: ???@jtrips.com
 * @property string $id 邀请码表
 * @property string $code 邀请码
 * @property string $userId 用户id
 * @property string $status 状态 0 正常 1:标记已经使用
 * @property string $createdAt 
 * @property string $updatedAt 
 *
 */

class InvitationCode extends Model
{
    use Eloquence, Mappable;

    protected $table = 'invitation_code';

    protected $maps = [
        'userId'         => 'user_id',        //用户id
    ];

}