<?php

namespace Invoiceoffice\RestSdk\Tests\Integration\Abstraction;

abstract class EntityTestCase extends DefaultTestCase
{
    protected ?\Invoiceoffice\RestSdk\Http\Response $entity;

    public function setUp(): void
    {
        parent::setUp();

        $this->entity = $this->createEntity();
        sleep(1);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        if (!empty($this->entity)) {
            $this->deleteEntity();
        }
    }

    abstract protected function createEntity();

    abstract protected function deleteEntity();
}
