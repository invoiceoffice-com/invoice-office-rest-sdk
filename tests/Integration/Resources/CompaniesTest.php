<?php

namespace Invoiceoffice\RestSdk\Tests\Integration\Resources;

use Invoiceoffice\RestSdk\Resources\Companies;
use Invoiceoffice\RestSdk\Resources\Contacts;
use Invoiceoffice\RestSdk\Tests\Integration\Abstraction\EntityTestCase;

/**
 * Class CompaniesTest.
 *
 * @group companies
 *
 * @internal
 * @coversNothing
 */
class CompaniesTest extends EntityTestCase
{
    /**
     * @var Companies
     */
    protected mixed $resource;

    /**
     * @var Companies::class
     */
    protected $resourceClass = Companies::class;

    /**
     * @var Contacts
     */
    protected $contactsResource;

    public function setUp(): void
    {
        $this->contactsResource = new Contacts($this->getClient());
        parent::setUp();
    }

    /** @test */
    public function create()
    {
        $this->assertEquals(200, $this->entity->getStatusCode());
        $this->assertEquals('A company name', $this->entity->properties->name->value);
        $this->assertEquals('A company description', $this->entity->properties->description->value);
        $this->assertEquals('example.com', $this->entity->properties->domain->value);
    }

    /** @test */
    public function update()
    {
        $companyDescription = 'A far better description than before';
        $properties = [
            'name'  => 'description',
            'value' => $companyDescription,
        ];

        $response = $this->resource->update($this->entity->companyId, $properties);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($this->entity->companyId, $response->companyId);
        $this->assertEquals($companyDescription, $response->properties->description->value);
    }

    /** @test */
    public function delete()
    {
        $response = $this->deleteEntity();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($this->entity->companyId, $response->companyId);
        $this->assertTrue($response['deleted']);

        $this->entity = null;
    }

    /** @test */
    public function getAll()
    {
        $response = $this->resource->all();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertGreaterThan(0, count($response->data->companies));
    }

    /** @test */
    public function getById()
    {
        $response = $this->resource->getById($this->entity->companyId);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($this->entity->companyId, $response->companyId);
    }

    /** @test */
    public function getByIdWithVersions()
    {
        // Force a change to the description
        $newDescription = 'Better descriptions are not easy to create.';
        $properties = [
            'name'  => 'description',
            'value' => $newDescription,
        ];
        $response = $this->resource->update($this->entity->companyId, $properties);

        // Get multiple versions for property
        $params = ['includePropertyVersions' => true];
        $response = $this->resource->getById($this->entity->companyId, $params);
        $this->assertCount(2, $response->getData()->properties->description->versions);
    }

    /**
     * Creates a new contact with the InvoiceofficeApi.
     *
     * @return \Invoiceoffice\RestSdk\Http\Response
     */
    protected function createContact()
    {
        $response = $this->contactsResource->create([
            ['property' => 'email', 'value' => 'rw_test' . uniqid('', true) . '@invoiceoffice.com'],
            ['property' => 'firstname', 'value' => 'joe'],
            ['property' => 'lastname', 'value' => 'user'],
        ]);

        sleep(1);

        return $response;
    }

    protected function createEntity()
    {
        return $this->resource->create([
            [
                'name'  => 'name',
                'value' => 'A company name',
            ],
            [
                'name'  => 'description',
                'value' => 'A company description',
            ],
            [
                'name'  => 'domain',
                'value' => 'example.com',
            ],
        ]);
    }

    protected function deleteEntity()
    {
        return $this->resource->delete($this->entity->companyId);
    }
}
