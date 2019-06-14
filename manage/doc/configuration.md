# 配置

当使用 [Init命令 ](/命令)初始化项目时，Phinx默认创建一个文件 `phinx.yaml` 在项目根目录。文件是 YAML 格式。

如果 `--configuration` 参数提供了，那Phinx会载入指定配置文件，否则会尝试寻找 `phinx.php` , `phinx.json`, `phinx.yaml`

并加载。

注意 JSON 和 YAML 文件需要转化，PHP文件直接引用。意味着：

* 配置文件必须返回一个配置数组
* 变量定义域是本地，\*\*\*\*\*\*\*（这句话不大理解）
* 标准输出
* 不像 JSON 和 YAML，\*\*\*\*\*（这句话不大理解）

```php
require 'app/init.php';

global $app;
$pdo = $app->getDatabase()->getPdo();

return array('environments' =>
         array(
           'default_database' => 'development',
           'development' => array(
             'name' => 'devdb',
             'connection' => $pdo
           )
         )
       );
```

## Migration 路径

第一个选项指定了迁移脚本目录。 默认是 `%%PHINX_CONFIG_DIR%%/db/migrations`

> `%%PHINX_CONFIG_DIR%% 自动替换为项目根目录`

如果要重写迁移脚本目录，需要增加以下代码到 yaml 配置文件

```
paths:
    migrations: /your/full/path
```

也可以提供多个路径

```
paths:
    migrations:
        - application/module1/migrations
        - application/module2/migrations
```

可以使用在你的路径中使用 `%%PHINX_CONFIG_DIR%%`

```
paths:
    migrations: %%PHINX_CONFIG_DIR%%/your/relative/path
```

你也可以定义正则表达式的路径

```
paths:
    migrations: %%PHINX_CONFIG_DIR%%/module/*/{data,scripts}/migrations
```

## 自定义迁移脚本基类

Phinx 默认迁移脚本基类是 AbstractMigration 。可以在配置文件的 `migration_base_class` 设置自定义的基类

```
migration_base_class: MyMagicalMigration
```

## Seed 路径

第二个选项指定了Seed放置目录。 默认是`%%PHINX_CONFIG_DIR%%/db/seeds`

> `%%PHINX_CONFIG_DIR%% 自动替换为项目根目录`

如果要重写Seed目录，需要增加以下代码到 yaml 配置文件

```
paths:
    seeds: /your/full/path
```

也可以提供多个路径

```
paths:
    seeds:
        - /your/full/path1
        - /your/full/path2
```

可以使用在你的路径中使用 `%%PHINX_CONFIG_DIR%%`

```
paths:
    seeds: %%PHINX_CONFIG_DIR%%/your/relative/path
```

你也可以定义正则表达式的路径

```
paths:
    seeds: %%PHINX_CONFIG_DIR%%/your/relative/path
```

## 环境

Phinx一个重要功能就是支持多个数据库环境。可以在本地开发环境使用迁移脚本，同样的脚本也可以在线上环境使用。环境数据在 `enviroments` 下

```
environments:
    default_migration_table: phinxlog
    default_database: development
    production:
        adapter: mysql
        host: localhost
        name: production_db
        user: root
        pass: ''
        port: 3306
        charset: utf8
        collation: utf8_unicode_ci
```

可以定义一个新的环境叫做 `production`

有一种情况，当多个开发者工作在不同的开发环境，或者当你需要根据不同的目的（分支，测试等）来区分环境时，可以使用环境变量 PHINX\_ENVIRONMENT 覆盖 yaml文件中的默认环境

    export PHINX_ENVIRONMENT=dev-`whoami`-`hostname`

## 表前缀后缀

可以定义数据表的前缀后缀

```
environments:
    development:
        ....
        table_prefix: dev_
        table_suffix: _v1
    testing:
        ....
        table_prefix: test_
        table_suffix: _v2
```

## Socket 连接

当使用 MySQL adapter 时，可以用sockets连接替换网络连接。使用 `unix_socket` 配置 socket

```
environments:
    default_migration_table: phinxlog
    default_database: development
    production:
        adapter: mysql
        name: production_db
        user: root
        pass: ''
        unix_socket: /var/run/mysql/mysql.sock
        charset: utf8
```

## 外部变量

Phinx会自动抓取所有以 PHINX\_ 为前缀的环境变量并使用在配置文件中。这个值将被 %%框在里面，注意名字要完全一致。比如`%%PHINX_DBUSER%%`。这很有用，当你不想你的数据库信息放进版本库中可以使用这个功能。

```
environments:
    default_migration_table: phinxlog
    default_database: development
    production:
        adapter: mysql
        host: %%PHINX_DBHOST%%
        name: %%PHINX_DBNAME%%
        user: %%PHINX_DBUSER%%
        pass: %%PHINX_DBPASS%%
        port: 3306
        charset: utf8
```

## 支持的 Adapter

Phinx 当前支持以下数据库adapter

* [MySQL](http://www.mysql.com/)：指定 `mysql` adapter

* [PostgreSQL](http://www.postgresql.org/)：指定 `pgsql`adapter

* [SQLite](http://www.sqlite.org/)：指定 `sqlite` adapter

* [SQL Server](http://www.microsoft.com/sqlserver)：指定 `sqlsrv` adapter

### SQLite

声明 SQLite 数据库：

```
environments:
    development:
        adapter: sqlite
        name: ./data/derby
    testing:
        adapter: sqlite
        memory: true     # Setting memory to *any* value overrides name
```

## Version 顺序

当执行回滚或者打印迁移脚本状态时，Phinx 顺序通过 `version_order` 控制

* `creation` （默认）：迁移脚本按照创建时间排序，也就是按照文件名排序
* `execution`：迁移脚本按照执行顺序排序，也就是开始时间



