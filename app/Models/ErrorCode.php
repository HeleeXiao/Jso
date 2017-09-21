<?php
namespace App\Models;

/**
 * Class ErrorCode 错误代码常量类
 * @package App\Models
 * User: wsm@jtrips.com
 *
 */
class ErrorCode
{
    const AJAX_PARAM_VALIDATE_FAILED = 9900;//AJAX 请求参数不合法

    //Repository
    const REPO_MODEL_NOT_EXIST = 9000; //模型类不存在
    const REPO_INSTANCE_NOT_EXTEND_MODEL = 9001; //指定模型未继承 Model

    //SDK
    const AUTO_MAIL_WRONG_CONTENT_FORMAT = 8000; //auto-mail 邮件内容格式错误
    const AUTO_MAIL_SEND_FAILED = 8001; //auto-mail 邮件发送失败
    const MAIL_WRONG_RECEIVER_FORMAT = 8002; //邮件接收者格式解析错误

    //Login Register Password
    const WEB_USER_NOT_EXIST = 1001; //用户不存在
    const WEB_LOGIN_PASSWORD_WRONG = 1002; //用户密码错误
    const REGISTER_USERNAME_EXISTS = 1003; //用户名已被使用
    const REGISTER_EMAIL_EXISTS = 1004; //邮箱已被使用
    const USER_MOBILE_PHONE_EXISTS = 1005; //手机号已被使用

    const USER_PASSWORD_NOT_EQUAL = 1006; //密码错误


    //GLQ维护，企业发帖信息验证，需求确定后，会再次更新具体内容，当前信息仅供演示使用,为了避免编号紧缺，我个人启用20000以上编号，如有不妥请及时告知我修改
    const COMPANY_NAME_REQUIRED = 20000; //公司名称不能为空
    const COMPANY_NAME_MIN = 20001; //公司名称不能少于6个汉字
    const COMPANY_NAME_MAX = 20002; //公司名称不能多于255个汉字
    const JOB_NAME_REQUIRED = 20003; //职位不能为空
    const JOB_NAME_MIN = 20004; //职位不能少于6个汉字
    const JOB_NAME_MAX = 20005; //职位不能多于255个汉字
    const NUM_REQUIRED = 20006; //招聘人数不能为空
    const NUM_MIN = 20007; //请正确填写招聘人数
    const NUM_MAX = 20008; //请正确填写招聘人数
    const NUM_NUMERIC = 20009; //请正确填写招聘人数
    const DESCRIPTION_REQUIRED = 20010; //工作内容不能为空
    const DESCRIPTION_MIN = 20011; //工作内容不能少于6个汉字
    const DESCRIPTION_MAX = 20012; //工作内容不能多于255个汉字
    const CONTACTS_REQUIRED = 20013; //联系人不能为空
    const CONTACTS_MIN = 20014; //联系人不能少于6个汉字
    const CONTACTS_MAX = 20015; //联系人不能多于255个汉字
    const TEL_REQUIRED = 20016; //联系电话不能为空
    const TEL_MIN = 20017; //联系电话不能少于8个汉字
    const TEL_MAX = 20018; //联系电话不能多于13个汉字
    const TEL_NUMERIC = 20019; //请正确填写电话号码
    const EMAIL_REQUIRED = 20020; //邮箱不能为空
    const EMAIL_MIN = 20021; //邮箱不能少于6个汉字
    const EMAIL_MAX = 20022; //邮箱不能多于255个汉字
    const EMAIL_EMAIL = 20023; //邮箱格式不正确
    const ADDRESS_REQUIRED = 20024; //联系地址不能为空
    const ADDRESS_MIN = 20025; //联系地址不能少于6个汉字
    const ADDRESS_MAX = 20026; //联系地址不能多于255个汉字



}