<?php

/**
 * This class decodes json data.
 *
 * @package AMFWebServicesClientBundle
 * @subpackage Decoder
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */

namespace AMF\WebServicesClientBundle\Rest\Decoder;

use Symfony\Component\Serializer\Encoder\JsonDecode as BaseJsonDecoder;

/**
 * This class decodes json data.
 *
 * @package AMFWebServicesClientBundle
 * @subpackage Decoder
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
class JsonDecoder implements DecoderInterface
{
    
    /**
     * @var BaseJsonDecoder
     */
    protected $decoder;
    
    
    /**
     * The constructor class.
     */
    public function __construct()
    {
        $this->decoder = new BaseJsonDecoder();
    }
    
    /**
     * {@inheritdoc}
     */
    public function decode($data, array $context=array())
    {
        return $this->decoder->decode($data, 'json', $context);
    }
}
