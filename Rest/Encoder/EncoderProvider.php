<?php

/**
 * This is the container provider for the encoder.
 *
 * @package AMFWebServicesClientBundle
 * @subpackage Encoder
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */

namespace AMF\WebServicesClientBundle\Rest\Encoder;

use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * This is the container provider for the encoder.
 *
 * @package AMFWebServicesClientBundle
 * @subpackage Encoder
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
class EncoderProvider extends ContainerAware implements EncoderProviderInterface
{
    
    /**
     * @var array
     */
    protected $encoders;

    
    /**
     * The constructor class.
     *
     * @param array $encoders List of encoders (default empty).
     */
    public function __construct(array $encoders=array())
    {
        $this->encoders = $encoders;
    }

    /**
     * @param string $format The format of encoder.
     *
     * @throws \InvalidArgumentException
     * 
     * @return EncoderInterface
     */
    public function getEncoder($format)
    {
        if ($this->supports($format) === false) 
        {
            throw new \InvalidArgumentException(sprintf("Format '%s' is not supported.", $format));
        }

        return $this->container->get($this->encoders[$format]);
    }
    
    /**
     * Tests whether a encoder for a given format exists.
     * 
     * @param string $format The format.
     *
     * @return boolean
     */
    protected function supports($format)
    {
        return isset($this->encoders[$format]);
    }
}
