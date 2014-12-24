<?php

/**
 * This is the container provider for the encoder.
 *
 * @package AMFWebServicesClientBundle
 * @subpackage Encoder
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */

namespace AMF\WebServicesClientBundle\Rest\Encoder;

/**
 * This is the container provider for the encoder.
 *
 * @package AMFWebServicesClientBundle
 * @subpackage Encoder
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
interface EncoderProviderInterface
{
    /**
     * The getter for the encoder.
     *
     * @param string $format Format for the requested encoder.
     * 
     * @return EncoderInterface
     */
    function getEncoder($format);
}
