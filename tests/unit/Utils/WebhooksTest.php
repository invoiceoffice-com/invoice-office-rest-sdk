<?php

namespace Invoiceoffice\RestSdk\Tests\Unit\Utils;

use Invoiceoffice\RestSdk\Utils;

/**
 * @internal
 * @coversNothing
 */
class WebhooksTest extends \PHPUnit\Framework\TestCase
{
    protected string $secret = 'clientSecret';
    protected string $requestBody = 'SomeBody';

    /** @test */
    public function validationInvoiceofficeSignatureValidData(): void
    {
        $result = Utils\Webhooks::isInvoiceofficeSignatureValid(
            hash('sha256', $this->secret . $this->requestBody),
            $this->secret,
            $this->requestBody
        );

        $this->assertEquals(true, $result);
    }

    /** @test */
    public function validationInvoiceofficeSignatureInvalidData(): void
    {
        $result = Utils\Webhooks::isInvoiceofficeSignatureValid(
            hash('sha256', $this->secret . $this->requestBody . '1'),
            $this->secret,
            $this->requestBody
        );

        $this->assertEquals(false, $result);
    }
}
