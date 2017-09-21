<?php

namespace App\Models\SDK;


use App\Models\ErrorCode;
use App\Models\Ret;
use GuzzleHttp\Client;

class AutoMailSdk
{
    protected $mailServer;

    protected $connection;

    public function __construct()
    {
        $this->mailServer = config('auto-mail.default');
        $this->connection = config('auto-mail.connections.' . $this->mailServer);
    }

    /**
     * Send mail to a receiver.
     *
     * @param string $view
     * @param array|string $receiver
     * @param string $title
     * @param array $params
     * @param array $sender
     *
     * @return bool
     * @throws \Exception
     */
    public function send($view, $receiver, $title ,array $params, array $sender = [])
    {
        try {
            $requestParams['subject'] = $title;
            $requestParams['body'] = $this->getView($view, $params);
            $requestParams['to'] = $this->getReceiver($receiver);
            $xml = $this->getXmlContent($requestParams, $sender);
            return $this->request($xml);
        } catch (\Exception $e) {
            error_record($e, __METHOD__, __LINE__);
        }
    }

    /**
     * 设置邮件接收者（可群发）
     *
     * @param $receiver
     *
     * @return array
     */
    protected function getReceiver($receiver)
    {
        $receivers = [];
        if (is_array($receiver)) {
            foreach ($receiver as $item) {
                if (! is_string($item)) {
                    continue;
                }
                $receivers[] = $item;
            }
        }

        if (is_string($receiver)) {
            $receivers[] = $receiver;
        }

        if (empty($receivers)) {
            Ret::throwError(ErrorCode::MAIL_WRONG_RECEIVER_FORMAT);
        }

        return $receivers;
    }

    protected function getView($view, array $params)
    {
        return response()->view($view, $params)->content();
    }

    /**
     * Send http request to auto mail server.
     *
     * @param string $xml
     *
     * @return bool
     */
    protected function request($xml)
    {
        $client = new Client();
        $address = $this->connection['host'];
        $response = $client->request('post', $address, [
            'verify' => false,
            'header' => [
                'Content-Type' => 'application/octet-stream'
            ],
            'body' => $xml
        ]);

        $message = simplexml_load_string($response->getBody(), 'SimpleXMLElement', LIBXML_NOCDATA);
        $messageInfo = json_decode(json_encode($message), true);

        /*
         * messageInfo = [
         *  "delivery" => [
         *      "@attributes" => [
         *          "id" => "1"
         *       ],
         *       "deliver_id" => "23Zs",
         *       "request_id" => "20170703173717725522",
         *       "exec_cnt" => "1",
         *       "result" => "処理が正常に終了しました"
         *    ]
         * ]
         *
         *  [
         *       "result" => "エラーが発生しました",
         *       "errors" => [
         *           "error" => "ログインＩＤもしくはパスワードが不正です : UserAuthentication(411)"
         *       ]
         *   ]
         */
        if (isset($messageInfo['delivery']['errors'])) {
            Ret::throwError(ErrorCode::AUTO_MAIL_WRONG_CONTENT_FORMAT, '发信邮件内容格式有误，发送失败');
        }

        if (isset($messageInfo['errors'])) {
            Ret::throwError(ErrorCode::AUTO_MAIL_SEND_FAILED, 'Auto-mail 向用户发送邮件失败');
        }
        return true;
    }

    /**
     * Assemble xml content.
     *
     * @param array $info
     * @param array $sender
     *
     * @return string
     */
    protected function getXmlContent(array $info, array $sender = [])
    {
        if(empty($sender)) {
            $sender = config('auto-mail.sender');
        }

        $request_id = date('YmdHis') . mt_rand(100000, 999999);
        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
                    <mail>
                        <auth>
                            <site id=\"" . $this->connection['site_id'] . "\" />
                            <service id=\"" . $this->connection['service_id'] . "\" />
                            <name>" . $this->connection['name'] . "</name>
                            <pass>" . $this->connection['password']. "</pass>
                        </auth>
                        <delivery id=\"1\">
                            <action>reserve</action>
                            <request_id>" . $request_id . "</request_id>
                            <setting>
                                <send_date>now</send_date>
                                <from_name>" . $sender['name'] . "</from_name>
                                <from>" . $sender['email'] . "</from>
                                <option>
                                    <stop_time>2200</stop_time>
                                    <start_time>0800</start_time>
                                    <lifetime>89400</lifetime>
                                    <retry_int>1800</retry_int>
                                </option>
                                <throttle>1000</throttle>
                                <s_mime use=\"0\"></s_mime>
                            </setting>
                            <contents>
                                <subject><![CDATA[" . $info['subject'] . "]]></subject>
                                <body part=\"html\"><![CDATA[<html><body>" . $info['body'] . "</body></html>]]></body>
                            </contents>
                            <send_list>
                                <data id=\"1\">";
        foreach($info['to'] as $value)
        {
            $xml = $xml . "<address device=\"1\">" . $value . "</address>";
        }
        $xml = $xml . "</data>
                            </send_list>   
                        </delivery>
                    </mail>";
        return $xml;
    }
}