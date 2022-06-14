<?php

namespace Invoiceoffice\RestSdk\Http;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use Invoiceoffice\RestSdk\Exceptions\BadRequest;
use Invoiceoffice\RestSdk\Exceptions\InvalidArgument;
use Invoiceoffice\RestSdk\Exceptions\InvoiceofficeException;
use JsonException;
use Psr\Http\Message\ResponseInterface;

class Client
{
    public string $baseUrl = 'https://app.invoiceoffice.com/api';

    /** ["token", "oauth2"] */
    public ?string $authType = 'token';
    public ?string $token = null;
    public ?string $apiKey = null;

    public GuzzleClient $client;

    /**
     * Guzzle allows options into its request method. Prepare for some defaults.
     */
    protected array $clientOptions = [];

    /**
     * if set to false, no Response object is created, but the one from Guzzle is directly returned
     * comes in handy own error handling.
     */
    protected bool $wrapResponse = true;

    protected string $user_agent = 'Invoiceoffice_RestSdk_PHP/2.0.4 (https://github.com/invoiceoffice-com/invoice-office-rest-sdk)';

    /**
     * @param array $config        Configuration array
     * @param array $clientOptions options to be passed to Guzzle upon each request
     * @param bool  $wrapResponse  wrap request response in own Response object
     */
    public function __construct(array $config = [], array $clientOptions = [], bool $wrapResponse = true)
    {
        $this->client = new GuzzleClient();

        $this->clientOptions = $clientOptions;
        $this->wrapResponse = $wrapResponse;

        $this->apiKey = $config['apiKey'] ?? getenv('INVOICEOFFICE_API_KEY');

        if (isset($config['baseUrl']) && !empty($config['baseUrl'])) {
            $this->baseUrl = $config['baseUrl'];
        }

        if (isset($config['authType']) && !empty($config['authType'])) {
            $this->authType = $config['authType'];
        }

        if (!in_array($this->authType, ['token', 'oauth2'])) {
            throw new InvalidArgument('Unknown auth method!!');
        }

        if ($this->authType === 'oauth2') {
            $this->token = $this->getAccessToken($config);
        }
    }

    /**
     * Send the request...
     *
     * @throws GuzzleException
     * @throws InvoiceofficeException
     */
    public function getAccessToken(array $config = []): ?string
    {
        try {
            $url = $this->generateUrl('authentication_token');

            $response = $this->client->request('POST', $url, [
                'headers' => [
                    'User-Agent'   => $this->user_agent,
                    'Content-Type' => 'application/json',
                    'Accept'       => 'application/json',
                ],
                'body' => json_encode([
                    'email'    => $config['email'],
                    'password' => $config['password'],
                ], JSON_THROW_ON_ERROR),
            ]);

            $responseArr = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

            return $responseArr['token'] ?? null;
        } catch (ServerException|JsonException $e) {
            throw InvoiceofficeException::create($e);
        } catch (ClientException $e) {
            throw BadRequest::create($e);
        }
    }

    /**
     * Send signed request.
     *
     * @param string      $method       The HTTP request verb
     * @param string      $endpoint     The Invoiceoffice API endpoint
     * @param array       $options      An array of options to send with the request
     * @param string|null $query_string A query string to send with the request
     *
     * @throws InvoiceofficeException
     * @throws BadRequest|GuzzleException
     */
    public function request(string $method, string $endpoint, array $options = [], string $query_string = null): Response|ResponseInterface
    {
        if (($this->authType === 'token' && empty($this->apiKey)) || ($this->authType === 'oauth2' && empty($this->token))) {
            throw new InvalidArgument('You must provide a Invoiceoffice api key or token.');
        }

        $url = $this->generateUrl($endpoint, $query_string);

        $options = array_merge($this->clientOptions, $options);
        $options['headers']['User-Agent'] = $this->user_agent;

        if ($this->authType === 'oauth2') {
            $options['headers']['Authorization'] = 'Bearer ' . $this->token;
        } elseif ($this->authType === 'token') {
            $options['headers']['X-AUTH-TOKEN'] = $this->apiKey;
        }

        try {
            if (false === $this->wrapResponse) {
                return $this->client->request($method, $url, $options);
            }

            return new Response($this->client->request($method, $url, $options));
        } catch (ServerException $e) {
            throw InvoiceofficeException::create($e);
        } catch (ClientException $e) {
            throw BadRequest::create($e);
        }
    }

    /**
     * Generate the full endpoint url, including query string.
     *
     * @param string      $endpoint     the Invoiceoffice API endpoint
     * @param string|null $query_string the query string to send to the endpoint
     */
    protected function generateUrl(string $endpoint, string $query_string = null): string
    {
        return rtrim($this->baseUrl, '/') . '/' . ltrim($endpoint, '/') . '?' . $query_string;
    }
}
