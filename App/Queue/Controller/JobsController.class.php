<?php

namespace Queue\Controller;

use Common\Controller\VerifyController;
use Kcloze\Jobs\JobObject;
use Kcloze\Jobs\Logs;
use Kcloze\Jobs\Queue\BaseTopicQueue;
use Kcloze\Jobs\Queue\Queue;

class JobsController extends VerifyController
{
    /**
     * 推送swoole异步任务
     * @param $jobName topic名，跟swoole-jobs配置一致
     * @param $jobClass 任务名称,对应application/index/command目录中的类名
     * @param string $method 类方法名
     * @param array $params 方法参数，类型为数组，数组值顺序对应方法参数顺序
     * @param array $jobExt 任务附加参数['delay'=>'延迟毫秒数','priority'=>'任务权重,数字类型,范围：1-5']
     * @return mixed
     * @throws \Exception
     */
    public static function push($jobName, $jobClass, $method = '', $params = [], $jobExt = [])
    {
        if (empty($jobName)) {
            throw new \Exception('Asynchronous task name cannot be empty');
        }

        $config = C('JOBS');

        $logger = Logs::getLogger($config['logPath'] ?? '', $config['logSaveFileApp'] ?? '');
        $queue = Queue::getQueue($config['job']['queue'], $logger);

        //设置工作进程参数
        $queue->setTopics($config['job']['topics']);

        $jobExtras['delay'] = isset($jobExt['delay']) ? $jobExt['delay'] : 0;
        $jobExtras['priority'] = isset($jobExt['priority']) ? $jobExt['priority'] : BaseTopicQueue::HIGH_LEVEL_1;

        $job = new JobObject($jobName, $jobClass, $method, $params, $jobExtras);
        $result = $queue->push($jobName, $job);

        return $result;
    }
}