<?php

/**
 * This is the container provider for the decoder.
 *
 * @package AMFWebServicesClientBundle
 * @subpackage Decoder
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */

namespace AMF\WebServicesClientBundle\Rest\Decoder;

/**
 * This is the container provider for the decoder.
 *
 * @package AMFWebServicesClientBundle
 * @subpackage Decoder
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
interface DecoderProviderInterface
{
    
    /**
     * The getter for the decoder.
     *
     * @param string $format Format for the requested decoder.
     * 
     * @return DecoderInterface
     */
    function getDecoder($format);
}
