<?php
//读取当前系统设置
$env = parse_ini_file('.env', true);
define('STRACK_ENV', $env);

return [
    "paths" => [
        "migrations" => "manage/db/migrations",
        "seeds" => "manage/db/seeds"
    ],
    "environments" => [
        "default_migration_table" => "phinxlog",
        "default_database" => "product",
        "default_environment" => "product",
        "product" => [
            "adapter" => "mysql",
            "host" => $env["database_host"],
            "name" => $env["database_name"],
            "user" => $env["database_user"],
            "pass" => $env["database_password"],
            "port" => 3306,
            "charset" => "utf8"
        ]
    ]
];