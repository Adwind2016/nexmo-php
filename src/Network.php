<?php

namespace Nexmo;

use ArrayAccess;
use Nexmo\Client\Exception\Exception;
use Nexmo\Entity\EntityInterface;
use Nexmo\Entity\JsonSerializableInterface;
use Nexmo\Entity\JsonResponseTrait;
use Nexmo\Entity\JsonSerializableTrait;
use Nexmo\Entity\NoRequestResponseTrait;
use Nexmo\Entity\JsonUnserializableInterface;

class Network implements EntityInterface, JsonSerializableInterface, JsonUnserializableInterface, ArrayAccess {
    use JsonSerializableTrait;
    use NoRequestResponseTrait;
    use JsonResponseTrait;

    protected $data = [];

    public function __construct($code, $network, $outboundSmsPrice)
    {
        $this->data['code'] = $code;
        $this->data['name'] = $network;
        $this->data['outboundSmsPrice'] = $outboundSmsPrice;
    }

    public function getCode()
    {
        return $this['code'];
    }

    public function getName()
    {
        return $this['name'];
    }

    public function getOutboundSmsPrice()
    {
        return $this['outboundSmsPrice'];
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
        $outboundSmsPrice = isset($data['mtPrice']) ? $data['mtPrice'] : null;
        return new Network(
            $data['code'],
            $data['network'],
            $outboundSmsPrice
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
        throw new Exception('Network is read only');
    }

    public function offsetUnset($offset)
    {
        throw new Exception('Network is read only');
    }
}