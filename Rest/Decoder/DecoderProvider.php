<?php

/**
 * This is the container provider for the decoder.
 *
 * @package AMFWebServicesClientBundle
 * @subpackage Decoder
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */

namespace AMF\WebServicesClientBundle\Rest\Decoder;

use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * This is the container provider for the decoder.
 *
 * @package AMFWebServicesClientBundle
 * @subpackage Decoder
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
class DecoderProvider extends ContainerAware implements DecoderProviderInterface
{
    
    /**
     * @var array
     */
    protected $decoders;

    
    /**
     * The constructor class.
     *
     * @param array $decoders List of decoders (default empty).
     */
    public function __construct(array $decoders=array())
    {
        $this->decoders = $decoders;
    }

    /**
     * @param string $format The format of decoder.
     *
     * @throws \InvalidArgumentException
     * 
     * @return DecoderInterface
     */
    public function getDecoder($format)
    {
        if ($this->supports($format) === false) 
        {
            throw new \InvalidArgumentException(sprintf("Format '%s' is not supported.", $format));
        }

        return $this->container->get($this->decoders[$format]);
    }
    
    /**
     * Tests whether a decoder for a given format exists.
     * 
     * @param string $format The format.
     *
     * @return boolean
     */
    protected function supports($format)
    {
        return isset($this->decoders[$format]);
    }
}
