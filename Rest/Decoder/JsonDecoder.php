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

use Symfony\Component\Serializer\Encoder\JsonDecode as BaseJsonDecoder;

/**
 * This class decodes json data.
 *
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
    public function decode($data, array $context = array())
    {
        return $this->decoder->decode($data, 'json', $context);
    }
}
