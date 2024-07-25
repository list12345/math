<?php

$db_dsn = parse_url(getenv('CONFIG_DB_DSN'));

return [
    'class' => 'yii\db\Connection',
    'dsn' => ($db_dsn['scheme'] ?? '') .
        ':host=' . ($db_dsn['host'] ?? '') .
        ';port=' . ($db_dsn['port'] ?? '') .
        ';dbname=' . ltrim(($db_dsn['path'] ?? ''), '/'),
    'username' => ($db_dsn['user'] ?? ''),
    'password' => ($db_dsn['pass'] ?? ''),
    'charset' => 'utf8',
    'tablePrefix' => '',
    'enableSchemaCache' => !YII_DEBUG,
    'schemaCacheDuration' => 60,
    'schemaCache' => 'cache',
];
