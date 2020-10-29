<?php

namespace BoldBrush\Bread\Helper\Route;

class Builder
{
    protected $edit;

    protected $read;

    protected $pkColumn;

    public function __construct(?array $routes = null, ?string $pkColumn = null)
    {
        if (isset($routes['edit'])) {
            $this->setEditRoute($routes['edit']);
        }

        if (isset($routes['read'])) {
            $this->setReadRoute($routes['read']);
        }

        $this->pkColumn = $pkColumn;
    }

    public function setEditRoute(string $edit): self
    {
        $this->edit = $edit;

        return $this;
    }

    public function setReadRoute(string $read): self
    {
        $this->read = $read;

        return $this;
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

    public function hasEditRoute()
    {
        return boolval($this->edit);
    }

    public function hasReadRoute()
    {
        return boolval($this->read);
    }

    public function hasActionRoutes(): bool
    {
        return $this->hasEditRoute() || $this->hasReadRoute();
    }
}
