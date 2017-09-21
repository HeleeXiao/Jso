<?php
namespace App\Models;

/**
 * Class CommonCode 公共常量类
 * @package App\Models
 * User: wsm@jtrips.com
 *
 */
class CommonCode
{
    const WEB_LOGIC_EXCEPTION = 10001;
    const ADMIN_LOGIC_EXCEPTION = 10002;
    const BASE_EXCEPTION = 10003;

    const WEB_LOGIN_SESSION = '__u';
    const SEND_RESET_MAIL_ACTION = 'reset-mail';
    const RESET_MAIL_TIPS_ACTION = 'send-success';

    const ENTERPRISE_LICENSE_THIRD_PART = '11000';
    const ENTERPRISE_LICENSE_COMMON = '11001';
}