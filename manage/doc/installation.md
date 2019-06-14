# 安装

Phinx 可以使用 Composer 进行安装，Composer是一个PHP依赖管理工具。更多信息请访问 [Composer](https://getcomposer.org/) 官网。

> Phinx 至少需要PHP 5.4 或更新的版本

使用Composer进行安装Phinx：

```bash
php composer.phar require robmorgan/phinx
```

在你项目目录中创建目录 `db/migrations` ，并给予充足权限。这个目录将是你迁移脚本放置的地方，并且应该被设置为可写权限。

安装后，Phinx 现在可以在你的项目中执行初始化

```bash
vendor/bin/phinx init
```



