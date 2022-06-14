<?php

namespace Invoiceoffice\RestSdk\Tests\Integration\Abstraction;

trait ProductData
{
    protected function getData(string $name = 'TEST product'): array
    {
        return [
            ['name' => 'name', 'value' => $name],
            ['name' => 'description', 'value' => 'A product description.'],
            ['name' => 'price',  'value' => 27.50],
        ];
    }
}
