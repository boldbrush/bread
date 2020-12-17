<?php

declare(strict_types=1);

namespace BoldBrush\Bread\System\Database;

use BoldBrush\Bread\System\Database\Exception\DriverNotSupported;

class ConfigTransformer
{
    public static function toDBAL(array $config): array
    {
        switch (true) {
            case $config['driver'] === 'sqlite':
                return [
                    'driver' => 'pdo_' . $config['driver'],
                    // 'user' => isset($config['user']) ? $config['user'] : null,
                    // 'password' => isset($config['password']) ? $config['password'] : null,
                    'path' => $config['database'],
                    // 'memory' => isset($config['memory']) ? $config['memory'] : null,
                ];
                break;
            case $config['driver'] === 'mysql':
                return [
                    'driver' => 'pdo_' . $config['driver'],
                    'user' => $config['username'],
                    'password' => $config['password'],
                    'host' => $config['host'],
                    'port' => !empty($config['port']) ? $config['port'] : null,
                    'dbname' => $config['database'],
                    'unix_socket' => $config['unix_socket'],
                    'charset' => $config['charset'] === 'utf8' ? 'UTF-8' : $config['charset'],
                ];
                break;
            case $config['driver'] === 'pgsql':
                return [
                    'driver' => 'pdo_' . $config['driver'],
                    'user' => $config['username'],
                    'password' => $config['password'],
                    'host' => $config['host'],
                    'port' => !empty($config['port']) ? $config['port'] : null,
                    'dbname' => $config['database'],
                    'charset' => $config['charset'] === 'utf8' ? 'UTF-8' : $config['charset'],
                    'default_dbname' => isset($config['default_dbname']) ? $config['default_dbname'] : null,
                    'sslmode' => isset($config['sslmode']) ? $config['sslmode'] : null,
                    'sslrootcert' => isset($config['sslrootcert']) ? $config['sslrootcert'] : null,
                    'sslcert' => isset($config['sslcert']) ? $config['sslcert'] : null,
                    'sslkey' => isset($config['sslkey']) ? $config['sslkey'] : null,
                    'sslcrl' => isset($config['sslcrl']) ? $config['sslcrl'] : null,
                    'application_name' => isset($config['application_name']) ? $config['application_name'] : null,
                ];
                break;
            case $config['driver'] === 'sqlsrv':
                return [
                    'driver' => 'pdo_' . $config['driver'],
                    'user' => $config['username'],
                    'password' => $config['password'],
                    'host' => $config['host'],
                    'port' => !empty($config['port']) ? $config['port'] : null,
                    'dbname' => $config['database'],
                    'charset' => $config['charset'] === 'utf8' ? 'UTF-8' : $config['charset'],
                ];
                break;
        }

        throw new DriverNotSupported('Driver not supported');
    }
}
