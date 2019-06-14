# strack
Strack 3.0 流程管理系统，数据中心化平台。主要数据追踪和审核两大模块

# 目录

~~~
├─Addons                插件模块目录
│  ├─Demo               示例插件目录
│  │  ├─Controller      示例插件控制器目录
│  │  ├─Model           示例插件模型目录
│  │  ├─View            示例插件视图目录
│  │  └─ ...            更多类库目录
│
├─App                   应用目录
│  └─...                更多
│
├─Core                  框架系统目录
│  └─...                更多
│
├─doc                   帮助文档目录
│  └─...                更多
│
├─manage                数据管理目录
│  └─...                更多
│
├─Public                对外访问目录
│  └─...                更多
│
├─Runtime               应用的运行时目录（可写，可定制）
├─Runtime-test          单元测试应用的运行时目录（可写，可定制）
├─server                swoole服务相关目录
├─test                  测试文件目录
├─tpl                   视图文件目录
├─Uploads               上传文件目录
├─vendor                composer 包文件
├─composer.json         composer 定义文件
├─.env                  配置文件
├─.htaccess             用于apache的重写
├─gulpfile.js           gulp 配置文件
├─package.json          node 包定义文件
├─README.md             README 文件
├─index.php             入口文件
~~~

## php兼容性检查命令

vendor/bin/phpcs --standard=PHPCompatibility --extensions=php --runtime-set testVersion 7.3 /data/wwwroot/default/strack/Core


