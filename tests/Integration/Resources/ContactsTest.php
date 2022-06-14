<?php

namespace Invoiceoffice\RestSdk\Tests\Integration\Resources;

use Invoiceoffice\RestSdk\Resources\Contacts;
use Invoiceoffice\RestSdk\Tests\Integration\Abstraction\EntityTestCase;

/**
 * @internal
 * @coversNothing
 */
class ContactsTest extends EntityTestCase
{
    /**
     * @var \Invoiceoffice\RestSdk\Resources\Contacts
     */
    protected mixed $resource;

    /**
     * @var \Invoiceoffice\RestSdk\Resources\Contacts::class
     */
    protected $resourceClass = Contacts::class;

    /** @test */
    public function allWithNoParams()
    {
        $response = $this->resource->all();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertGreaterThanOrEqual(1, count($response->contacts));
    }

    /** @test */
    public function allWithParams()
    {
        $response = $this->resource->all([
            'property' => ['firstname', 'lastname'],
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertGreaterThanOrEqual(1, count($response->contacts));
    }

    /** @test */
    public function allWithParamsAndArrayAccess()
    {
        $response = $this->resource->all([
            'property' => ['firstname', 'lastname'],
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertGreaterThanOrEqual(1, count($response->contacts));
    }

    /** @test */
    public function create()
    {
        $this->assertEquals(200, $this->entity->getStatusCode());
    }

    /** @test */
    public function update()
    {
        $response = $this->resource->update($this->entity->vid, [
            ['property' => 'firstname', 'value' => 'joe'],
            ['property' => 'lastname', 'value' => 'user'],
        ]);

        $this->assertEquals(204, $response->getStatusCode());
    }

    /** @test */
    public function updateByEmail()
    {
        $response = $this->resource->updateByEmail($this->entity->properties->email->value, [
            ['property' => 'firstname', 'value' => 'joe'],
            ['property' => 'lastname', 'value' => 'user'],
        ]);

        $this->assertEquals(204, $response->getStatusCode());
    }

    /** @test */
    public function createOrUpdate()
    {
        sleep(1);
        $response = $this->resource->createOrUpdate($this->entity->properties->email->value, [
            ['property' => 'firstname', 'value' => 'joe'],
            ['property' => 'lastname', 'value' => 'user'],
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function delete()
    {
        $response = $this->deleteEntity();

        $this->assertEquals(200, $response->getStatusCode());

        $this->entity = null;
    }

    /** @test */
    public function getById()
    {
        $response = $this->resource->getById($this->entity->vid);

        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function getByEmail()
    {
        $response = $this->resource->getByEmail($this->entity->properties->email->value);

        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function search()
    {
        $response = $this->resource->search('hub', ['count' => 2]);

        $this->assertEquals(200, $response->getStatusCode());
    }

    protected function createEntity()
    {
        return $this->resource->create([
            ['property' => 'email',     'value' => 'rw_test' . uniqid('', true) . '@invoiceoffice.com'],
            ['property' => 'firstname', 'value' => 'joe'],
            ['property' => 'lastname',  'value' => 'user'],
        ]);
    }

    protected function deleteEntity()
    {
        return $this->resource->delete($this->entity->vid);
    }
}
