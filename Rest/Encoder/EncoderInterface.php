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

/**
 * Interface for encoder.
 *
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
interface EncoderInterface
{
    /**
     * Encodes a string into array.
     *
     * @param string $data    The data to encode.
     * @param array  $context The context of encoding (default empty).
     *
     * @return array
     */
    public function encode($data, array $context = array());
}
