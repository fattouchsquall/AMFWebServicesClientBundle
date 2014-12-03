<?php

/**
 * @package AMFWebServicesClientBundle
 * @subpackage Soap
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */

namespace AMF\WebServicesClientBundle\Soap;

use AMF\WebServicesClientBundle\Soap\Security\SoapWsse;

/**
 * This class manages the interaction with a SOAP webservice.
 * 
 * @package AMFWebServicesClientBundle
 * @subpackage Soap
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
abstract class Endpoint extends \SoapClient
{
    
    /**
     * @var string 
     */
    protected $wsdl;

    /**
     * @var SOAPWsse
     */
    protected $soapWsse;
    
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
     * @param string   $wsdl     The link for wsdl file (default null).
     * @param SOAPWsse $soapWsse The handler of soap wsse (default null).
     * @param array    $options  The options for soap client (default empty).
     * @param boolean  $isSecure Whethere the webservice is secured or not (default false).
     */
    public function __construct($wsdl=null, SoapWsse $soapWsse=null, array $options=array(), $isSecure=false)
    {
        $this->wsdl     = $wsdl;
        $this->soapWsse = $soapWsse;
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
    public function call($methodName, array $arguments=array())
    {
        $client = new \SoapClient($this->wsdl, $this->options);

        if ($this->isSecure === true)
        {
            $wsseHeader = $this->soapWsse->generateHeader();
            $client->__setSoapHeaders($wsseHeader);
        }
        
        $response = $client->__soapCall($methodName, $arguments);
            
        return $response;
    }
}
