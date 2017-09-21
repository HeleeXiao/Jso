<?php

if (! function_exists('error_record')) {

    /**
     * 异常记录
     *
     * @param Exception $e
     * @param string $method
     * @param string $line
     * @param string $level
     *
     * @throws Exception
     */
    function error_record(\Exception $e, $method, $line, $level = 'error')
    {
        \App\Facades\Logger::record(
            $e->getMessage(),
            ['method' => $method, 'line' => $line],
            $level
        );
        throw $e;
    }
}

if (! function_exists('check_unique_of_key')) {

    /**
     * 检查指定字段值是否唯一
     *
     * @param Exception $e
     * @param string $key
     * @return bool
     */
    function check_unique_of_key(\Exception $e, $key)
    {
        if (! $e instanceof \Illuminate\Database\QueryException) {
            return false;
        }

        $errorInfo = $e->errorInfo;
        $errorCode = $errorInfo[1];
        if ($errorCode != 1062) {
            return false;
        }

        if (\Illuminate\Support\Str::contains($e->getMessage(), $key)) {
            return true;
        }

        return false;
    }
}

if (! function_exists('getUid')) {


    function getUid()
    {
        return \Session::get(\App\Models\CommonCode::WEB_LOGIN_SESSION);
    }
}
