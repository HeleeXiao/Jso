<?php

namespace App\Http\Controllers\Web;

use App\Exceptions\Web\WebLogicException;
use App\Jobs\SendPasswordForgetMail;
use App\Models\Base\User;
use App\Models\CommonCode;
use App\Models\ErrorCode;
use App\Models\Web\Authorization;
use App\Repositories\User\UserRepository;
use App\Services\AuthService;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * 用户登录页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login()
    {
        return view('web.auth.login');
    }

    /**
     * 用户登录
     *
     * @param Request $request
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.*' => '请输入邮箱',
            'password.*' => '请输入密码'
        ]);

        try {
            (new AuthService())->login($request);
            return redirect()->route('web.account.profile');
        } catch (\Exception $e) {
            if ($e instanceof WebLogicException) {
                return redirect()->back()->withErrors('用户名或者密码错误');
            }
            error_record($e, __METHOD__, __LINE__);
        }
    }

    /**
     * 注销登录
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        (new AuthService())->logout();
        return redirect()->route('web.login');
    }

    /**
     * 用户注册页
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function register()
    {
        return view('web.auth.register');
    }

    /**
     * 注册用户
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postRegister(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users,nickname',
            'password' => 'required|confirmed',
            'protocol' => 'required|in:1'
        ], [
            'email.required' => '请输入邮箱',
            'email.email' => '请输入正确的邮箱格式',
            'email.unique' => '邮箱已被使用',
            'username.required' => '请输入用户名',
            'username.unique' => '用户名已被使用',
            'password.required' => '请输入密码',
            'password.confirmed' => '两次密码不一致',
            'protocol.*' => '请勾选服务协议和条约'
        ]);

        try {
            $newUser = (new AuthService())->register($request);
            Authorization::login($newUser);
            return redirect()->route('web.account.profile');
        } catch (\Exception $e) {
            if (! $e instanceof WebLogicException) {
                error_record($e, __METHOD__, __LINE__);
            }
            switch ($e->getCode()) {
                case ErrorCode::REGISTER_USERNAME_EXISTS:
                    $errors = ['username' => '用户名已被使用'];
                    break;
                case ErrorCode::REGISTER_EMAIL_EXISTS:
                    $errors = ['email' => '邮箱已被使用'];
                    break;
                default:
                    $errors = [];
                    break;
            }
            return redirect()->back()->withErrors($errors)
                ->withInput($request->only(['username', 'email']));
        }
    }

    /**
     * 忘记密码-填写邮箱页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showForgetForm()
    {
        $token = \Crypt::encrypt(['expired_at' => time() + 3600 * 24, 'action' => 'forget']);
        return view('web.auth.password-forget', compact('token'));
    }

    /**
     * 校验用户有效性并发送验证邮件
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetMail(Request $request)
    {
        //如果验证邮件已发送，还未过期，次数限制，时间限制？
        $this->validate($request, [
            'email' => 'required|email',
            'captcha' => 'required|captcha'
        ], [
            'email.required' => '请输入邮箱',
            'email.email' => '邮箱格式错误',
            'captcha.required' => '请输入验证码',
            'captcha.captcha' => '验证码错误'
        ]);

        $user = User::whereEmail($request->get('email'))->first();
        if (! $user) {
            return redirect()->back()->withErrors(['email' => '用户不存在']);
        }

        $encryptInfo = [
            'user_id' => $user->userId,
            'action' => CommonCode::SEND_RESET_MAIL_ACTION,
            'expired_at' => time() + 3600 * 24
        ];

        dispatch((new SendPasswordForgetMail([
            'email' => $request->get('email'),
            'title' => 'Reset password',
            'link' => route('web.password.reset.form', \Crypt::encrypt($encryptInfo))
        ])));

        return redirect()->route('web.password.reset.mail.tips', \Crypt::encrypt([
            'user_id' => $user->userId,
            'action' => CommonCode::RESET_MAIL_TIPS_ACTION,
            'expired_at' => time() + 3600 * 24
        ]));
    }

    /**
     * 密码重置邮件发送成功提示页面
     *
     * @param string $token
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetMailTips($token)
    {
        $expired_at = false;
        $user = null;
        try {
            $tokenInfo = \Crypt::decrypt($token);
            if ($tokenInfo['expired_at'] <= time()) {
                $expired_at = true;
            } else {
                $user = app(UserRepository::class)->find($tokenInfo['user_id']);
            }
        } catch (DecryptException $exception) {
            $expired_at = true;
        }

        return view('web.auth.reset-mail-send-tips', compact('expired_at', 'user'));
    }

    /**
     * 密码修改页面
     *
     * @param string $token
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm($token)
    {
        $expired_at = false;
        $user = null;
        try {
            $tokenInfo = \Crypt::decrypt($token);
            if ($tokenInfo['expired_at'] <= time()) {
                $expired_at = true;
            } else {
                $user = app(UserRepository::class)->find($tokenInfo['user_id']);
            }
        } catch (DecryptException $exception) {
            $expired_at = true;
        }

        if (! $user) {
            return redirect()->route('web.password.forget.form');
        }
        $resetToken = \Crypt::encrypt([
            'user_id' => $tokenInfo['user_id'],
            'time' => time()
        ]);
        return view('web.auth.password-reset', compact('user', 'expired_at', 'resetToken'));
    }

    /**
     * 设置用户密码
     *
     * @param Request $request
     * @param UserRepository $userRepo
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postResetPassword(Request $request, UserRepository $userRepo)
    {
        $this->validate($request, [
            'password' => 'required|confirmed',
            'reset_token' => 'required|string'
        ], [
            'password.required' => '请输入密码',
            'password.confirmed' => '两次密码不一致',
            'reset_token.*' => '参数错误'
        ]);

        $uid = null;
        try {
            $tokenInfo = \Crypt::decrypt($request->get('reset_token'));
            if (isset($tokenInfo['user_id'])) {
               $uid = $tokenInfo['user_id'];
            }
        } catch (DecryptException $e) {}

        if (! $uid) {
            return redirect()->back();
        }

        try {
            (new AuthService())->resetUserPassword($uid, $request->get('password'));
        } catch (\Exception $e) {
            if ($e->getCode() === ErrorCode::WEB_USER_NOT_EXIST) {
                return redirect()->back();
            }
            error_record($e, __METHOD__, __LINE__);
        }

        return redirect()->route('web.account.profile');
    }
}
