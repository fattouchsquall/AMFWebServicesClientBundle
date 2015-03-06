<?php

/*
 * This file is part of the AMFWebServicesClientBundle package.
 *
 * (c) Amine Fattouch <http://github.com/fattouchsquall>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AMF\WebServicesClientBundle\Rest\Decoder;

/**
 * This is the container provider for the decoder.
 *
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
    public function getDecoder($format);
}
