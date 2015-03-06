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
 * This is the container provider for the encoder.
 *
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
    public function getEncoder($format);
}
