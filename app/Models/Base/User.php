<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;
use Sofa\Eloquence\Mutable;

/**
 * @Class User
 * @package App\Models\Base
 * @User: xc@jtrips.com
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
 *
 */

class User extends Model
{
    use Eloquence, Mappable, Mutable;

    protected $table = 'users';

    protected $primaryKey = 'user_id';

    protected $setterMutators = ['password' => 'bcrypt'];

    protected $maps = [
        'userId'         => 'user_id',        //用户ID
        'registerIp'     => 'register_ip',    //注册Ip
        'rememberToken'  => 'remember_token', //
    ];

    /**
     * 邮箱查询
     *
     * @param static $query
     * @param string $email
     *
     * @return mixed
     */
    public function scopeWhereEmail($query, $email)
    {
        return $query->where('email', $email);
    }

}