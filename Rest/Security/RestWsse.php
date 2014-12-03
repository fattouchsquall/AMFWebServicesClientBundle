<?php

/**
 * Add security wsse layer to rest webservices.
 * 
 * @package AMFWebServicesClientBundle
 * @subpackage Security
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
namespace AMF\WebServicesClientBundle\RestClient\Security;

/**
 * Add security wsse layer to rest webservices.
 * 
 * @package AMFWebServicesClientBundle
 * @subpackage Security
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
class RestWsse
{
    /**
     * @var string
     */
    protected $username;
    
    /**
     * @var string
     */
    protected $password;
    
    /**
     * @var integer
     */
    protected $nonceLength;
    
    /**
     * @var string
     */
    protected $nonceChars;
    
    /**
     * @var boolean
     */
    protected $encodeAs64;


    /**
     * The constructor class.
     * 
     * @param string  $username    The username of wsse security.
     * @param string  $password    The password of wsse security.
     * @param integer $nonceLength The length of nonce.
     * @param string  $nonceChars  The chars used in nonce.
     * @param boolean $encodeAs64  Whether to encode password as 64. 
     */
    public function __construct($username, $password, $nonceLength, $nonceChars, $encodeAs64)
    {
        $this->username    = $username;
        $this->password    = $password;
        $this->nonceLength = $nonceLength;
        $this->nonceLChars = $nonceChars;
        $this->encodeAs64  = $encodeAs64;
    }
 
    /**
     * Generates wsse header for authentification.
     * 
     * @return array
     */
    public function generateWSSEHeader()
    {
        $wsseHeader = array();
        if (isset($this->password) && isset($this->username))
        {
            $now     = new \DateTime('now'); 
            $created = $now->format('Y-m-d H:i:s');

            $nonce  = $this->generateNonce();
            $digest = $this->generatePasswordDigest($nonce, $created);

            $wsseHeader['HTTP_AUTHORISATION'] = 'WSSE profile="UsernameToken"';
            $wsseHeader['HTTP_X-WSSE']        = sprintf('UsernameToken Username="%s", PasswordDigest="%s", Nonce="%s", Created="%s"',
                        $this->username, $digest, base64_encode($nonce), $created
            );
        }
        
        return $wsseHeader;
    }
    
    /**
     * Generates a random nonce for wsse token.
     * 
     * @return string
     */
    protected function generateNonce()
    {
        $nonce = "";
        for ($i = 0; $i < $this->nonceLength; $i++)
        {
            $nonce += substr($this->nonceChars, floor(rand() * strlen($this->nonceChars)));
        }
        
        return $nonce;
    }
    
    /**
     * Generates a password digest.
     * 
     * @param string $nonce   The generated nonce.
     * @param string $created The date of creation.
     * 
     * @return string
     */
    protected function generatePasswordDigest($nonce, $created)
    {
        $passwordDigest = sha1($nonce . $created . $this->password, true);
        
        if ($this->encodeAs64 === true)
        {
            $passwordDigest = base64_encode($passwordDigest);
        }
        
        return $passwordDigest;
    }
} 