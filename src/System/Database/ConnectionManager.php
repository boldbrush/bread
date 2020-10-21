<?php

namespace BoldBrush\Bread\System\Database;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Connection;
use PDO;

class ConnectionManager
{
    public const DEFAULT_CONNECTION = 'default';

    private $dbal;

    protected static $instance;

    public static function instance()
    {
        if (null === self::$instance) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public function __construct()
    {
        $this->dbal = collect();
    }

    public function addConnection(array $config, string $name = self::DEFAULT_CONNECTION): self
    {
        $config = $this->configTransformer($config);

        $connection = DriverManager::getConnection($config);

        $this->dbal->put($name, $connection);

        return $this;
    }

    public function getConnection(string $name = self::DEFAULT_CONNECTION): Connection
    {
        return $this->dbal->get($name);
    }

    protected function configTransformer(array $config): array
    {
        return ConfigTransformer::toDBAL($config);
    }
}
