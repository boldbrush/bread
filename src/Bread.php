<?php

declare(strict_types=1);

namespace BoldBrush\Bread;

use BoldBrush\Bread\Config\Initializer;
use BoldBrush\Bread\Exception;
use BoldBrush\Bread\Field\Config\Config;
use BoldBrush\Bread\Field\Container;
use BoldBrush\Bread\Helper\Route\Builder;
use BoldBrush\Bread\Model\Metadata;
use BoldBrush\Bread\Page\Page;
use BoldBrush\Bread\View;
use BoldBrush\Bread\System\Database\ConnectionManager;
use Doctrine\DBAL\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Bread
{
    /** @var string|Model $model */
    protected $model = null;

    /** @var Metadata $modelMetadata */
    protected $modelMetadata = null;

    /** @var ConnectionManager $connectionManager */
    protected $connectionManager;

    /** @var int $perPage */
    protected $perPage = 5;

    /** @var callable $query */
    protected $query;

    /**  @var array $select */
    protected $select;

    /** @var array $links */
    protected $links = [];

    /** @var Page $page */
    protected $page;

    /** @var Container $fields */
    protected $fields;

    /** @var string $layout */
    protected $layout;

    /** @var string $view */
    protected $view;

    /**
     * @param array $config
     *
     * @todo Describe `$config` options.
     */
    public function __construct(?array $config = null)
    {
        (new Initializer($config, $this))->init();

        $this->page = new Page();
        $this->setFields(new Container());
    }

    /*
    |--------------------------------------------------------------------------
    | The BREAD Methods
    |--------------------------------------------------------------------------
    |
    | Here are each one of the BREAD methods.
    |
    */

    /**
     * Render the browse view.
     *
     * This will return the html for the browse/list view.
     */
    public function browse(): string
    {
        $this->checkIfModelHasBeenSetup();

        $model = $this->model;
        $query = $this->getQueryCallable();

        if (is_callable($query)) {
            $query = $query($model, DB::table($this->modelMetadata->getTable()), DB::query());
            $paginator = $query->paginate();
        } elseif (is_array($this->select) && count($this->select) > 0) {
            $paginator = $model::select($this->select)->paginate();
        } else {
            $paginator = $model::paginate();
        }

        return (new View\Browser($this, $paginator))->render();
    }

    /**
     * Render the read view.
     *
     * This will return the html for the read/details view.
     */
    public function read(?int $id = null): string
    {
        $this->checkIfModelHasBeenSetup();
        $this->checkIfIdentifierCanBeNull($id);

        throw new \Exception("This method (" . __METHOD__ . ") needs to be implemented", 500);
    }

    /**
     * Render the edit view.
     *
     * This will return the html for the edit form view.
     */
    public function edit(?int $id = null): string
    {
        $this->checkIfModelHasBeenSetup();
        $this->checkIfIdentifierCanBeNull($id);

        throw new \Exception("This method (" . __METHOD__ . ") needs to be implemented", 500);
    }

    /**
     * Render the add view.
     *
     * This will return the html for the add for view.
     */
    public function add(): string
    {
        $this->checkIfModelHasBeenSetup();

        throw new \Exception("This method (" . __METHOD__ . ") needs to be implemented", 500);
    }

    /**
     * Delete a record.
     *
     * This will delete a record.
     */
    public function delete(?int $id = null)
    {
        $this->checkIfModelHasBeenSetup();
        $this->checkIfIdentifierCanBeNull($id);

        throw new \Exception("This method (" . __METHOD__ . ") needs to be implemented", 500);
    }

    /*
    |--------------------------------------------------------------------------
    | The DSL Methods
    |--------------------------------------------------------------------------
    |
    | All the DSL methods that help us configure the expected output.
    |
    */

    /**
     * Set Eloquent model.
     *
     * @param string|Model Eloquent model
     *
     * @return self
     */
    public function model($model): self
    {
        $this->modelMetadata = new Metadata($model);

        $this->setConnectionConfigForModel();

        $this->model = $this->modelMetadata->getModelClass();

        return $this;
    }

    public function configureFields(string $for = Container::GENERAL): Config
    {
        return new Config($for, $this->getFields()->for($for), $this);
    }

    /**
     * Add an action link.
     *
     * Examples:
     *
     * ```php
     * <?php
     * $bread->actionLink('edit', '/users/:id/edit');
     * $bread->actionLink('edit', route('users.edit', ['id' => ':id']));
     * ```
     *
     * @see Markdown
     *
     * @param string $action The name of the action.
     * @param string $template The template route that the
     * `BoldBrush\Bread\Helper\Route\Builder` will use to generate the actual route.
     *
     * @return self
     */
    public function actionLink(string $action, string $template): self
    {
        $this->links[$action] = $template;

        return $this;
    }

    /**
     * Set the number of records the ORM will retrieve to present to the view.
     *
     * @param int $perPage
     *
     * @return self
     */
    public function perPage(int $perPage): self
    {
        $this->perPage = $perPage;

        return $this;
    }

    /**
     * Set the callable responsible to retrieve the Model(s).
     *
     * This methods has a higher priority when retrieving data from DB.
     *
     * @param callable $query
     *
     * @return self
     */
    public function query(callable $query): self
    {
        $this->query = $query;

        return $this;
    }

    /**
     * Set the field that need to be retrieve from the DB.
     *
     * This methods has a lower priority than `self::query(callable $query)`
     * when retrieving data from DB.
     *
     * @see self::query(callable $query)
     *
     * @param array $select
     *
     * @return self
     */
    public function select(array $select): self
    {
        $this->select = $select;

        return $this;
    }

    public function title($title): self
    {
        $this->page->setTitle($title);

        return $this;
    }

    public function layout(string $layout): self
    {
        $this->layout = $layout;

        return $this;
    }

    public function view(string $view): self
    {
        $this->view = $view;

        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | The Internal Methods
    |--------------------------------------------------------------------------
    |
    | All the Internal methods that run behind the scenes.
    |
    */

    public function save(?int $id = null, ?array $data = [])
    {
        $this->checkIfModelHasBeenSetup();

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

        if (isset($data['_token'])) {
            unset($data['_token']);
        }

        /**
         * Don't save primary key
         */
        if (isset($data[$pk])) {
            unset($data[$pk]);
        }

        $sm = $this
            ->getConnectionConfigForModel()
            ->getSchemaManager();

        $platform = $sm->getDatabasePlatform();

        $columns = $sm->listTableColumns($this->modelData->getTable());

        foreach ($columns as $column) {
            if (isset($data[$column->getName()])) {
                $data[$column->getName()] = $column->getType()
                    ->convertToPHPValue($data[$column->getName()], $platform);
            }
        }

        foreach ($data as $attribute => $value) {
            $model->$attribute = $value;
        }

        $model->save($data);

        $routeBuilder = new Builder($this->actionLinks(), $pk);

        if ($routeBuilder->hasBrowseRoute()) {
            return redirect($routeBuilder->browse());
        }

        return back();
    }

    public function getFields(): Container
    {
        return $this->fields;
    }

    public function getTitle(): ?string
    {
        return $this->page->title();
    }

    public function getLayout(): ?string
    {
        return $this->layout;
    }

    public function getView(): ?string
    {
        return $this->view;
    }

    public function actionLinks(): ?array
    {
        return $this->links;
    }

    public function getModelClass(): string
    {
        return $this->model;
    }

    public function getModelMetadata(): Metadata
    {
        return $this->modelMetadata;
    }

    /**
     * Return the callable that will retrieve the Model(s)
     *
     * @return callable $query;
     */
    protected function getQueryCallable(): ?callable
    {
        return $this->query;
    }

    public function setFields(Container $fields): self
    {
        $this->fields = $fields;

        return $this;
    }

    public function getConnectionConfigForModel(): Connection
    {
        if ($this->connectionManager === null) {
            $this->connectionManager = ConnectionManager::instance();
        }

        $connectionName = $this->getModelMetadata()->getConnectionName();

        if (empty($connectionName)) {
            $connectionName = config('database.' . ConnectionManager::DEFAULT_CONNECTION);
        }

        return $this->connectionManager->getConnection($connectionName);
    }

    protected function setConnectionConfigForModel(): void
    {
        $connectionName = $this->getModelMetadata()->getConnectionName();

        $connections = config('database.connections');

        if (empty($connectionName)) {
            $connectionName = config('database.' . ConnectionManager::DEFAULT_CONNECTION);
        }

        $this->connectionManager = ConnectionManager::instance()
            ->addConnection($connections[$connectionName], $connectionName);
    }

    /**
     * Check if model has been setup
     *
     * @throws Exception\NoModelHasBeenSetup
     */
    protected function checkIfModelHasBeenSetup(): void
    {
        if ($this->model === null) {
            throw new Exception\NoModelHasBeenSetup();
        }
    }

    /**
     * Check if identifier can be null.
     *
     * @throws Exception\IdentifierCannotBeNull
     */
    protected function checkIfIdentifierCanBeNull(?int $id): void
    {
        $query = $this->getQueryCallable();

        if (!is_callable($query) && $id === null) {
            throw new Exception\IdentifierCannotBeNull();
        }
    }
}
