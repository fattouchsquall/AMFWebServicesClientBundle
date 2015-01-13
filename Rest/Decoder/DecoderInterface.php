<?php

/**
 * Interface for decoder.
 *
 * @package AMFWebServicesClientBundle
 * @subpackage Decoder
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */

namespace AMF\WebServicesClientBundle\Rest\Decoder;

/**
 * Interface for decoder.
 *
 * @package AMFWebServicesClientBundle
 * @subpackage Decoder
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
    function decode($data, array $context=array());
}
