<?php
namespace App\Services;

use App\Exceptions\Web\WebLogicException;
use App\Models\Base\User;
use App\Models\ErrorCode;
use App\Models\Ret;
use App\Models\Web\Authorization;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;

class AuthService
{
    public function __construct()
    {

    }

    /**
     * 用户登录
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request)
    {
        $uid = User::whereEmail($request->get('email'))->value('user_id');
        if (! $uid) {
            Ret::throwError(ErrorCode::WEB_USER_NOT_EXIST, '用户名或密码错误');
        }
        $user = app(UserRepository::class)->find($uid);

        if (! \Hash::check($request->get('password'), $user->password)) {
            Ret::throwError(ErrorCode::WEB_LOGIN_PASSWORD_WRONG, '用户名或密码错误');
        }
        Authorization::login($user);
    }

    /**
     * 用户登出
     *
     * @return void
     */
    public function logout()
    {
        Authorization::logout();
    }

    /**
     * 用户注册
     *
     * @param Request $request
     * @return User
     * @throws \Exception
     */
    public function register(Request $request)
    {
        try {
            return Authorization::register($request->only(['email', 'username', 'password']));
        } catch (\Exception $e) {
            if (check_unique_of_key($e, 'users_nickname_unique')) {
                Ret::throwError(ErrorCode::REGISTER_USERNAME_EXISTS, '用户名已被使用');
            }

            if (check_unique_of_key($e, 'users_nickname_unique')) {
                Ret::throwError(ErrorCode::REGISTER_EMAIL_EXISTS, '邮箱已被使用');
            }

            error_record($e, __METHOD__, __LINE__);
        }
    }

    /**
     * 修改用户密码
     *
     * @param string $original
     * @param string $password
     * @param integer $uid
     * @return void
     * @throws WebLogicException
     */
    public function modifyUserPassword($original, $password, $uid)
    {
        $userRepo = app(UserRepository::class);
        $user = $userRepo->find($uid);
        if (! \Hash::check($original, $user->password)) {
            Ret::throwError(ErrorCode::USER_PASSWORD_NOT_EQUAL, '密码错误');
        }
        $userRepo->password = $password;
        $userRepo->save();
    }

    /**
     * 重置用户密码
     *
     * @param $uid
     * @param $password
     * @return void
     * @throws WebLogicException
     */
    public function resetUserPassword($uid, $password)
    {
        $userRepo = app(UserRepository::class);
        $userInstance = $userRepo->find($uid);
        if (! $userInstance) {
            Ret::throwError(ErrorCode::WEB_USER_NOT_EXIST, '用户不存在');
        }
        $userRepo->password = $password;
        $userRepo->save();
        Authorization::login($userRepo->getCurrentInstance());
    }
}