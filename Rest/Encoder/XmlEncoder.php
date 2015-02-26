<?php

/**
 * @package AMFWebServicesClientBundle
 * @subpackage Encoder
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */

namespace AMF\WebServicesClientBundle\Rest\Encoder;

use Symfony\Component\Serializer\Encoder\XmlEncoder as BaseXmlEncoder;

/**
 * This class encodes xml data.
 *
 * @package AMFWebServicesClientBundle
 * @subpackage Encoder
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
class XmlEncoder implements EncoderInterface
{

    /**
     * @var BaseXmlEncoder
     */
    protected $encoder;

    
    /**
     * The constructor class.
     */
    public function __construct()
    {
        $this->encoder = new BaseXmlEncoder();
    }

    /**
     * {@inheritdoc}
     */
    public function encode($data, array $context=array())
    {
        return $this->encoder->encode($data, 'xml', $context);
    }
    
}
