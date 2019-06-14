## 外键操作

Phinx 支持创建外键限制数据表。下面是一个外键创建例子

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
        $table = $this->table('tags');
        $table->addColumn('tag_name', 'string')
              ->save();

        $refTable = $this->table('tag_relationships');
        $refTable->addColumn('tag_id', 'integer')
                 ->addForeignKey('tag_id', 'tags', 'id', array('delete'=> 'SET_NULL', 'update'=> 'NO_ACTION'))
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

"On delete" 和 “On update” 操作分别使用 “delete” 和 “update” 选项定义。选项值可能是 ‘SET\_NULL’, ‘NO\_ACTION’, ‘CASCADE’ 和 ‘RESTRICT’。约束名可以使用 `constraint` 选项改变

也可以使用 `addForeignKey()` 多个字段。允许我们建立多个组合字段的外键

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
        $table = $this->table('follower_events');
        $table->addColumn('user_id', 'integer')
              ->addColumn('follower_id', 'integer')
              ->addColumn('event_id', 'integer')
              ->addForeignKey(array('user_id', 'follower_id'),
                              'followers',
                              array('user_id', 'follower_id'),
                              array('delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION', 'constraint' => 'user_follower_id'))
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

我们可以使用 `constraint` 参数给外面命名。仅支持 Phinx 版本 大于0.6.5

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
        $table = $this->table('your_table');
        $table->addForeignKey('foreign_id', 'reference_table', array('id'),
                            array('constraint'=>'your_foreign_key_name'));
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

可以通过 `hasForeignKey()` 方法检查是否有外键

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
        $table = $this->table('tag_relationships');
        $exists = $table->hasForeignKey('tag_id');
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

最后，可以使用 `dropForeignKey` 方法删除外键

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
        $table = $this->table('tag_relationships');
        $table->dropForeignKey('tag_id');
    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}
```



