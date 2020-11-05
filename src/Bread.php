<?php

namespace BoldBrush\Bread;

use BoldBrush\Bread\Model\Data;
use BoldBrush\Bread\Field\Factory;
use BoldBrush\Bread\Exception;
use BoldBrush\Bread\View;
use BoldBrush\Bread\System\Database\ConnectionManager;
use Doctrine\DBAL\Connection;
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
     * @var Field[] $readFields
     */
    protected $readFields = [];

    /**
     * @var int $perPage
     */
    protected $perPage = 5;

    /**
     * @var callable $query
     */
    protected $query;

    /**
     * @var array $select
     */
    protected $select;

    /**
     * @var array $links
     */
    protected $links;

    /**
     * @var string $title
     */
    protected $title;

    /**
     * @var string $layout
     */
    protected $layout;

    /**
     * @var string $view
     */
    protected $view;

    public function __construct(?array $config = null)
    {
    }

    public function browse(): string
    {
        if ($this->model === null) {
            throw new Exception\NoModelHasBeenSetup();
        }

        $model = $this->model;
        $query = $this->getQueryCallable();

        if (is_callable($query)) {
            $query = $query($model, DB::table($this->modelData->getTable()), DB::query());
            $paginator = $query->paginate();
        } elseif (is_array($this->select) && count($this->select) > 0) {
            $paginator = $model::select($this->select)->paginate();
        } else {
            $paginator = $model::paginate();
        }

        return (new View\Browser($this, $paginator))->render();
    }

    public function read(?int $id = null): string
    {
        if ($this->model === null) {
            throw new Exception\NoModelHasBeenSetup();
        }

        $model = $this->model;
        $pk = $this->modelData->getPrimaryKeyName();
        $query = $this->getQueryCallable();

        if (!is_callable($query) && $id === null) {
            throw new Exception\IdentifierCannotBeNull();
        }

        if (is_callable($query)) {
            $query = $query($model, DB::table($this->modelData->getTable()), DB::query());
            $model = $query->first();
        } elseif (is_array($this->select) && count($this->select) > 0) {
            $model = $model::select($this->select)->where($pk, $id)->first();
        } else {
            $model = $model::find($id);
        }

        return (new View\Reader($this, $model))->render();
    }

    public function edit(?int $id = null): string
    {
        if ($this->model === null) {
            throw new Exception\NoModelHasBeenSetup();
        }

        $model = $this->model;
        $pk = $this->modelData->getPrimaryKeyName();
        $query = $this->getQueryCallable();

        if (!is_callable($query) && $id === null) {
            throw new Exception\IdentifierCannotBeNull();
        }

        if (is_callable($query)) {
            $query = $query($model, DB::table($this->modelData->getTable()), DB::query());
            $model = $query->first();
        } elseif (is_array($this->select) && count($this->select) > 0) {
            $model = $model::select($this->select)->where($pk, $id)->first();
        } else {
            $model = $model::find($id);
        }

        return (new View\Editor($this, $model))->render();
    }

    public function add()
    {
        if ($this->model === null) {
            throw new Exception\NoModelHasBeenSetup();
        }
    }

    public function delete()
    {
        if ($this->model === null) {
            throw new Exception\NoModelHasBeenSetup();
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

    public function actionLink(string $action, string $template): self
    {
        $this->links[$action] = $template;

        return $this;
    }

    public function actionLinks(): ?array
    {
        return $this->links;
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

        $for = $for . 'Fields';
        if ($for !== null && $for !== 'Fields') {
            if (is_array($this->$for)) {
                $fields = $this->$for;
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

    public function getTitle()
    {
        return $this->title;
    }

    public function title($title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getLayout(): ?string
    {
        return $this->layout;
    }

    public function layout(string $layout): self
    {
        $this->layout = $layout;

        return $this;
    }

    public function getView(): ?string
    {
        return $this->view;
    }

    public function view(string $view): self
    {
        $this->view = $view;

        return $this;
    }

    public function getConnectionConfigForModel(): Connection
    {
        if ($this->connectionManager === null) {
            $this->connectionManager = ConnectionManager::instance();
        }

        $connectionName = $this->modelData->getConnectionName();

        if (empty($connectionName)) {
            $connectionName = config('database.' . ConnectionManager::DEFAULT_CONNECTION);
        }

        return $this->connectionManager->getConnection($connectionName);
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
