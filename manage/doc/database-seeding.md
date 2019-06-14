# 数据库 Seeding

Phinx 0.5.0 支持数据库中使用seeding插入测试数据。Seed 类可以很方便的在数据库创建以后填充数据。这些文件默认放置在 seeds 目录，路径可以在配置文件中修改

> 数据库 seeding 是可选的，Phinx 并没有默认创建 seeds 目录

## 创建Seed类

Phinx 用下面命令创建一个新的 seed 类

```
$ php vendor/bin/phinx seed:create UserSeeder
```

如果你配置了多个seed路径，将会提示你选择seed放置目录

下面的Seed基于一个框架模板：

```php
<?php

use Phinx\Seed\AbstractSeed;

class MyNewSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {

    }
}
```

## AbstractSeed 类

所有 Phinx Seed 都继承 AbstractSeed类。这个类提供了 Seed 需要的基础方法。Seed 类 大部分用来插入测试数据。

### Run 方法

Run 方法将在 Phinx 执行 seed:run 时被自动调用。你可以将测试数据的插入写在里面。

> 不像数据库迁移，Phinx 并不记录 seed 是否执行过。这意味着 seeders 可以被重复执行。请在开发的时候记住

## 插入数据

### 使用Table对象

Seed 类也可以使用 Table 对象来插入数据。你可以调用 `table()` 方法来获取 Table 对象，然后调用`insert()` 方法来插入数据。

```php
<?php

use Phinx\Seed\AbstractSeed;

class PostsSeeder extends AbstractSeed
{
    public function run()
    {
        $data = array(
            array(
                'body'    => 'foo',
                'created' => date('Y-m-d H:i:s'),
            ),
            array(
                'body'    => 'bar',
                'created' => date('Y-m-d H:i:s'),
            )
        );

        $posts = $this->table('posts');
        $posts->insert($data)
              ->save();
    }
}
```

> 提交数据时必须调用 save\(\) 方法。Phinx 将缓存数据知道你调用save

### 使用Faker库注入

可以使用 [Faker library](https://github.com/fzaninotto/Faker) 方法来注入测试数据。首先使用 Composer 安装 Faker：

```
$ composer require fzaninotto/faker
```

然后在 seed 中使用

```php
<?php

use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
{
    public function run()
    {
        $faker = Faker\Factory::create();
        $data = [];
        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                'username'      => $faker->userName,
                'password'      => sha1($faker->password),
                'password_salt' => sha1('foo'),
                'email'         => $faker->email,
                'first_name'    => $faker->firstName,
                'last_name'     => $faker->lastName,
                'created'       => date('Y-m-d H:i:s'),
            ];
        }

        $this->insert('users', $data);
    }
}
```

## 清空数据表

可以使用 TRUNCATE 命令来清空数据表

```php
<?php

use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'body'    => 'foo',
                'created' => date('Y-m-d H:i:s'),
            ],
            [
                'body'    => 'bar',
                'created' => date('Y-m-d H:i:s'),
            ]
        ];

        $posts = $this->table('posts');
        $posts->insert($data)
              ->save();

        // empty the table
        $posts->truncate();
    }
}
```

## 执行 Seed

这很简单，当注入数据库时，只需要运行 seed:run 命令

```
$ php vendor/bin/phinx seed:run
```

默认Phinx会执行所有 seed。 如果你想要指定执行一个，只要增加 -s 参数并接 seed 的名字

```
$ php vendor/bin/phinx seed:run -s UserSeeder
```

也可以一次性执行多个 seed

```
$ php vendor/bin/phinx seed:run -s UserSeeder -s PermissionSeeder -s LogSeeder
```

可以使用 -v 参数获取更多提示信息

```
$ php vendor/bin/phinx seed:run -v
```

Phinx seed 提供了一个很简单的机制方便开发者可重复的插入测试数据

