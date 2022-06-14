<?php

namespace Invoiceoffice\RestSdk\Tests\Integration\Resources;

use Invoiceoffice\RestSdk\Resources\Products;
use Invoiceoffice\RestSdk\Tests\Integration\Abstraction\EntityTestCase;

/**
 * @internal
 * @coversNothing
 */
class ProductsTest extends EntityTestCase
{
    use \Invoiceoffice\RestSdk\Tests\Integration\Abstraction\ProductData;

    /**
     * @var \Invoiceoffice\RestSdk\Resources\Products
     */
    protected mixed $resource;

    /**
     * @var \Invoiceoffice\RestSdk\Resources\Products::class
     */
    protected $resourceClass = Products::class;

    /** @test */
    public function all()
    {
        $response = $this->resource->all();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertGreaterThanOrEqual(1, count($response->objects));
    }

    /** @test */
    public function getById()
    {
        $response = $this->resource->getById($this->entity->objectId);

        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function create()
    {
        $this->assertEquals(200, $this->entity->getStatusCode());
    }

    /** @test */
    public function update()
    {
        $response = $this->resource->update($this->entity->objectId, [
            ['name' => 'name', 'value' => 'An updated product'],
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function delete()
    {
        $response = $this->deleteEntity();

        $this->assertEquals(204, $response->getStatusCode());

        $this->entity = null;
    }

    protected function createEntity()
    {
        return $this->resource->create($this->getData());
    }

    protected function deleteEntity()
    {
        return $this->resource->delete($this->entity->objectId);
    }
}
