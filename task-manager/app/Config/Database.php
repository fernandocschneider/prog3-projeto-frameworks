<?php

namespace Config;

use CodeIgniter\Database\Config;

/**
 * Database Configuration
 */
class Database extends Config
{
    /**
     * The directory that holds the Migrations and Seeds directories.
     */
    public string $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;

    /**
     * Lets you choose which connection group to use if no other is specified.
     */
    public string $defaultGroup = 'default';

    /**
     * The default database connection.
     *
     * @var array<string, mixed>
     */
    public array $default = [
        'DSN'      => '',
        'hostname' => 'taskmanager-db',
        'username' => 'postgres',
        'password' => 'postgres',
        'database' => 'taskmanager',
        'DBDriver' => 'Postgre',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug'  => false,
        'charset'  => 'utf8',
        'DBCollat' => 'utf8_general_ci',
        'swapPre'  => '',
        'encrypt'  => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port'     => 5432,
        'schema'   => 'public',
        'cache_on' => true,
        'cachedir' => WRITEPATH . 'cache/db/',
        'char_set' => 'utf8',
        'dbcollat' => 'utf8_general_ci',
        'cache_autodel' => true,
        'cache_default_expire' => 300,
    ];

    public array $tests = [
        'DSN'      => '',
        'hostname' => 'taskmanager-db',
        'username' => 'postgres',
        'password' => 'postgres',
        'database' => 'taskmanager_test',
        'DBDriver' => 'Postgre',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug'  => true,
        'charset'  => 'utf8',
        'DBCollat' => 'utf8_general_ci',
        'swapPre'  => '',
        'encrypt'  => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port'     => 5432,
        'schema'   => 'public',
        'cache_on' => false,
        'cachedir' => WRITEPATH . 'cache/db/',
        'char_set' => 'utf8',
        'dbcollat' => 'utf8_general_ci',
        'cache_autodel' => true,
        'cache_default_expire' => 300,
    ];

    public function __construct()
    {
        parent::__construct();

        // Ensure that we always set the database group to 'tests' if
        // we are currently running an automated test suite, so that
        // we don't overwrite live data on accident.
        if (ENVIRONMENT === 'testing') {
            $this->defaultGroup = 'tests';
        }
    }
}
