<?php

namespace Queue\Framework;

use Kcloze\Jobs\Config;
use Kcloze\Jobs\JobObject;
use Kcloze\Jobs\Logs;
use Kcloze\Jobs\Utils;

class StrackAction
{
    protected $logger;

    public function init()
    {
        $this->logger = Logs::getLogger(Config::getConfig()['logPath'] ?? '', Config::getConfig()['logSaveFileApp'] ?? '', Config::getConfig()['system'] ?? '');
    }

    /**
     * @param JobObject $JobObject
     */
    public function start(JobObject $JobObject)
    {
        $this->init();
        try {
            \Think\App::initCommon();
            // 执行应用
            \Think\Console::call($JobObject->jobClass, $JobObject->jobParams);
        } catch (\Throwable $e) {
            Utils::catchError($this->logger, $e);
        } catch (\Exception $e) {
            Utils::catchError($this->logger, $e);
        }
    }
}
