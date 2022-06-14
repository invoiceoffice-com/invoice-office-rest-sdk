<?php

namespace Invoiceoffice\RestSdk\Tests\Helpers;

trait SendsRequests
{
    protected $client;
    protected string $base_url = 'https://app.invoiceoffice.com/api';
    protected string $auth = '?hapikey=demo';
    protected string $api_key = 'demo';
    protected array $headers = [
        'User-Agent' => 'Invoiceoffice_RestSdk_PHP/1.0 (https://github.com/invoiceoffice-com/invoice-office-rest-sdk)',
    ];

    protected function buildQuery($query = []): string
    {
        return build_query_string($query);
    }

    protected function buildUrl($endpoint, $query_string = null): string
    {
        return $this->base_url . $endpoint . $this->auth . $query_string;
    }
}
