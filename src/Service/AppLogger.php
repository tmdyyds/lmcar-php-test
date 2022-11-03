<?php

namespace App\Service;

use think\facade\Log;

class AppLogger
{
    const LOG_LEVEL_ERROR = 1;
    const LOG_LEVEL_INFO  = 9;
    const LOG_LEVEL_DEBUG = 10;

    const TYPE_LOG4PHP  = 'log4php';
    const TYPE_THINKLOG = 'think-log';

    private static $logger = [];
    private $type;

    public function __construct($type = self::TYPE_LOG4PHP)
    {
        $this->instantLogFactory($type);
        $this->initType($type);
    }

    public function info($message = '')
    {
        $this->writeLog(self::LOG_LEVEL_INFO, $message);
    }

    public function debug($message = '')
    {
        $this->writeLog(self::LOG_LEVEL_DEBUG, $message);
    }

    public function error($message = '')
    {
        $this->writeLog(self::LOG_LEVEL_ERROR, $message);
    }

    //这里间接相当于代理了
    private function writeLog($level, $message)
    {
        if (!empty(self::$logger[self::TYPE_THINKLOG])) {
            //转换大写
            $message = strtoupper($message);
        }

        $this->writeLogToLog($level, $message);
    }

    private function writeLogToLog($level)
    {
        $logObj = self::$logger[$this->type];
        if ($level == self::LOG_LEVEL_ERROR) {
            $logObj->error($message);
        } elseif ($level == self::LOG_LEVEL_DEBUG) {
            $logger->debug($message);
        } else {
            $logger->info($message);
        }
    }

    //工厂模式
    private static function instantLogFactory($type)
    {
        if (!empty(self::$logger[$type])) {
            return self::$logger[$type];
        }

        switch ($type) {
            case self::TYPE_LOG4PHP:
                //伪单利模式
                self::$logger[$type] = \Logger::getLogger("Log");
                break;
            case self::TYPE_THINKLOG:
                self::$logger[$type] = new Log;
                break;
            default:
                //默认
                self::$logger[$type] = \Logger::getLogger("Log");
                break;
        }
    }

    private function initType($type)
    {
        $this->type = $type;
    }
}