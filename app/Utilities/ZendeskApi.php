<?php

namespace App\Utilities;

use App\Utilities\AuthCookie;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Validation\UnauthorizedException;
use Zendesk\API\HttpClient as ZendeskApiClient;

/**
 * Utility class to take care of the Zendesk API calls
 *
 * Class ZendeskApi
 */
class ZendeskApi
{
    /**
     * @var \Zendesk\API\HttpClient
     */
    protected $client;

    /**
     * Constructor for the Zendesk Api Client.
     * Takes care of building the Zendesk Api Client to use for making zendesk requests.
     *
     * @param string $subdomain
     * @param string $accessToken
     * @param ZendeskApiClient $zendeskClient
     *
     * @throws UnauthorizedException
     */
    public function __construct($subdomain, $accessToken, ZendeskApiClient $zendeskClient = null)
    {
        $client = app(GuzzleClient::class);

        if ($zendeskClient) {
            $this->client = $zendeskClient;
        } else {
            $this->client = new ZendeskApiClient(
                $subdomain, null, 'https', config('app.zendesk_domain'), 443, $client
            );
        }

        $this->client->setAuth('oauth', ['token' => $accessToken]);
        $this->client->setHeader('X-ZENDESK-INTEGRATION', config('app.zendesk_x_header_value'));

        if ($this->client->getSubdomain() !== $subdomain) {
            \Log::error('Subdomain Mismatch', [
                'location' => __METHOD__,
                'account' => compact('subdomain', 'accessToken'),
                'clientSubdomain' => $this->client->getSubdomain(),
            ]);

            throw new UnauthorizedException(trans('errors.subdomain.invalid'), 403);
        }
    }

    /**
     * Setter for Zendesk api client to be used
     *
     * @param ZendeskApiClient $client
     *
     * @return $this
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }
}
