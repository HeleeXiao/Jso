<?php
namespace App\Services;


use Illuminate\Support\Facades\Log;
use Monolog\Handler\StreamHandler;

class LogService
{
    protected $logger;

    public function __construct()
    {
        $this->logger = Log::getMonolog();
    }

    public function debug($message, array $context = [])
    {
        $this->setHandler(__FUNCTION__);
        Log::debug($message, $context);
    }

    public function info($message, array $context = [])
    {
        $this->setHandler(__FUNCTION__);
        Log::info($message, $context);
    }

    public function notice($message, array $context = [])
    {
        $this->setHandler(__FUNCTION__);
        Log::notice($message, $context);
    }

    public function warning($message, array $context = [])
    {
        $this->setHandler(__FUNCTION__);
        Log::warning($message, $context);
    }

    public function error($message, array $context = [])
    {
        $this->setHandler(__FUNCTION__);
        Log::error($message, $context);
    }

    public function critical($message, array $context = [])
    {
        $this->setHandler(__FUNCTION__);
        Log::critical($message, $context);
    }

    public function alert($message, array $context = [])
    {
        $this->setHandler(__FUNCTION__);
        Log::alert($message, $context);
    }

    public function emergency($message, array $context = [])
    {
        $this->setHandler(__FUNCTION__);
        Log::emergency($message, $context);
    }

    public function record($message, array $context = [], $type = 'error')
    {
        $this->$type($message, $context);
    }

    protected function setHandler($level)
    {
        $path =  rtrim(config('app.log_storage_path', storage_path() . '/logs'), '/') . DIRECTORY_SEPARATOR
            . $level . DIRECTORY_SEPARATOR . date('Y-m-d') . '.log';

        $this->logger->setHandlers([
            new StreamHandler($path)
        ]);
    }
}