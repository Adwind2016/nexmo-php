<?php

namespace Nexmo\Account;

use ArrayAccess;
use Nexmo\Client\Exception\Exception;
use Nexmo\Network;
use Nexmo\Entity\EntityInterface;
use Nexmo\Entity\JsonSerializableInterface;
use Nexmo\Entity\JsonResponseTrait;
use Nexmo\Entity\JsonSerializableTrait;
use Nexmo\Entity\NoRequestResponseTrait;
use Nexmo\Entity\JsonUnserializableInterface;

class SmsPrice implements EntityInterface, JsonSerializableInterface, JsonUnserializableInterface, ArrayAccess {
    use JsonSerializableTrait;
    use NoRequestResponseTrait;
    use JsonResponseTrait;

    protected $data = [];

    public function __construct($country, $name, $prefix, $mt, array $networks)
    {
        $this->data['country'] = $country;
        $this->data['name'] = $name;
        $this->data['prefix'] = $prefix;
        $this->data['defaultPrice'] = $mt; // Stands for message terminated i.e. outbound message
        $this->data['networks'] = $networks;
    }

    public function getCountry()
    {
        return $this['country'];
    }

    public function getName()
    {
        return $this['name'];
    }

    public function getPrefix()
    {
        return $this['prefix'];
    }

    public function getDefaultPrice()
    {
        return $this['defaultPrice'];
    }

    public function getNetworks()
    {
        return $this['networks'];
    }

    public function getPriceForNetwork($networkCode)
    {
        foreach ($this->getNetworks() as $network)
        {
            if ($network->getCode() === $networkCode)
            {
                return $network->getOutboundSmsPrice();
            }
        }

        return $this->getDefaultPrice();
    }

    public function jsonUnserialize(array $json)
    {
        $this->data = $json;
    }

    function jsonSerialize()
    {
        return $this->data;
    }

    public static function fromArray($data)
    {
        $networks = [];
        foreach ($data['networks'] as $n) {
            $networks[] = Network::fromArray($n);
        }

        return new SmsPrice(
            $data['country'],
            $data['countryDisplayName'],
            $data['prefix'],
            $data['mt'],
            $networks
        );
    }

    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    public function offsetSet($offset, $value)
    {
        throw new Exception('SmsPrice is read only');
    }

    public function offsetUnset($offset)
    {
        throw new Exception('SmsPrice is read only');
    }
}
