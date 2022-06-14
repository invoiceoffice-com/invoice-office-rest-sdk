<?php

namespace spec\Invoiceoffice\RestSdk\Resources;

use Invoiceoffice\RestSdk\Http\Client;
use PhpSpec\ObjectBehavior;

class ContactsSpec extends ObjectBehavior
{
    private $client;

    private $apiKey = 'demo';

    private $baseUrl = 'https://app.invoiceoffice.com/api';

    private $headers = [
        'User-Agent' => 'Invoiceoffice_RestSdk_PHP/0.9 (https://github.com/invoiceoffice-com/invoice-office-rest-sdk)',
    ];

    public function let(Client $client)
    {
        $this->beConstructedWith('demo', $client);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Invoiceoffice\RestSdk\Resources\Contacts');
    }

    private function getUrl($endpoint)
    {
        return $this->baseUrl . $endpoint . '?hapikey=' . $this->apiKey;
    }
}
