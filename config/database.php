<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => env('DB_STRICT_MODE', true),
            'engine' => env('DB_ENGINE', 'InnoDB'),
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
                PDO::MYSQL_ATTR_SSL_CERT => env('MYSQL_ATTR_SSL_CERT'),
                PDO::MYSQL_ATTR_SSL_KEY => env('MYSQL_ATTR_SSL_KEY'),
                PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => env('MYSQL_ATTR_SSL_VERIFY_SERVER_CERT', false),
                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => env('MYSQL_ATTR_USE_BUFFERED_QUERY', true),
                PDO::MYSQL_ATTR_LOCAL_INFILE => env('MYSQL_ATTR_LOCAL_INFILE', false),
                PDO::ATTR_TIMEOUT => env('DB_CONNECT_TIMEOUT', 10),
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::MYSQL_ATTR_FOUND_ROWS => true,
            ]) : [],
            'pool' => [
                'min' => env('DB_POOL_MIN', 5),
                'max' => env('DB_POOL_MAX', 20),
                'acquire_timeout' => env('DB_POOL_ACQUIRE_TIMEOUT', 60000),
                'timeout' => env('DB_POOL_TIMEOUT', 5000),
                'idle_timeout' => env('DB_POOL_IDLE_TIMEOUT', 300000),
            ],
            'read' => [
                'host' => [
                    env('DB_HOST', '127.0.0.1'),
                ],
                'timeout' => env('DB_READ_TIMEOUT', 30),
            ],
            'write' => [
                'host' => [
                    env('DB_HOST', '127.0.0.1'),
                ],
                'timeout' => env('DB_WRITE_TIMEOUT', 30),
            ],
            'sticky' => true,
        ],
    ],

    'migrations' => env('DB_MIGRATIONS_TABLE', 'migrations'),

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

];
