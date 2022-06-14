<?php

namespace Invoiceoffice\RestSdk\Resources;

use DateTime;
use Invoiceoffice\RestSdk\Http\Client;

abstract class Resource
{
    protected Client $client;
    protected string $resource;

    /**
     * Making a good old resource.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get all products.
     *
     * @see https://developers.invoiceoffice.com/docs/methods/products/get-all-products
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Invoiceoffice\RestSdk\Exceptions\BadRequest
     * @throws \Invoiceoffice\RestSdk\Exceptions\InvoiceofficeException
     */
    public function all(array $params = []): \Invoiceoffice\RestSdk\Http\Response
    {
        return $this->client->request('get', $this->resource, [], build_query_string($params));
    }

    /**
     * Get a product by ID.
     *
     * @see https://developers.invoiceoffice.com/docs/methods/products/get_product_by_id
     *
     * @return \Invoiceoffice\RestSdk\Http\Response
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Invoiceoffice\RestSdk\Exceptions\BadRequest
     * @throws \Invoiceoffice\RestSdk\Exceptions\InvoiceofficeException
     */
    public function getById(string $id, array $params = [])
    {
        return $this->client->request('get', $this->resource . "/{$id}", [], build_query_string($params));
    }

    /**
     * Create a product.
     *
     * @see https://developers.invoiceoffice.com/docs/methods/products/create-product
     *
     * @return \Invoiceoffice\RestSdk\Http\Response
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Invoiceoffice\RestSdk\Exceptions\BadRequest
     * @throws \Invoiceoffice\RestSdk\Exceptions\InvoiceofficeException
     */
    public function create(array $properties)
    {
        return $this->client->request('post', $this->resource, ['json' => $properties]);
    }

    /**
     * Update a product.
     *
     * @see https://developers.invoiceoffice.com/docs/methods/products/update-products
     *
     * @return \Invoiceoffice\RestSdk\Http\Response
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Invoiceoffice\RestSdk\Exceptions\BadRequest
     * @throws \Invoiceoffice\RestSdk\Exceptions\InvoiceofficeException
     */
    public function update(string $id, array $properties)
    {
        return $this->client->request('put', $this->resource . "/{$id}", ['json' => $properties]);
    }

    /**
     * Delete a product.
     *
     * @see https://developers.invoiceoffice.com/docs/methods/products/delete-product
     *
     * @return \Invoiceoffice\RestSdk\Http\Response
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Invoiceoffice\RestSdk\Exceptions\BadRequest
     * @throws \Invoiceoffice\RestSdk\Exceptions\InvoiceofficeException
     */
    public function delete(string $id)
    {
        return $this->client->request('delete', $this->resource . "/{$id}");
    }

    /**
     * Convert a time, DateTime, or string to a millisecond timestamp.
     */
    protected function timestamp(DateTime|int|null $time): ?int
    {
        return ms_timestamp($time);
    }
}
