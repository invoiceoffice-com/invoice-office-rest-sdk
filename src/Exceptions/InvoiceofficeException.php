<?php

namespace Invoiceoffice\RestSdk\Exceptions;

use Exception;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;

class InvoiceofficeException extends Exception
{
    protected ?Response $response;

    public function getResponse(): ?Response
    {
        return $this->response;
    }

    public static function create(RequestException $guzzleException): self
    {
        $e = new static(
            static::sanitizeResponseMessage($guzzleException->getMessage()),
            $guzzleException->getCode()
        );

        $e->response = $guzzleException->getResponse();

        return $e;
    }

    protected static function sanitizeResponseMessage(string $message): string
    {
        return preg_replace('/(apiKey|password)=[a-z0-9-]+/i', '$1=***', $message);
    }
}
