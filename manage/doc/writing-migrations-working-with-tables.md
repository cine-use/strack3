## 数据表操作

### Table 对象

Table对象是Phinx中最有用的API之一。它可以让你方便的用 PHP 代码操作数据库。我们可以通过 `table()` 方法取到Table对象。

```php
<?php

use Phinx\Migration\AbstractMigration;

class MyNewMigration extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('tableName');
    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}
```

接下来，你可以用 Table 对象提供的方法来操作修改数据库了

### Save 方法

当操作 Table 对象时，Phinx 提供了一些操作来改变数据库。

如果你不清楚该使用什么操作，建议你使用 save 方法。它将自动识别插入或者更新操作，并将改变应用到数据库。

### 创建一个表

使用 Table 可以很简单的创建一个表，现在我们创建一个存储用户信息的表

```php
<?php

use Phinx\Migration\AbstractMigration;

class MyNewMigration extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $users = $this->table('users');
        $users->addColumn('username', 'string', array('limit' => 20))
              ->addColumn('password', 'string', array('limit' => 40))
              ->addColumn('password_salt', 'string', array('limit' => 40))
              ->addColumn('email', 'string', array('limit' => 100))
              ->addColumn('first_name', 'string', array('limit' => 30))
              ->addColumn('last_name', 'string', array('limit' => 30))
              ->addColumn('created', 'datetime')
              ->addColumn('updated', 'datetime', array('null' => true))
              ->addIndex(array('username', 'email'), array('unique' => true))
              ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}
```

字段使用 `addColumn()` 方法创建。并且用 `addIndex()` 方法将 username 和 email 设置为唯一。最后调用 `save()` 提交我们的改变。

> Phinx 会为每个表自动创建一个自增的主键字段 `id`

id 选项会自动创建一个唯一字段，`primary_key`_ 选项设置哪个字段为主键。 _`primary_key` 选项默认值是 `id` 。这2个选项可以设置为false。

如果要指定一个主键，你可以设置 `primary_key` 选项，关闭自动生成 `id` 选项，并使用2个字段定义为主键。

```php
<?php

use Phinx\Migration\AbstractMigration;

class MyNewMigration extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('followers', array('id' => false, 'primary_key' => array('user_id', 'follower_id')));
        $table->addColumn('user_id', 'integer')
              ->addColumn('follower_id', 'integer')
              ->addColumn('created', 'datetime')
              ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}
```

单独设置 `primary_key`_ 选项并不能开启 _`AUTO_INCREMENT` 选项。如果想简单的改变主键名，我们只有覆盖 `id` 字段名即可。

```php
<?php

use Phinx\Migration\AbstractMigration;

class MyNewMigration extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('followers', array('id' => 'user_id'));
        $table->addColumn('follower_id', 'integer')
              ->addColumn('created', 'timestamp', array('default' => 'CURRENT_TIMESTAMP'))
              ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}
```

另外，MySQL adapter 支持以下选项

| 选项 | 描述 |
| :--- | :--- |
| comment | 给表设置注释 |
| engine | 定义表的引擎（默认 InnoDB） |
| collation | 定义表的语言（默认 utf8-general-ci） |

## 字段类型

字段类型如下：

* biginteger
* binary
* boolean
* date
* datetime
* decimal
* float
* integer
* string
* text
* time
* timestamp
* uuid

另外，MySQL adapter 支持 `enum` 、`set` 、`blob` 和 `json` （`json` 需要 MySQL 5.7 或者更高）

Postgres adapter 支持 `smallint` 、`json` 、`jsonb` 和 `uuid` （需要 PostgresSQL 9.3 或者更高）

### 表是否存在

可以使用 `hasTable()` 判断表是否存在。

```php
<?php

use Phinx\Migration\AbstractMigration;

class MyNewMigration extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $exists = $this->hasTable('users');
        if ($exists) {
            // do something
        }
    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}
```

### 删除表

可以用 `dropTable()` 方法删除表。这时可以在 \`down\(\)\` 方法中重新创建表，可以在回滚的时候恢复。

```php
<?php

use Phinx\Migration\AbstractMigration;

class MyNewMigration extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $this->dropTable('users');
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $users = $this->table('users');
        $users->addColumn('username', 'string', array('limit' => 20))
              ->addColumn('password', 'string', array('limit' => 40))
              ->addColumn('password_salt', 'string', array('limit' => 40))
              ->addColumn('email', 'string', array('limit' => 100))
              ->addColumn('first_name', 'string', array('limit' => 30))
              ->addColumn('last_name', 'string', array('limit' => 30))
              ->addColumn('created', 'datetime')
              ->addColumn('updated', 'datetime', array('null' => true))
              ->addIndex(array('username', 'email'), array('unique' => true))
              ->save();
    }
}
```

### 重命名表名

可以用 `rename()` 方法重命名表名。

```php
<?php

use Phinx\Migration\AbstractMigration;

class MyNewMigration extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('users');
        $table->rename('legacy_users');
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $table = $this->table('legacy_users');
        $table->rename('users');
    }
}
```



