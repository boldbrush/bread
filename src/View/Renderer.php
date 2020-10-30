<?php

namespace BoldBrush\Bread\View;

use BoldBrush\Bread\Bread;
use BoldBrush\Bread\Helper\Route\Builder;
use Illuminate\Support\Str;

abstract class Renderer implements RendererInterface
{
    protected $bread;

    protected $table;

    protected $title;

    protected $pkColumn;

    /** @var Builder */
    protected $routeBuilder;

    protected $layout;

    protected $view;

    public function __construct(Bread $bread)
    {
        $this->bread = $bread;
        $this->table = $bread->getModelData()->getTable();
        $this->pkColumn = $bread->getModelData()->getPrimaryKeyName();
        $this->routeBuilder = new Builder($bread->actionLinks(), $this->pkColumn);
        $title = $bread->getTitle() ?? $bread->getModelData()->getTable();
        $this->setTitle($title)
            ->setLayout($bread->getLayout())
            ->setView($bread->getView());
    }

    abstract public function render(): string;

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function title(): string
    {
        $title = $this->title;

        if ($title === null) {
            $title = $this->table;
        }

        $title = Str::snake($title);
        $title = str_replace('-', ' ', $title);
        $title = str_replace('_', ' ', $title);

        return Str::title($title);
    }

    public function setLayout(?string $layout = null): self
    {
        $this->layout = $layout;

        return $this;
    }

    public function layout(): ?string
    {
        return $this->layout;
    }

    public function setView(?string $view = null): self
    {
        $this->view = $view;

        return $this;
    }

    public function view(): ?string
    {
        return $this->view;
    }
}
