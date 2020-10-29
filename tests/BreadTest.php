<?php

namespace BoldBrush\Bread\Test;

use BoldBrush\Bread\Bread;
use BoldBrush\Bread\Exception;
use BoldBrush\Bread\Field;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use BoldBrush\Bread\Test\App\Model;

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
        $bread = (new Bread())->model(Model\User::class);
        $path = '/edit/{{id}}';
        $bread->fields([
            'id',
            'email' => [
                'editable' => true,
                'visible' => true,
                'sortable' => false,
                'searchable' => true,
                'helpText' => "This is the help text for the title",
                'default' => "Default Title Value goes here",
                'type' => 'text',
                'customElementAfter' => function (EloquentModel $model, Field\Field $field) use ($path) {
                    $key = $model->getKeyName();
                    $path = str_replace('{{id}}', $model->$key, $path);
                    return '<a href="'. $path .'">Add Medium</a>';
                },
                'dataSource' => function () {
                    return ['guest', 'editor', 'admin'];
                },
            ],
            'username',
        ]);

        $this->assertInstanceOf(Bread::class, $bread);
    }

    public function testBrowseFields()
    {
        $bread = (new Bread())->model(Model\User::class);
        $path = '/edit/{{id}}';
        $bread->fields([
            'id',
            'email' => [
                'editable' => true,
                'visible' => true,
                'sortable' => false,
                'searchable' => true,
                'helpText' => "This is the help text for the title",
                'default' => "Default Title Value goes here",
                'type' => 'text',
                'customElementAfter' => function (EloquentModel $model, Field\Field $field) use ($path) {
                    $key = $model->getKeyName();
                    $path = str_replace('{{id}}', $model->$key, $path);
                    return '<a href="'. $path .'">Add Medium</a>';
                },
                'dataSource' => function () {
                    return ['guest', 'editor', 'admin'];
                },
            ],
            'username',
        ], 'browse');

        $this->assertInstanceOf(Bread::class, $bread);
    }

    public function testBrowseBrowseNoModelHasBeenSetup()
    {
        $this->expectException(Exception\NoModelHasBeenSetup::class);
        $view = (new Bread())->browse();
    }

    public function testBrowseBrowseNoData()
    {
        $bread = (new Bread())->model(Model\User::class)
            ->fields([
            'id' => [
                'visible' => false,
            ],
            'username',
        ], 'browse');

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
            ->fields([
            'id' => [
                'visible' => false,
            ],
            'username',
        ], 'browse');

        $view = $bread->browse();

        $this->assertInstanceOf(Bread::class, $bread);
        $this->assertStringContainsString('No data found!', $view);
    }

    public function testBrowseBrowseNoDataSelect()
    {
        $bread = (new Bread())->model(Model\User::class)
            ->select(['id', 'username'])
            ->fields([
            'id' => [
                'visible' => false,
            ],
            'username',
        ], 'browse');

        $view = $bread->browse();

        $this->assertInstanceOf(Bread::class, $bread);
        $this->assertStringContainsString('No data found!', $view);
    }

    public function testBrowseBrowseData()
    {
        $user = new Model\User();
        $user->name = 'Adro Rocker';
        $user->email = 'me@adro.rocks';
        $user->username = 'adro';
        $user->password = '123456';

        $user->save();

        $bread = (new Bread())->model(Model\User::class);

        $view = $bread->browse();

        $this->assertInstanceOf(Bread::class, $bread);
        $this->assertStringContainsString('Adro Rocker', $view);
        $this->assertStringContainsString('Id', $view);
    }
}
