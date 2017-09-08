<?php

namespace Nexmo\Account;

use Nexmo\Client\ClientAwareInterface;
use Nexmo\Client\ClientAwareTrait;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Request;
use Nexmo\Client\Exception;


class Client implements ClientAwareInterface
{
    use ClientAwareTrait;

    public function getSmsPrice($country)
    {
        $queryString = http_build_query([
            'country' => $country
        ]);

        $request = new Request(
            \Nexmo\Client::BASE_REST . '/account/get-pricing/outbound?'.$queryString,
            'GET',
            'php://temp'
        );

        $response = $this->client->send($request);
        $rawBody = (string) $response->getBody();

        // An empty response is our error case
        if ($rawBody === '') {
            throw new Exception\Server('No results found');
        }

        $body = json_decode($rawBody, true);
        return SmsPrice::fromArray($body);
    }
}