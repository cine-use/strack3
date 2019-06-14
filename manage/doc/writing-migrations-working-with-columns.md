## 字段操作

### 字段类型

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

### 字段选项

以下是有效的字段选项：

所有字段：

| 选项 | 描述 |
| :--- | :--- |
| limit | 为string设置最大长度 |
| length | limit 的别名 |
| default | 设置默认值 |
| null | 允许空 |
| after | 指定字段放置在哪个字段后面 |
| comment | 字段注释 |

`decimal` 类型字段：

| 选项 | 描述 |
| :--- | :--- |
| precision | 和 scale 组合设置精度 |
| scale | 和 precision 组合设置精度 |
| signed | 开启或关闭 unsigned 选项（仅适用于 MySQL） |

`enum` 和 `set` 类型字段：

| 选项 | 描述 |
| :--- | :--- |
| values | 用逗号分隔代表值 |

`integer` 和 `biginteger` 类型字段：

| 选项 | 描述 |
| :--- | :--- |
| identity | 开启或关闭自增长 |
| signed | 开启或关闭 unsigned 选项（仅适用于 MySQL） |

`timestamp` 类型字段：

| 选项 | 描述 |
| :--- | :--- |
| default | 设置默认值 （CURRENT\_TIMESTAMP） |
| update | 当数据更新时的触发动作 （CURRENT\_TIMESTAMP） |
| timezone | 开启或关闭 with time zone 选项 |

可以在标准使用 `addTimestamps()` 方法添加 `created_at`_ 和 _`updated_at` 。方法支持自定义名字。

```php
<?php

use Phinx\Migration\AbstractMigration;

class MyNewMigration extends AbstractMigration
{
    /**
     * Migrate Change.
     */
    public function change()
    {
        // Override the 'updated_at' column name with 'amended_at'.
        $table = $this->table('users')->addTimestamps(null, 'amended_at')->create();
    }
}
```

`boolean` 类型字段：

| 选项 | 描述 |
| :--- | :--- |
| signed | 开启或关闭 unsigned 选项（仅适用于 MySQL） |

`string` 和`text` 类型字段：

| 选项 | 描述 |
| :--- | :--- |
| collation | 设置字段的 collation （仅适用于 MySQL） |
| encoding | 设置字段的 encoding （仅适用于 MySQL） |

外键定义：

| 选项 | 描述 |
| :--- | :--- |
| update | 设置一个触发器当数据更新时 |
| delete | 设置一个触发器当数据删除时 |

你可以通过可选的第三个数组型参数将上述选项中的一个或者多个传递到任意字段中。

### Limit 选项 和 PostgreSQL

当使用 PostgreSQL adapter，一些其他的字段类型可以通过 `integer` 创建。使用下面的 `Limit` 选项。

| Limit | 字段类型 |
| :--- | :--- |
| INT\_SMALL | SMALLINT |

```php
use Phinx\Db\Adapter\PostgresAdapter;

//...

$table = $this->table('cart_items');
$table->addColumn('user_id', 'integer')
      ->addColumn('subtype_id', 'integer', array('limit' => PostgresAdapter::INT_SMALL))
      ->create();
```

### Limit 选项 和 MySQL

当使用 MySQL adapter，一些其他的字段类型可以通过 `integer` 、 `text` 和 `blob` 创建。使用下面的 `Limit` 选项

| Limit | 字段类型 |
| :--- | :--- |
| BLOG\_TINY | TINYBLOB |
| BLOB\_REGULAR | BLOG |
| BLOG\_MEDIUM | MEDIUMELOG |
| BLOB\_LONG | LONGBLOB |
| TEXT\_TINY | TINYTEXT |
| TEXT\_REGULAR | TEXT |
| TEXT\_MEDIUM | MEDIUMTEXT |
| TEXT\_LONG | LONGTEXT |
| INT\_TINY | TINYINT |
| INT\_SMALL | SMALLINT |
| INT\_MEDIUM | MEDIUMINT |
| INT\_REGULAR | INT |
| INT\_BIG | BIGINT |

```php
use Phinx\Db\Adapter\MysqlAdapter;

//...

$table = $this->table('cart_items');
$table->addColumn('user_id', 'integer')
      ->addColumn('product_id', 'integer', array('limit' => MysqlAdapter::INT_BIG))
      ->addColumn('subtype_id', 'integer', array('limit' => MysqlAdapter::INT_SMALL))
      ->addColumn('quantity', 'integer', array('limit' => MysqlAdapter::INT_TINY))
      ->create();
```

### 获取字段List

调用 `getColumns()` 可以获得表的所有字段。该方法返回 `Column` 类的数组。如下例子

```php
<?php

use Phinx\Migration\AbstractMigration;

class ColumnListMigration extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $columns = $this->table('users')->getColumns();
        ...
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        ...
    }
}
```

### 检查字段是否存在

调用 `hasColumn()` 方法判断指定字段是否存在

```php
<?php

use Phinx\Migration\AbstractMigration;

class MyNewMigration extends AbstractMigration
{
    /**
     * Change Method.
     */
    public function change()
    {
        $table = $this->table('user');
        $column = $table->hasColumn('username');

        if ($column) {
            // do something
        }

    }
}
```

### 重命名字段

调用 `renameColumn()` 方法重命名字段

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
        $table->renameColumn('bio', 'biography');
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $table = $this->table('users');
        $table->renameColumn('biography', 'bio');
    }
}
```

### 在一个字段后创建字段

可以使用 `after` 选项指定字段创建的位置

```php
<?php

use Phinx\Migration\AbstractMigration;

class MyNewMigration extends AbstractMigration
{
    /**
     * Change Method.
     */
    public function change()
    {
        $table = $this->table('users');
        $table->addColumn('city', 'string', array('after' => 'email'))
              ->update();
    }
}
```

### 删除字段

使用 `removeColumn()` 方法删除字段

```php
<?php

use Phinx\Migration\AbstractMigration;

class MyNewMigration extends AbstractMigration
{
    /**
     * Migrate up.
     */
    public function up()
    {
        $table = $this->table('users');
        $table->removeColumn('short_name')
              ->save();
    }
}
```

### 指定字段Limit

使用 `limit` 选项设置字段的最大长度

```php
<?php

use Phinx\Migration\AbstractMigration;

class MyNewMigration extends AbstractMigration
{
    /**
     * Change Method.
     */
    public function change()
    {
        $table = $this->table('tags');
        $table->addColumn('short_name', 'string', array('limit' => 30))
              ->update();
    }
}
```

### 修改字段属性

使用 `changeColumn()` 方法修改字段属性

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
        $users->changeColumn('email', 'string', array('limit' => 255))
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



