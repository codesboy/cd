<?php
return [
    // 数据库名
    'database'    => 'clients',
    // 数据库密码
    'password'    => 'root',
    // 数据库表前缀
    'prefix'      => 'client_',
    // 数据库连接参数
    'params' => [
        // 使用长连接
        \PDO::ATTR_PERSISTENT => true,
    ],    
];