<?php
$db = parse_url(env('CLEARDB_DATABASE_URL'));
return [
    'debug' => false,

    'App' => [
        'namespace' => 'SasakiScheduler',
        'encoding' => env('APP_ENCODING', 'UTF-8'),
        'defaultLocale' => env('APP_DEFAULT_LOCALE', 'en_US'),
        'defaultTimezone' => env('APP_DEFAULT_TIMEZONE', 'UTC'),
        'base' => false,
        'dir' => 'src',
        'webroot' => 'webroot',
        'wwwRoot' => WWW_ROOT,
        //'baseUrl' => env('SCRIPT_NAME'),
        'fullBaseUrl' => false,
        'imageBaseUrl' => 'img/',
        'cssBaseUrl' => 'css/',
        'jsBaseUrl' => 'js/',
        'paths' => [
            'plugins' => [ROOT . DS . 'plugins' . DS],
            'templates' => [APP . 'Template' . DS],
            'locales' => [APP . 'Locale' . DS],
        ],
    ],

    'Security' => [
        'salt' => env('SALT'),
    ],

    'Asset' => [
        //'timestamp' => true,
    ],

    'Cache' => [
        'default' => [
            'className' => 'Memcached',
            'prefix' => 'myapp_cake_',
            'servers' => [env('MEMCACHIER_SERVERS')],
            'username' => env('MEMCACHIER_USERNAME'),
            'password' => env('MEMCACHIER_PASSWORD'),
            'duration' => '+1440 minutes',
        ],

        'session' => [
            'className' => 'Memcached',
            'prefix' => 'myapp_cake_session_',
            'servers' => [env('MEMCACHIER_SERVERS')],
            'username' => env('MEMCACHIER_USERNAME'),
            'password' => env('MEMCACHIER_PASSWORD'),
            'duration' => '+1440 minutes',
        ],

        '_cake_core_' => [
            'className' => 'Memcached',
            'prefix' => 'myapp_cake_core_',
            'servers' => [env('MEMCACHIER_SERVERS')],
            'username' => env('MEMCACHIER_USERNAME'),
            'password' => env('MEMCACHIER_PASSWORD'),
            'duration' => '+1 years',
        ],

        '_cake_model_' => [
            'className' => 'Memcached',
            'prefix' => 'myapp_cake_model_',
            'servers' => [env('MEMCACHIER_SERVERS')],
            'username' => env('MEMCACHIER_USERNAME'),
            'password' => env('MEMCACHIER_PASSWORD'),
            'duration' => '+1 years',
        ],
    ],

    'Error' => [
        'errorLevel' => E_ALL,
        'exceptionRenderer' => 'Cake\Error\ExceptionRenderer',
        'skipLog' => [],
        'log' => true,
        'trace' => true,
    ],

    'EmailTransport' => [
        'default' => [
            'className' => 'Mail',
            /*
             * The following keys are used in SMTP transports:
             */
            'host' => 'localhost',
            'port' => 25,
            'timeout' => 30,
            'username' => null,
            'password' => null,
            'client' => null,
            'tls' => null,
            'url' => env('EMAIL_TRANSPORT_DEFAULT_URL', null),
        ],
    ],

    'Email' => [
        'default' => [
            'transport' => 'default',
            'from' => 'you@localhost',
            //'charset' => 'utf-8',
            //'headerCharset' => 'utf-8',
        ],
    ],

    'Datasources' => [
        'default' => [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Mysql',
            'persistent' => false,
            'host' => $db['host'],
            'username' => $db['user'],
            'password' => $db['pass'],
            'database' => substr($db['path'], 1),
            'timezone' => 'UTC',
            'flags' => [],
            'cacheMetadata' => true,
            'log' => false,
            'quoteIdentifiers' => false,
        ],

        /**
         * The test connection is used during the test suite.
         */
        'test' => [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Mysql',
            'persistent' => false,
            'host' => 'localhost',
            //'port' => 'non_standard_port_number',
            'username' => 'my_app',
            'password' => 'secret',
            'database' => 'test_myapp',
            //'encoding' => 'utf8mb4',
            'timezone' => 'UTC',
            'cacheMetadata' => true,
            'quoteIdentifiers' => false,
            'log' => false,
            //'init' => ['SET GLOBAL innodb_stats_on_metadata = 0'],
            'url' => env('DATABASE_TEST_URL', null),
        ],
    ],

    /**
     * Configures logging options
     */
    'Log' => [
        'debug' => [
            'className' => 'Cake\Log\Engine\ConsoleLog',
            'stream' => 'php://stdout',
            'levels' => ['notice', 'info', 'debug'],
        ],
        'error' => [
            'className' => 'Cake\Log\Engine\ConsoleLog',
            'stream' => 'php://stderr',
            'levels' => ['warning', 'error', 'critical', 'alert', 'emergency'],
        ],
    ],
    'Session' => [
        'defaults' => 'cache',
        'handler' => [
            'config' => 'session',
        ],
    ],
];
