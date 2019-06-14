## 执行查询

可以使用 `execute()` 和 `query()` 方法进行查询。`execute()` 方法会返回查询条数，`query()` 方法会返回结果。结果参照 [PDOStatement](http://php.net/manual/en/class.pdostatement.php)

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
        // execute()
        $count = $this->execute('DELETE FROM users'); // returns the number of affected rows

        // query()
        $rows = $this->query('SELECT * FROM users'); // returns the result as an array
    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}
```

## 



