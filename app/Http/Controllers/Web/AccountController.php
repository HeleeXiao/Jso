<?php

namespace App\Http\Controllers\Web;

use App\Exceptions\Web\WebLogicException;
use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CommonCode;
use App\Models\ErrorCode;
use App\Models\Ret;
use App\Repositories\Attachment\AttachmentRepository;
use App\Repositories\User\UserRepository;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('web.auth');
    }

    public function profile(UserRepository $userRepo)
    {
        view()->share('flag', 0);
        $user = $userRepo->find(session(CommonCode::WEB_LOGIN_SESSION));
        return view('web.account.profile', compact('user'));
    }

    public function bindAccount()
    {
        view()->share('flag', 1);
        return view('web.account.account-bind');
    }

    /**
     * 账户设置-认证页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function authenticate()
    {
        view()->share('flag', 2);
        return view('web.account.authenticate');
    }

    /**
     * 认证图片上传、保存
     *
     * @param Request $request
     * @param AttachmentRepository $attach
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function postImage(Request $request, AttachmentRepository $attach)
    {
        $validator = \Validator::make($request->all(), [
            'file' => 'required|image|max:2048',
            'photo_type' => 'required|in:1,2'
        ]);

        if ($validator->fails()) {
            Ret::setError(ErrorCode::AJAX_PARAM_VALIDATE_FAILED);
            return Ret::output();
        }
        $fileType = '';
        $userId = session(CommonCode::WEB_LOGIN_SESSION);
        switch ($request->get('photo_type')) {
            case 1:
                $fileType = CommonCode::ENTERPRISE_LICENSE_THIRD_PART;
                break;
            case 2:
                $fileType = CommonCode::ENTERPRISE_LICENSE_COMMON;
                break;
            default:
                break;
        }

        $fileExtension = $request->file('file')->getClientOriginalExtension();
        $filename = $fileType . $userId .'.' . $fileExtension;
        \DB::beginTransaction();
        try {
            $attach->findByUidAndType($userId, $fileType);
            $attach->type = $fileType;
            $attach->name = $filename;
            $attach->userId = $userId;
            $attach->save();

            $result = \Storage::disk('job')->put(
                config('filesystems.catalogs.job') . '/' . $filename,
                file_get_contents($request->file('file')->getRealPath())
            );

            if (! $result) {
                \DB::rollBack();
                Ret::setError();
            } else {
                \DB::commit();
                Ret::setSuccess();
            }
            return Ret::output();
        } catch (\Exception $e) {
            \DB::rollBack();
            error_record($e, __METHOD__, __LINE__);
        }
    }

    /**
     * 修改密码页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showPasswordModifyForm()
    {
        view()->share('flag', 3);
        return view('web.user.password-modify');
    }

    /**
     * 修改登录密码
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function postModifyPassword(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|confirmed'
        ], [
            'old_password.required' => '请输入旧密码',
            'password.required' => '请输入新密码',
            'password.confirmed' => '两次密码不一致'
        ]);

        if ($validator->fails()) {
            Ret::setError(ErrorCode::AJAX_PARAM_VALIDATE_FAILED);
            return Ret::output();
        }

        try {
            (new AuthService())->modifyUserPassword(
                $request->get('old_password'),
                $request->get('password'),
                getUid()
            );
            return redirect()->route('web.account.profile');
        } catch (\Exception $e) {
            if (! $e instanceof WebLogicException) {
                error_record($e, __METHOD__, __LINE__);
            }
            if ($e->getCode() === ErrorCode::USER_PASSWORD_NOT_EQUAL) {
                return redirect()->back()->withErrors(['old_password' => '旧密码错误, 请重试']);
            }
        }
    }
}
