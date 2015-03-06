<?php

/*
 * This file is part of the AMFWebServicesClientBundle package.
 *
 * (c) Amine Fattouch <http://github.com/fattouchsquall>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AMF\WebServicesClientBundle\Rest\Encoder;

use Symfony\Component\Serializer\Encoder\JsonEncoder as BaseJsonEncoder;

/**
 * This class encodes json data.
 *
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
    public function encode($data, array $context = array())
    {
        return $this->encoder->encode($data, 'json', $context);
    }
}
