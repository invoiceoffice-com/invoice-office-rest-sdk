<?php

namespace spec\Invoiceoffice\RestSdk\Resources;

use Invoiceoffice\RestSdk\Http\Client;
use Invoiceoffice\RestSdk\Tests\Helpers\SendsRequests;
use PhpSpec\ObjectBehavior;

class CompaniesSpec extends ObjectBehavior
{
    use SendsRequests;

    public function let(Client $client)
    {
        $this->beConstructedWith('demo', $client);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Invoiceoffice\RestSdk\Resources\Companies');
    }
}
