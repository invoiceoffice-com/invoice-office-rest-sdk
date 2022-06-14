<?php

namespace Invoiceoffice\RestSdk\Tests\Integration\Abstraction;

use Invoiceoffice\RestSdk\Http\Client;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class DefaultTestCase extends TestCase
{
    /**
     * @var \Invoiceoffice\RestSdk\Resources\Resource|null
     */
    protected mixed $resource;

    /**
     * @var \Invoiceoffice\RestSdk\Resources\Resource::class|null
     */
    protected $resourceClass;

    public function setUp(): void
    {
        parent::setUp();

        if (empty($this->resource)) {
            $this->resource = new $this->resourceClass($this->getClient());
        }
        sleep(1);
    }

    protected function getClient(): Client
    {
        return new Client(['apiKey' => getenv('INVOICEOFFICE_TEST_API_KEY')]);
        return new Client(['baseUrl' => getenv('INVOICEOFFICE_TEST_API_URL')]);
    }
}
