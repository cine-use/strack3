## 获取数据

有2个方法可以获取数据。 `fetchRow()` 方法可以返回一条数据， `fetchAll()` 可以返回多条数据。2个方法都可以使用原生 SQL 语句作为参数。

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
        // fetch a user
        $row = $this->fetchRow('SELECT * FROM users');

        // fetch an array of messages
        $rows = $this->fetchAll('SELECT * FROM messages');
    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}
```



