<?php

/*
 * This file is part of the AMFWebServicesClientBundle package.
 *
 * (c) Amine Fattouch <http://github.com/fattouchsquall>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AMF\WebServicesClientBundle\Rest\Decoder;

use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;

/**
 * This class decodes xml data.
 *
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
class XmlDecoder implements DecoderInterface
{
    /**
     * @var XmlEncoder
     */
    private $encoder;

    /**
     * The constructor class.
     */
    public function __construct()
    {
        $this->encoder = new XmlEncoder();
    }

    /**
     * {@inheritdoc}
     */
    public function decode($data, array $context = array())
    {
        try {
            return $this->encoder->decode($data, 'xml', $context);
        } catch (UnexpectedValueException $e) {
            return;
        }
    }
}
