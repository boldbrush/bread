<?php

declare(strict_types=1);

namespace BoldBrush\Bread\Helper\Route;

class Builder
{
    protected $browse;

    protected $read;

    protected $edit;

    protected $add;

    protected $delete;

    protected $save;

    protected $pkColumn;

    public function __construct(?array $routes = null, ?string $pkColumn = null)
    {
        if (isset($routes['browse'])) {
            $this->setBrowseRoute($routes['browse']);
        }

        if (isset($routes['read'])) {
            $this->setReadRoute($routes['read']);
        }

        if (isset($routes['edit'])) {
            $this->setEditRoute($routes['edit']);
        }

        if (isset($routes['add'])) {
            $this->setAddRoute($routes['add']);
        }

        if (isset($routes['delete'])) {
            $this->setDeleteRoute($routes['delete']);
        }

        if (isset($routes['save'])) {
            $this->setSaveRoute($routes['save']);
        }

        $this->pkColumn = $pkColumn;
    }

    public function setBrowseRoute(string $browse): self
    {
        $this->browse = $browse;

        return $this;
    }

    public function setReadRoute(string $read): self
    {
        $this->read = $read;

        return $this;
    }

    public function setEditRoute(string $edit): self
    {
        $this->edit = $edit;

        return $this;
    }

    public function setAddRoute(string $add): self
    {
        $this->add = $add;

        return $this;
    }

    public function setDeleteRoute(string $delete): self
    {
        $this->delete = $delete;

        return $this;
    }

    public function setSaveRoute(string $save): self
    {
        $this->save = $save;

        return $this;
    }

    public function browse(): string
    {
        return $this->browse;
    }

    public function edit(object $item): string
    {
        $id = $item->{$this->pkColumn};

        return str_replace(':id', $id, $this->edit);
    }

    public function read(object $item): string
    {
        $id = $item->{$this->pkColumn};

        return str_replace(':id', $id, $this->read);
    }

    public function add(): string
    {
        return $this->add;
    }

    public function delete(object $item): string
    {
        $id = $item->{$this->pkColumn};

        return str_replace(':id', $id, $this->delete);
    }

    public function save(?object $item = null): string
    {
        if ($item) {
            $id = $item->{$this->pkColumn};

            return str_replace(':id', strval($id), strval($this->save));
        }

        return $this->save;
    }

    public function hasBrowseRoute()
    {
        return boolval($this->browse);
    }

    public function hasReadRoute()
    {
        return boolval($this->read);
    }

    public function hasEditRoute()
    {
        return boolval($this->edit);
    }

    public function hasAddRoute()
    {
        return boolval($this->add);
    }

    public function hasDeleteRoute()
    {
        return boolval($this->delete);
    }

    public function hasSaveRoute()
    {
        return boolval($this->delete);
    }

    public function hasActionRoutes(): bool
    {
        return $this->hasBrowseRoute() ||
            $this->hasReadRoute() ||
            $this->hasEditRoute() ||
            $this->hasAddRoute() ||
            $this->hasDeleteRoute() ||
            $this->hasSaveRoute();
    }
}
