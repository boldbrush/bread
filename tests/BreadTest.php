<?php

namespace BoldBrush\Bread\Test;

use BoldBrush\Bread\Bread;
use BoldBrush\Bread\Exception;
use BoldBrush\Bread\Field;
use BoldBrush\Bread\Field\FieldContainer;
use BoldBrush\Bread\Test\App\Model;
use BoldBrush\Bread\Test\TestCase;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class BreadTest extends TestCase
{
    public function testInstance()
    {
        $bread = new Bread();

        $this->assertInstanceOf(Bread::class, $bread);
    }

    public function testModelInstance()
    {
        $bread = (new Bread())->model(Model\User::class);

        $this->assertInstanceOf(Bread::class, $bread);
    }

    public function testGeneralFields()
    {
        $path = '/edit/{{id}}';
        $bread = (new Bread())->model(Model\User::class)
            ->configureFields()
                ->field('id')
                ->field('email')
                    ->editable(false)
                    ->visible(true)
                    ->sortable(false)
                    ->searchable(true)
                    ->helpText('This is the help text for the email')
                    ->default("Default Email Value goes here")
                    ->type("email")
                    ->customElementAfter(function (EloquentModel $model, Field\Field $field) use ($path) {
                        $key = $model->getKeyName();
                        $path = str_replace('{{id}}', $model->$key, $path);
                        return '<a href="'. $path .'">Add Medium</a>';
                    })->dataSource(function () {
                        return ['guest', 'editor', 'admin'];
                    })
            ->bread();

        $this->assertSame(
            ['id', 'email'],
            array_keys($bread->getFields()->for()->toArray())
        );

        foreach ($bread->getFields()->for()->toArray() as $field) {
            $this->assertInstanceOf(Field\Field::class, $field);
        }
    }

    public function testBrowseFields()
    {
        $path = '/edit/{{id}}';
        $bread = (new Bread())->model(Model\User::class)
            ->configureFields(FieldContainer::BROWSE)
                ->field('id')
                ->field('email')
                    ->editable(false)
                    ->visible(true)
                    ->sortable(false)
                    ->searchable(true)
                    ->helpText('This is the help text for the email')
                    ->default("Default Email Value goes here")
                    ->type("email")
                    ->customElementAfter(function (EloquentModel $model, Field\Field $field) use ($path) {
                        $key = $model->getKeyName();
                        $path = str_replace('{{id}}', $model->$key, $path);
                        return '<a href="'. $path .'">Add Medium</a>';
                    })->dataSource(function () {
                        return ['guest', 'editor', 'admin'];
                    })
            ->bread();

        $this->assertSame(
            ['id', 'email'],
            array_keys($bread->getFields()->for(FieldContainer::BROWSE)->toArray())
        );

        foreach ($bread->getFields()->for(FieldContainer::BROWSE)->toArray() as $field) {
            $this->assertInstanceOf(Field\Field::class, $field);
        }
    }

    public function testBrowseBrowseNoModelHasBeenSetup()
    {
        $this->expectException(Exception\NoModelHasBeenSetup::class);
        $view = (new Bread())->browse();
    }

    public function testEditIdentifierCannotBeNull()
    {
        $this->expectException(Exception\IdentifierCannotBeNull::class);
        $view = (new Bread())->model(Model\User::class)->edit();
    }

    public function testEditIdentifierCannotBeNullPass()
    {
        $user = Model\User::factory()->make();
        $user->save();

        $view = (new Bread())->model(Model\User::class)
            ->actionLink('edit', '/edit/:id')
            ->edit($user->id);

        $this->assertStringContainsString('<form', $view);
    }

    public function testGetActionLinks()
    {
        $user = Model\User::factory()->make();

        $user->save();

        $bread = (new Bread())->model(Model\User::class)
            ->actionLink('edit', '/edit/:id');

        $this->assertSame(
            ['edit' => '/edit/:id'],
            $bread->actionLinks()
        );
    }

    public function testGetModelClass()
    {
        $bread = (new Bread())->model(Model\User::class);

        $this->assertTrue(is_string($bread->getModelClass()));
        $this->assertSame(Model\User::class, $bread->getModelClass());
    }

    public function testBrowseBrowseNoData()
    {
        $bread = (new Bread())->model(Model\User::class)
            ->configureFields(FieldContainer::BROWSE)
                ->field('id')
                    ->visible(false)
            ->bread();

        $view = $bread->browse();

        $this->assertInstanceOf(Bread::class, $bread);
        $this->assertStringContainsString('No data found!', $view);
    }

    public function testBrowseBrowseNoDataQuery()
    {
        $bread = (new Bread())->model(Model\User::class)
            ->query(function ($model, $queryBuilder, $rawQueryBuilder) {
                return  $model::select(['id', 'username'])->where('id', '>', 0);
            })
            ->configureFields(FieldContainer::BROWSE)
                ->field('id')
                    ->visible(false)
            ->bread();

        $view = $bread->browse();

        $this->assertInstanceOf(Bread::class, $bread);
        $this->assertStringContainsString('No data found!', $view);
    }

    public function testBrowseBrowseNoDataSelect()
    {
        $bread = (new Bread())->model(Model\User::class)
            ->select(['id', 'username'])
            ->configureFields(FieldContainer::BROWSE)
                ->field('id')
                    ->visible(false)
            ->bread();

        $view = $bread->browse();

        $this->assertInstanceOf(Bread::class, $bread);
        $this->assertStringContainsString('No data found!', $view);
    }

    public function testBrowseBrowseData()
    {
        $user = new Model\User();
        $user->name = 'Adro Rocker';
        $user->email = 'me@adro.rocks';
        $user->password = '123456';
        $user->save();

        $bread = (new Bread())->model(Model\User::class);

        $view = $bread->browse();

        $this->assertInstanceOf(Bread::class, $bread);
        $this->assertStringContainsString('Adro Rocker', $view);
        $this->assertStringContainsString('Id', $view);
    }

    public function testEditView()
    {
        $user = Model\User::factory()->make();
        $user->save();

        $view = (new Bread())
            ->model(Model\User::class)
            ->edit($user->id);

        $this->assertStringContainsString($user->name, $view);
    }

    public function testAddView()
    {
        $view = (new Bread())
            ->model(Model\User::class)
            ->add();

        $this->assertStringContainsString('<form', $view);
    }
}
