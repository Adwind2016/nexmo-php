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

class SmsPriceTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
    }

    /**
     * @dataProvider smsPriceProvider
     */
    public function testFromArray($smsPrice)
    {
        $this->assertEquals("US", $smsPrice->getCountry());
        $this->assertEquals("United States", $smsPrice->getName());
        $this->assertEquals("1", $smsPrice->getPrefix());
        $this->assertEquals("0.00512", $smsPrice->getDefaultPrice());
    }

    /**
     * @dataProvider smsPriceProvider
     */
    public function testGetters($smsPrice)
    {
        $this->assertEquals("US", $smsPrice->getCountry());
        $this->assertEquals("United States", $smsPrice->getName());
        $this->assertEquals("1", $smsPrice->getPrefix());
        $this->assertEquals("0.00512", $smsPrice->getDefaultPrice());
    }

    /**
     * @dataProvider smsPriceProvider
     */
    public function testArrayAccess($smsPrice)
    {
        $this->assertEquals("US", $smsPrice['country']);
        $this->assertEquals("United States", $smsPrice['name']);
        $this->assertEquals("1", $smsPrice['prefix']);
        $this->assertEquals("0.00512", $smsPrice['defaultPrice']);
    }

    /**
     * @dataProvider smsPriceProvider
     */
    public function testUsesCustomPriceForKnownNetwork($smsPrice)
    {
        $this->assertEquals("0.123", $smsPrice->getPriceForNetwork('21039'));
    }

    /**
     * @dataProvider smsPriceProvider
     */
    public function testUsesDefaultPriceForUnknownNetwork($smsPrice)
    {
        $this->assertEquals("0.00512", $smsPrice->getPriceForNetwork('007'));
    }

    public function smsPriceProvider()
    {
        $r = [];
        $r['constructor'] = [new SmsPrice("US", "United States", "1","0.00512", [
            new Network("21039", "Demo Network", "0.123")
        ])];

        $r['fromArray'] = [SmsPrice::fromArray([
            'country' => 'US',
            'countryDisplayName' => 'United States',
            'prefix' => 1,
            'mt' => '0.00512',
            'networks' => [
                [
                    'code' => '21039',
                    'network' => 'Demo Network',
                    'mtPrice' => '0.123'
                ]
            ]
        ])];

        return $r;
    }
}
