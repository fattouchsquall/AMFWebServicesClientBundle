<?php

/**
 * @package AMFWebServicesClientBundle
 * @subpackage Security
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */

namespace AMF\WebServicesClientBundle\Soap\Security;

/**
 * The soap token for wsse.
 * 
 * @package AMFWebServicesClientBundle
 * @subpackage Security
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
class SoapWsseToken
{
    
    /**
     * @var string
     */
    protected $UsernameToken;
    
    
    /**
     * The constructor class.
     * 
     * @param string $usernameToken The token for the username.
     */
    public function __construct($usernameToken)
    {
        $this->UsernameToken = $usernameToken;
    }
}