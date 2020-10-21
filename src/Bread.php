<?php

namespace BoldBrush\Bread;

use BoldBrush\Bread\Model\Data;
use BoldBrush\Bread\Field\Factory;
use BoldBrush\Bread\Exception\Browse;
use BoldBrush\Bread\View\Browser;
use BoldBrush\Bread\System\Database\ConnectionManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Bread
{
    /**
     * @var Model $model
     */
    protected $model;

    /**
     * @var Data $modelData
     */
    protected $modelData;

    /**
     * @var ConnectionManager $connectionManager
     */
    protected $connectionManager;

    /**
     * @var Field[] $fieldsForAll
     */
    protected $fieldsForAll = [];

    /**
     * @var Field[] $browseFields
     */
    protected $browseFields = [];

    /**
     * @var Field[] $editFields
     */
    protected $editFields = [];

    /**
     * @var int $perPage
     */
    protected $perPage = 5;

    /**
     * @var callable $query
     */
    protected $query;

    /**
     * @var callable $select
     */
    protected $select;

    public function __construct(?array $config = null)
    {
    }

    public function browse(): string
    {
        if ($this->model === null) {
            throw new Browse\NoModelHasBeenSetup();
        }

        $model = $this->model;
        $query = $this->getQueryCallable();

        if (is_callable($query)) {
            $query = $query($model, DB::table($this->modelData->getTable()), DB::query());
            $paginator = $query->paginate($this->perPage);
        } elseif (is_array($this->select) && count($this->select) > 0) {
            $paginator = $model::select($this->select)->paginate($this->perPage);
        } else {
            $paginator = $model::paginate($this->perPage);
        }

        $browser = new Browser($this, $paginator);

        $view = strval(view('bread::browse', ['browser' => $browser]));

        return $view;
    }

    public function read()
    {
        if ($this->model === null) {
            throw new Browse\NoModelHasBeenSetup();
        }
    }

    public function edit()
    {
        if ($this->model === null) {
            throw new Browse\NoModelHasBeenSetup();
        }
    }

    public function add()
    {
        if ($this->model === null) {
            throw new Browse\NoModelHasBeenSetup();
        }
    }

    public function delete()
    {
        if ($this->model === null) {
            throw new Browse\NoModelHasBeenSetup();
        }
    }

    /**
     * Set Eloquent model.
     *
     * @param string|Model Eloquent model
     *
     * @return self
     */
    public function model($model): self
    {
        $this->modelData = new Data($model);

        $this->setConnectionConfigForModel();

        $this->model = $this->modelData->getModelClass();

        return $this;
    }

    public function getModelClass(): string
    {
        return $this->model;
    }

    public function getModelData(): Data
    {
        return $this->modelData;
    }

    public function fields(array $fields = [], ?string $for = null): self
    {
        $fieldsArray = [];

        $for = $for . 'Fields';

        foreach ($fields as $name => $field) {
            if (is_array($field)) {
                $data = $field;
                $field = $name;
            } elseif (is_string($field)) {
                $data = [];
            }


            $fieldsArray[$field] = Factory::forData($data, $field);
        }

        if ($for !== null && $for !== 'Fields') {
            $this->$for =  array_merge($this->$for, $fieldsArray);
        }

        $this->fieldsForAll = array_merge($this->fieldsForAll, $fieldsArray);

        return $this;
    }

    public function getFieldsFor(?string $for = null): array
    {
        $fields = $this->fieldsForAll;
        if ($for !== null) {
            if (is_array($this->{$for . 'Fields'})) {
                $fields = $this->{$for . 'Fields'};
            }
        }

        return $fields;
    }

    public function perPage(int $perPage): self
    {
        $this->perPage = $perPage;

        return $this;
    }

    public function query(callable $query): self
    {
        $this->query = $query;

        return $this;
    }

    public function select(array $select): self
    {
        $this->select = $select;

        return $this;
    }

    protected function getQueryCallable(): ?callable
    {
        return $this->query;
    }

    protected function setConnectionConfigForModel(): void
    {
        $connectionName = $this->modelData->getConnectionName();

        $connections = config('database.connections');

        if (empty($connectionName)) {
            $connectionName = config('database.' . ConnectionManager::DEFAULT_CONNECTION);
        }

        $this->connectionManager = ConnectionManager::instance()
            ->addConnection($connections[$connectionName], $connectionName);
    }
}
