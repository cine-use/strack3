<?php


// 定义项目路径
define('APP_MODE', 'cli');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG', false);

define('SWOOLE_JOBS_ROOT_PATH', __DIR__ . '/test');
define('APP_PATH', __DIR__ . '/../../App/');
define('RUNTIME_PATH', __DIR__ . '/../../Runtime/');

date_default_timezone_set('Asia/Shanghai');

require __DIR__ . '/../../Core/Base.php';

// 执行应用
\Think\App::initCommon();
\Think\Console::init(false);

print_r(S("test_event"));
print_r(2222222222);

$name = \Queue\Controller\JobsController::push('Event', 'event', '', ['event_data' => '{"event_from":"strack_web","params":{"operate":"update","primary_id":1,"primary_field":"id","data":{"old":{"code":"V5-0001_D018C031_180519_R3FG222"},"new":{"code":"V5-0001_D018C031_180519_R3"}},"param":{"table":"strack_entity","model":"Entity","where":{"id":"1"}},"table":"strack_entity"},"user_info":{"id":1,"login_name":"strack_admin","email":"admin@strack.com","name":"administrator","nickname":"admin","phone":"88888888888","department_id":0,"password":"$P$BRpF99iQ4yAtVa2364s9aJVCga7yJY.","status":"u5728u804c","login_session":"esytJr1acc2kV.ylXo2gliknI_j2o0x2L0CJ0b2tlbl90aW1lIjoxNTQ1ODgxOTc5fQO0O0OO0O0O","login_count":0,"token_time":1545881979,"forget_count":0,"forget_token":"","last_forget":0,"failed_login_count":0,"last_login":1545881979,"created":"","uuid":"f3c47540-0988-11e9-8107-1fd760cf0609"}}']);

// $JobObject = new \Kcloze\Jobs\JobObject('Event', 'event', '', ['event_data' => '{"event_from":"strack_web","params":{"operate":"update","primary_id":1,"primary_field":"id","data":{"old":{"code":"V5-0001_D018C031_180519_R3FG222"},"new":{"code":"V5-0001_D018C031_180519_R3"}},"param":{"table":"strack_entity","model":"Entity","where":{"id":"1"}},"table":"strack_entity"},"user_info":{"id":1,"login_name":"strack_admin","email":"admin@strack.com","name":"administrator","nickname":"admin","phone":"88888888888","department_id":0,"password":"$P$BRpF99iQ4yAtVa2364s9aJVCga7yJY.","status":"u5728u804c","login_session":"esytJr1acc2kV.ylXo2gliknI_j2o0x2L0CJ0b2tlbl90aW1lIjoxNTQ1ODgxOTc5fQO0O0OO0O0O","login_count":0,"token_time":1545881979,"forget_count":0,"forget_token":"","last_forget":0,"failed_login_count":0,"last_login":1545881979,"created":"","uuid":"f3c47540-0988-11e9-8107-1fd760cf0609"}}'], []);

// \Think\Console::call($JobObject->jobClass, $JobObject->jobParams);