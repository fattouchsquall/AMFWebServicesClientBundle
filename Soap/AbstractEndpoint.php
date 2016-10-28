<?php

/*
 * This file is part of the AMFWebServicesClientBundle package.
 *
 * (c) Amine Fattouch <http://github.com/fattouchsquall>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AMF\WebServicesClientBundle\Soap;

use AMF\WebServicesClientBundle\Soap\Security\Wsse;

/**
 * This class manages the interaction with a SOAP webservice.
 *
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
abstract class AbstractEndpoint
{
    /**
     * @var \SoapClient
     */
    protected $soapClient;

    /**
     * @var Wsse
     */
    protected $wsse;

    /**
     * @var boolean
     */
    protected $isSecure;

    /**
     * Constructor class.
     *
     * @param \SoapClient $soapClient The soap client.
     * @param Wsse        $wsse       The handler of soap wsse (default null).
     * @param boolean     $isSecure   Whether the webservice is secured or not (default false).
     */
    public function __construct(\SoapClient $soapClient, Wsse $wsse = null, $isSecure = false)
    {
        $this->soapClient = $soapClient;
        $this->wsse       = $wsse;
        $this->isSecure   = $isSecure;
    }

    /**
     * Calls web services with SoapClient.
     *
     * @param string $methodName The name of method to call.
     * @param array  $arguments  The arguments of the function to call (default empty).
     *
     * @return Soap response
     */
    public function call($methodName, array $arguments = [])
    {
        if ($this->isSecure === true) {
            $wsseHeader = $this->wsse->generateHeader();
            $this->soapClient->__setSoapHeaders($wsseHeader);
        }

        return $this->soapClient->__soapCall($methodName, $arguments);
    }
}
