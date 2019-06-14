## 插入数据

Phinx 可以很简单的帮助你在表中插入数据。尽管这个功能也在 [seed](/database-seeding.md) 中实现了。你也可以在迁移脚本中实现插入数据。

```php
<?php

use Phinx\Migration\AbstractMigration;

class NewStatus extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        // inserting only one row
        $singleRow = [
            'id'    => 1,
            'name'  => 'In Progress'
        ]

        $table = $this->table('status');
        $table->insert($singleRow);
        $table->saveData();

        // inserting multiple rows
        $rows = [
            [
              'id'    => 2,
              'name'  => 'Stopped'
            ],
            [
              'id'    => 3,
              'name'  => 'Queued'
            ]
        ];

        // this is a handy shortcut
        $this->insert('status', $rows);
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM status');
    }
}
```

> 不能在 _change\(\)_ 方法中使用插入数据，只能在 _up\(\)_ 和 _down\(\)_ 中使用



