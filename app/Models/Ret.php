<?php
namespace App\Models;

use App\Exceptions\BaseException;
use App\Exceptions\Web\WebLogicException;
use App\Exceptions\Admin\AdminLogicException;
use Illuminate\Support\Facades\Response;

class Ret {
    private static $code;
    private static $message;
    private static $data;
    public static $setError;

    public static function init()
    {
        self::setError();
        self::$data = array();
        self::$setError = false;
    }

    public static function setError($code = 1, $msg='')
    {
        self::$code = $code;
        self::$message = $msg;
        self::$setError = true;
    }

    public static function getError()
    {
        return ['code'=>self::$code, 'msg'=>self::$message];
    }

    /**
     * 设置异常信息并抛出
     *
     * @param int $code
     * @param string $msg
     * @param int $type
     *
     * @throws WebLogicException|AdminLogicException|BaseException
     */
    public static function throwError($code = 1, $msg='', $type = CommonCode::WEB_LOGIC_EXCEPTION)
    {
        self::setError($code, $msg);
        switch ($type) {
            case CommonCode::ADMIN_LOGIC_EXCEPTION:
                throw new AdminLogicException($msg, $code);
                break;
            case CommonCode::BASE_EXCEPTION:
                throw new BaseException($msg, $code);
                break;
            case CommonCode::WEB_LOGIC_EXCEPTION:
            default:
                throw new WebLogicException($msg, $code);
                break;
        }
    }

    public static function setSuccess($code = 0, $msg='')
    {
        self::$code = $code;
        self::$message = $msg;
    }

    public static function setSuccessGo($code = 0, $msg='')
    {
        self::$code = $code;
        self::$message = $msg;
        self::$data = json_encode(self::$data);
    }

    public static function getData($key = '')
    {
        if(! empty($key)) {
            if(array_key_exists($key, self::$data)) {
                return self::$data[$key];
            } else {
                return null;
            }
        } else {
            return self::$data;
        }
    }

    public static function setData($key = '', $data)
    {
        if(! empty($key)) {
            self::$data[$key] = $data;
        } else {
            self::$data = $data;
        }
    }

    public static function getCode()
    {
        return self::$code;
    }

    /**
     * 返回 json 格式数据
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function output()
    {
        return Response::json([
            'status' => self::$code,
            'result' => ! self::$data ? null: self::$data,
            //'message' => self::$message ? "OK" : "",
            'ts' => time(),
        ]);
    }
}