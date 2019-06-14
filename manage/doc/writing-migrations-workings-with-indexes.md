## 索引操作

使用 `addIndex()` 方法可以指定索引

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
        $table->addColumn('city', 'string')
              ->addIndex(array('city'))
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

Phinx 默认创建的是普通索引， 我们可以通过添加 `unique` 参数来指定唯一值。也可以使用 `name` 参数来制定索引名。

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
        $table->addColumn('email', 'string')
              ->addIndex(array('email'), array('unique' => true, 'name' => 'idx_users_email'))
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

MySQL adapter 支持 `fulltext` 索引。 如果你使用版本低于 5.6 则必须确保数据表是 `MyISAM`引擎

```php
<?php

use Phinx\Migration\AbstractMigration;

class MyNewMigration extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('users', ['engine' => 'MyISAM']);
        $table->addColumn('email', 'string')
              ->addIndex('email', ['type' => 'fulltext'])
              ->create();
    }
}
```

调用 `removeIndex()` 方法可以删除索引。必须一条条删除

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
        $table->removeIndex(array('email'));

        // alternatively, you can delete an index by its name, ie:
        $table->removeIndexByName('idx_users_email');
    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}
```

> 当调用 removeIndex\(\) 方法时不需要调用 save\(\) 方法。 索引会立即删除



