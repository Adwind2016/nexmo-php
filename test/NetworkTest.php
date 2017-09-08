<?php
/**
 * Nexmo Client Library for PHP
 *
 * @copyright Copyright (c) 2016 Nexmo, Inc. (http://nexmo.com)
 * @license   https://github.com/Nexmo/nexmo-php/blob/master/LICENSE.txt MIT License
 */

namespace NexmoTest;

use Nexmo\Network;

class NetworkTest extends \PHPUnit_Framework_TestCase
{
    public function testNetworkArrayAccess()
    {
        $network = new Network('12345', 'Demo Network', '0.0331');
        $this->assertEquals($network['code'], '12345');
        $this->assertEquals($network['name'], 'Demo Network');
        $this->assertEquals($network['outboundSmsPrice'], '0.0331');
    }

    public function testNetworkGetters()
    {
        $network = new Network('12345', 'Demo Network', '0.0331');
        $this->assertEquals($network->getCode(), '12345');
        $this->assertEquals($network->getName(), 'Demo Network');
        $this->assertEquals($network->getOutboundSmsPrice(), '0.0331');
    }

    public function testNetworkFromArray()
    {
        $network = Network::fromArray([
            'code' => '12345',
            'network' => 'Demo Network',
            'mtPrice' => '0.0331'
        ]);
        $this->assertEquals($network->getCode(), '12345');
        $this->assertEquals($network->getName(), 'Demo Network');
        $this->assertEquals($network->getOutboundSmsPrice(), '0.0331');
    }
}
