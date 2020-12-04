<?php

declare(strict_types=1);

namespace BoldBrush\Bread\Model;

use BoldBrush\Bread\Model\Exception\ModelDoesNotExistException;
use BoldBrush\Bread\Model\Exception\NotAnInstanceOfModelException;
use Illuminate\Database\Eloquent\Model;

class Metadata
{
    /**
     * @var string The database connection name.
     */
    private $connectionName;

    /**
     * @var string The table name.
     */
    private $table;

    /**
     * @var string The primary key field name.
     */
    private $pk;

    /**
     * @var Model The model class.
     */
    private $model;

    public function __construct($model)
    {
        if (is_string($model)) {
            if (!class_exists($model)) {
                throw new ModelDoesNotExistException();
            }
            $model = new $model();
        }

        if (!$model instanceof Model) {
            throw new NotAnInstanceOfModelException();
        }

        $this->table = $model->getTable();
        $this->connectionName = $model->getConnectionName();
        $this->pk = $model->getKeyName();
        $this->model = $model;
    }

    public function getTable(): string
    {
        return $this->table;
    }

    public function getConnectionName(): ?string
    {
        return $this->connectionName;
    }

    public function getPrimaryKeyName(): string
    {
        return $this->pk;
    }

    public function getModelClass(): string
    {
        return get_class($this->model);
    }
}
