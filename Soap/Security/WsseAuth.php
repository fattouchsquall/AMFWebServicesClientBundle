<?php

/**
 * @package AMFWebServicesClientBundle
 * @subpackage Security
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */

namespace AMF\WebServicesClientBundle\Soap\Security;

/**
 * The soap wsse login informations.
 * 
 * @package AMFWebServicesClientBundle
 * @subpackage Security
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
class WsseAuth
{
    
    /**
     * @var string
     */
    protected $Username;
    
    /**
     * @var string
     */
    protected $Password;
    
    
    /**
     * Constructor class.
     * 
     * @param string $username The username used in wsse security.
     * @param string $password The password used in wsse security.
     */
    public function __construct($username, $password)
    {
        $this->Username = $username;
        $this->Password = $password;
    }
}
