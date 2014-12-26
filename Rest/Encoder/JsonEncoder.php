<?php

/**
 * This class encodes json data.
 *
 * @package AMFWebServicesClientBundle
 * @subpackage Encoder
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */

namespace AMF\WebServicesClientBundle\Rest\Encoder;

use Symfony\Component\Serializer\Encoder\JsonEncoder as BaseJsonEncoder;

/**
 * This class encodes json data.
 *
 * @package AMFWebServicesClientBundle
 * @subpackage Encoder
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
class JsonEncoder implements EncoderInterface
{
    
    /**
     * @var BaseJsonEncoder
     */
    protected $encoder;
    
    /**
     * The constructor class.
     */
    public function __construct()
    {
        $this->encoder = new BaseJsonEncoder();
    }
    
    /**
     * {@inheritdoc}
     */
    public function encode($data, array $context=array())
    {
        return $this->encoder->encode($data, 'json', $context);
    }
}
