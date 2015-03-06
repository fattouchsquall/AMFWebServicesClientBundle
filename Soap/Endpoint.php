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
abstract class Endpoint extends \SoapClient
{
    /**
     * @var string
     */
    protected $wsdl;

    /**
     * @var Wsse
     */
    protected $wsse;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var boolean
     */
    protected $isSecure;

    /**
     * Constructor class.
     *
     * @param string  $wsdl     The link for wsdl file (default null).
     * @param Wsse    $wsse     The handler of soap wsse (default null).
     * @param array   $options  The options for soap client (default empty).
     * @param boolean $isSecure Whethere the webservice is secured or not (default false).
     */
    public function __construct($wsdl = null, Wsse $wsse = null, array $options = array(), $isSecure = false)
    {
        $this->wsdl     = $wsdl;
        $this->wsse     = $wsse;
        $this->options  = $options;
        $this->isSecure = $isSecure;
    }

    /**
     * Call web services with SoapClient.
     *
     * @param string $methodName The name of method to call.
     * @param array  $arguments  The arguments of the function to call (default empty).
     *
     * @return Soap response
     */
    public function call($methodName, array $arguments = array())
    {
        $client = new \SoapClient($this->wsdl, $this->options);

        if ($this->isSecure === true) {
            $wsseHeader = $this->wsse->generateHeader();
            $client->__setSoapHeaders($wsseHeader);
        }

        $response = $client->__soapCall($methodName, $arguments);

        return $response;
    }
}
