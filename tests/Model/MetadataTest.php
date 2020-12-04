<?php

namespace BoldBrush\Bread\Test\Model;

use BoldBrush\Bread\Model\Metadata;
use BoldBrush\Bread\Model\Exception as ModelException;
use BoldBrush\Bread\Test\App\Model;
use BoldBrush\Bread\Test\TestCase;

class MetadataTest extends TestCase
{
    public function testInstance()
    {
        $metadata = new Metadata(Model\User::class);

        $this->assertInstanceOf(Metadata::class, $metadata);
    }

    public function testModelDoesNotExistException()
    {
        $this->expectException(ModelException\ModelDoesNotExistException::class);
        $metadata = new Metadata('NotExistentModel');
    }

    public function testNotAnInstanceOfModelException()
    {
        $this->expectException(ModelException\NotAnInstanceOfModelException::class);
        $data = new Metadata(Model\NotingElseMatters::class);
    }

    public function testGetTable()
    {
        $metadata = new Metadata(Model\User::class);

        $table = $metadata->getTable();

        $this->assertSame('users', $table);
    }

    public function testGetConnectionName()
    {
        $metadata = new Metadata(Model\User::class);

        $connectionName = $metadata->getConnectionName();

        $this->assertSame(null, $connectionName);
    }

    public function testGetPrimaryKeyName()
    {
        $metadata = new Metadata(Model\User::class);

        $id = $metadata->getPrimaryKeyName();

        $this->assertSame('id', $id);
    }

    public function testGetModelClass()
    {
        $metadata = new Metadata(Model\User::class);

        $class = $metadata->getModelClass();

        $this->assertSame(Model\User::class, $class);
    }
}
