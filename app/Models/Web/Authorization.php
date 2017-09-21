<?php
namespace App\Models\Web;

use App\Models\Base\User;
use App\Models\CommonCode;
use App\Models\Visitor;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Session;

class Authorization
{
    /**
     * 保存用户登入信息
     *
     * @param User $user
     * @return void
     */
    public static function login(User $user)
    {
        Session::put(CommonCode::WEB_LOGIN_SESSION, $user->userId);
        Visitor::user($user);
    }

    /**
     * 清除用户登录信息
     *
     * @return void
     */
    public static function logout()
    {
        Session::forget(CommonCode::WEB_LOGIN_SESSION);
        Visitor::logout();
    }

    /**
     * 新建注册用户
     *
     * @param array $credentials
     *
     * @return User
     */
    public static function register(array $credentials)
    {
        $userRepo = app(UserRepository::class);
        $userRepo->email = $credentials['email'];
        $userRepo->nickname = $credentials['username'];
        $userRepo->password = $credentials['password'];
        $userRepo->save();
        return $userRepo->getCurrentInstance();
    }

    protected function check()
    {
        
    }
}