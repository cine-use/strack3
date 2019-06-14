# 命令

Phinx 可以用以下命令执行

## Breakpoint 命令

Breakpoint 命令用来设置断点，可以使你对回滚进行限制。你可以调用 breakpoint 命令不带任何参数，即将断点设在最新的迁移脚本上

```
$ phinx breakpoint -e development
```

可以使用 `--target` 或者 `-t` 来指定断点打到哪个迁移版本上

```
$ phinx breakpoint -e development -t 20120103083322
```

可以使用 `--remove-all` 或者`-r` 来移除所有断点

```
$ phinx breakpoint -e development -r
```

当你运行 `status` 命令时可以看到断点信息

## Create 命令

create 命令用来创建迁移脚本文件。需要一个参数：脚本名。迁移脚本命名应该保持 驼峰命名法

```
$ phinx create MyNewMigration
```

打开新创建的迁移脚本并编写数据库修改。Phinx 把迁移脚本创建到 `phinx.yml` 里面指定的路径。更多信息参考 [配置](/configuration.md)

你可以重写模板文件，并在创建的时候指定模板

```
$ phinx create MyNewMigration --template="<file>"
```

可以提供一个模板类，这个类必须继承接口 `Phinx\Migration\CreationInterface`

```
$ phinx create MyNewMigration --class="<class>"
```

提供的模板中，类中也可以定义回调，这个回调将在迁移脚本生成的时候被调用

注意：你不能同时使用 `--template` 和 `--class`

## Init 命令

Init 命令用来Phinx初始化整个项目的时候使用。命令会生成一个`phinx.yml` 文件在项目根目录

```
$ cd yourapp
$ phinx init .
```

打开这个文件可以编辑配置。详细信息参考 [配置](/configuration.md)

## Migrate 命令

Migrate 命令默认运行执行所有脚本，可选指定环境

```
$ phinx migrate -e development
```

可以使用 `--target` 或者 `-t` 来指定执行某个迁移脚本

```
$ phinx migrate -e development -t 20110103081132
```

## Rollback 命令

Rollback 命令用来回滚之前的迁移脚本。与 Migrate 命令相反。

你可以使用 `rollback` 命令回滚上一个迁移脚本。不带任何参数

```
$ phinx rollback -e development
```

使用 `--target` 或者 `-t` 回滚指定版本迁移脚本

```
$ phinx rollback -e development -t 20120103083322
```

指定版本如果设置为0则回滚所有脚本

```
$ phinx rollback -e development -t 0
```

可以使用 `--date` 或者 `-d` 参数回滚指定日期的脚本

```
$ phinx rollback -e development -d 2012
$ phinx rollback -e development -d 201201
$ phinx rollback -e development -d 20120103
$ phinx rollback -e development -d 2012010312
$ phinx rollback -e development -d 201201031205
$ phinx rollback -e development -d 20120103120530
```

如果断点阻塞了回滚，你可以使用 `--force` 或者`-f`参数强制回滚

```
$ phinx rollback -e development -t 0 -f
```

## Status 命令

Status 命令可以打印所有迁移脚本和他们的状态。你可以用这个命令来看哪些脚本被运行过了

```
$ phinx status -e development
```

当所有脚本都已经执行（up）该命令将退出并返回 0

* 1：至少有一个回滚过的脚本（down）
* 2：至少有一个未执行的脚本

## Seed Create 命令

Seed Create 命令可以被用来创建 seed 类。需要一个类名参数。命名格式使用驼峰法。

```
$ phinx seed:create MyNewSeeder
```

## Seed Run 命令

默认Seed run 命令会执行所有 seed。

```
$ phinx seed:run -e development
```

 如果你想要指定执行一个，只要增加 -s 参数并接 seed 的名字

```
$ phinx seed:run -e development -s MyNewSeeder
```

## Configuration File 命令

当运行命令时，可以使用` --configuration` 或者 `-c` 参数指定配置文件. 配置文件会被转化成 PHP 数组

```
<?php
    return array(
        "paths" => array(
            "migrations" => "application/migrations"
        ),
        "environments" => array(
            "default_migration_table" => "phinxlog",
            "default_database" => "dev",
            "dev" => array(
                "adapter" => "mysql",
                "host" => $_ENV['DB_HOST'],
                "name" => $_ENV['DB_NAME'],
                "user" => $_ENV['DB_USER'],
                "pass" => $_ENV['DB_PASS'],
                "port" => $_ENV['DB_PORT']
            )
        )
    );
```

## 在Web中运行Phinx

Phinx 可以使用 `Phinx\Wrapper\TextWrapper` 运行在web中。`app/web.php` 提供了一个例子

```
$ php -S localhost:8000 vendor/robmorgan/phinx/app/web.php
```

这个命令会创建本地服务器 ： [http://localhost:8000](http://localhost:8000/) ，使用 [http://localhost:8000/migrate](http://localhost:8000/migrate) 运行迁移脚本，使用[http://localhost:8000/rollback](http://localhost:8000/rollback) 运行回滚操作。

**这个例子不应该运行在线上环境**





