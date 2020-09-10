<?php

namespace BoldBrush\Bread\Test\Model;

use BoldBrush\Bread\Model\Data;
use BoldBrush\Bread\Model\Exception as ModelException;
use BoldBrush\Bread\Test\App\Model;
use Orchestra\Testbench\Dusk\TestCase;

class DataTest extends TestCase
{
    public function testInstance()
    {
        $data = new Data(Model\User::class);

        $this->assertInstanceOf(Data::class, $data);
    }

    public function testModelDoesNotExistException()
    {
        $this->expectException(ModelException\ModelDoesNotExistException::class);
        $data = new Data('NotExistentModel');
    }

    public function testNotAnInstanceOfModelException()
    {
        $this->expectException(ModelException\NotAnInstanceOfModelException::class);
        $data = new Data(Model\NotingElseMatters::class);
    }

    public function testGetTable()
    {
        $data = new Data(Model\User::class);

        $table = $data->getTable();

        $this->assertSame('users', $table);
    }

    public function testGetConnectionName()
    {
        $data = new Data(Model\User::class);

        $connectionName = $data->getConnectionName();

        $this->assertSame(null, $connectionName);
    }

    public function testGetPrimaryKeyName()
    {
        $data = new Data(Model\User::class);

        $id = $data->getPrimaryKeyName();

        $this->assertSame('id', $id);
    }
}
