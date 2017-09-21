<?php
namespace App\Models;

use App\Models\Base\User;
use App\Repositories\User\UserRepository;

class Visitor
{
    private static $user;

    public static function user($user = null)
    {
        if ($user instanceof User) return self::$user = $user;

        if (self::$user) {
            return self::$user;
        }
        $userId = session()->get(CommonCode::WEB_LOGIN_SESSION);
        if (! $userId) return null;

        try {
            $repository = app()->make(UserRepository::class);
            $user = $repository->find($userId);
        } catch (\Exception $e) {
            return null;
        }

        return self::$user = $user;
    }

    public static function logout()
    {
        self::$user = null;
    }
}