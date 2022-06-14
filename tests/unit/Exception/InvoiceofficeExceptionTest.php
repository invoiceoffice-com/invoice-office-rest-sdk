<?php

declare(strict_types=1);

namespace Invoiceoffice\RestSdk\Tests\unit\Exception;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;
use Invoiceoffice\RestSdk\Exceptions\BadRequest;
use Invoiceoffice\RestSdk\Exceptions\InvoiceofficeException;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class InvoiceofficeExceptionTest extends TestCase
{
    public const EXAMPLE_TOKEN = '8907e60c-600d-4af8-a987-191c104a215c';

    /** @test */
    public function createExceptionFromGuzzleRequestException(): void
    {
        $e = new RequestException('Request Failed', new Request('GET', 'https://app.invoiceoffice.com/api/x'));

        $exception = InvoiceofficeException::create($e);

        $this->assertInstanceOf(InvoiceofficeException::class, $exception);
        $this->assertNull($exception->getResponse());
    }

    /** @test */
    public function createExceptionFromGuzzleClientException(): void
    {
        $e = ClientException::create(
            new Request('GET', sprintf('https://app.invoiceoffice.com/api/deals/v1/deal/12345?access_token=%s', static::EXAMPLE_TOKEN)),
            new Response(400, [], Utils::streamFor('{"status":"error","message":"xyz"}'))
        );

        $exception = BadRequest::create($e);

        $this->assertInstanceOf(BadRequest::class, $exception);
        $this->assertStringNotContainsString(static::EXAMPLE_TOKEN, $exception->getMessage());
        $this->assertSame($e->getResponse(), $exception->getResponse());
        $this->assertSame('Client error: `GET https://app.invoiceoffice.com/api/deals/v1/deal/12345?access_token=***` resulted in a `400 Bad Request` response:
{"status":"error","message":"xyz"}
', $exception->getMessage());
    }

    /** @test */
    public function createExceptionFromGuzzleServerException(): void
    {
        $e = ServerException::create(
            new Request('GET', sprintf('https://app.invoiceoffice.com/api/deals/v1/deal/12345?hapikey=%s', static::EXAMPLE_TOKEN)),
            new Response(502, [], Utils::streamFor('<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en-US"> <![endif]-->')
            )
        );

        $exception = InvoiceofficeException::create($e);

        $this->assertInstanceOf(InvoiceofficeException::class, $exception);
        $this->assertStringNotContainsString(static::EXAMPLE_TOKEN, $exception->getMessage());
        $this->assertSame($e->getResponse(), $exception->getResponse());
        $this->assertSame('Server error: `GET https://app.invoiceoffice.com/api/deals/v1/deal/12345?hapikey=***` resulted in a `502 Bad Gateway` response:
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en-US"> <![endif]-->
', $exception->getMessage());
    }
}
