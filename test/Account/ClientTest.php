<?php
/**
 * Nexmo Client Library for PHP
 *
 * @copyright Copyright (c) 2016 Nexmo, Inc. (http://nexmo.com)
 * @license   https://github.com/Nexmo/nexmo-php/blob/master/LICENSE.txt MIT License
 */

namespace NexmoTest\Account;

use Nexmo\Network;
use Nexmo\Account\SmsPrice;
use Nexmo\Account\Client;
use Zend\Diactoros\Response;
use NexmoTest\Psr7AssertionTrait;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;


class ClientTest extends \PHPUnit_Framework_TestCase
{
    use Psr7AssertionTrait;

    protected $nexmoClient;

    /**
     * @var Client
     */
    protected $accountClient;

    public function setUp()
    {
        $this->nexmoClient = $this->prophesize('Nexmo\Client');
        $this->accountClient = new Client();
        $this->accountClient->setClient($this->nexmoClient->reveal());
    }

    public function testSetFilter()
    {

        $this->nexmoClient->send(Argument::that(function (RequestInterface $request) {
            $this->assertEquals('/account/get-pricing/outbound', $request->getUri()->getPath());
            $this->assertEquals('rest.nexmo.com', $request->getUri()->getHost());
            $this->assertEquals('GET', $request->getMethod());
            $this->assertRequestQueryContains('country', 'US', $request);

            return true;
        }))->shouldBeCalledTimes(1)->willReturn($this->getResponse('smsprice-gb'));

        //$this->assertEquals();

        $smsPrice = $this->accountClient->getSmsPrice('US');
        $this->assertInstanceOf(SmsPrice::class, $smsPrice);
        $this->assertInstanceOf(Network::class, $smsPrice['networks'][0]);
    }

    /**
     * Get the API response we'd expect for a call to the API.
     *
     * @param string $type
     * @return Response
     */
    protected function getResponse($type = 'success', $status = 200)
    {
        return new Response(fopen(__DIR__ . '/responses/' . $type . '.json', 'r'), $status);
    }
}
