<?php

/**
 * This file is part of the AMFWebServicesClientBundle package.
 *
 * (c) Amine Fattouch <http://github.com/fattouchsquall>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AMF\WebServicesClientBundle\Rest\Decoder;

/**
 * Interface for decoder.
 *
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
interface DecoderInterface
{
    /**
     * Decodes a string into array.
     *
     * @param string $data    The data to decode.
     * @param array  $context The context of decoding (default empty).
     *
     * @return array
     */
    public function decode($data, array $context = array());
}
