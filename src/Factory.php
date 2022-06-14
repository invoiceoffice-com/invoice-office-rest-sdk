<?php

namespace Invoiceoffice\RestSdk;

use Invoiceoffice\RestSdk\Http\Client;
use Invoiceoffice\RestSdk\Resources\Resource;

/**
 * Class Factory.
 *
 * @method \Invoiceoffice\RestSdk\Resources\Companies companies()
 * @method \Invoiceoffice\RestSdk\Resources\Contacts  contacts()
 * @method \Invoiceoffice\RestSdk\Resources\Products  products()
 */
class Factory
{
    protected ?Client $client;

    /**
     * @param array $config        An array of configurations. You need at least the 'key'.
     * @param array $clientOptions options to be sent with each request
     * @param bool  $wrapResponse  wrap request response in own Response object
     */
    public function __construct(array $config = [], Client $client = null, array $clientOptions = [], bool $wrapResponse = true)
    {
        if (is_null($client)) {
            $client = new Client($config, $clientOptions, $wrapResponse);
        }
        $this->client = $client;
    }

    /**
     * Return an instance of a Resource based on the method called.
     */
    public function __call(string $name, mixed $args): Resource
    {
        $resource = 'Invoiceoffice\\RestSdk\\Resources\\' . ucfirst($name);

        return new $resource($this->client, ...$args);
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    /**
     * Create an instance of the service with an API key.
     *
     * @param string|null $api_key       Invoiceoffice API key
     * @param Client|null $client        a Http client
     * @param array       $clientOptions options to be sent with each request
     * @param bool        $wrapResponse  wrap request response in own Response object
     *
     * @return static
     */
    public static function create(string $api_key = null, Client $client = null, array $clientOptions = [], bool $wrapResponse = true): self
    {
        return new static(['key' => $api_key], $client, $clientOptions, $wrapResponse);
    }

    /**
     * Create an instance of the service with an OAuth token.
     *
     * @param string      $token         Invoiceoffice oauth access token
     * @param Client|null $client        a Http client
     * @param array       $clientOptions options to be sent with each request
     * @param bool        $wrapResponse  wrap request response in own Response object
     *
     * @return static
     */
    public static function createWithToken(string $token, Client $client = null, array $clientOptions = [], bool $wrapResponse = true): self
    {
        return new static(['key' => $token, 'oauth' => true], $client, $clientOptions, $wrapResponse);
    }

    /**
     * Create an instance of the service with an OAuth2 token.
     *
     * @param string      $token         Invoiceoffice OAuth2 access token
     * @param Client|null $client        a Http client
     * @param array       $clientOptions options to be sent with each request
     * @param bool        $wrapResponse  wrap request response in own Response object
     *
     * @return static
     */
    public static function createWithOAuth2Token(string $token, Client $client = null, array $clientOptions = [], bool $wrapResponse = true): self
    {
        return new static(['key' => $token, 'oauth2' => true], $client, $clientOptions, $wrapResponse);
    }
}
