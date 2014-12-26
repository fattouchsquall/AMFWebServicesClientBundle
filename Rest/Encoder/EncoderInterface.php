<?php

/**
 * Interface for encoder.
 *
 * @package AMFWebServicesClientBundle
 * @subpackage Encoder
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */

namespace AMF\WebServicesClientBundle\Rest\Encoder;

/**
 * Interface for encoder.
 *
 * @package AMFWebServicesClientBundle
 * @subpackage Encoder
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
interface EncoderInterface
{
    
    /**
     * Encodes a string into array.
     *
     * @param string $data    The data to encode.
     * @param array  $context The context of encoding.
     * 
     * @return array
     */
    function encode($data, array $context = array());
}
