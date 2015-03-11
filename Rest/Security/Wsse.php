<?php

/*
 * This file is part of the AMFWebServicesClientBundle package.
 *
 * (c) Amine Fattouch <http://github.com/fattouchsquall>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AMF\WebServicesClientBundle\Rest\Security;

/**
 * Add security wsse layer to rest webservices.
 *
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
class Wsse
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
     * @var array
     */
    protected $options;

    /**
     * The constructor class.
     *
     * @param string $username The username of wsse security.
     * @param string $password The password of wsse security.
     * @param array  $options  Options to encode password.
     */
    public function __construct($username, $password, array $options = array())
    {
        $this->username = $username;
        $this->password = $password;
        $this->options  = $options;
    }

    /**
     * Generates header for wsse security.
     *
     * @throws Exception If the username or password are not provided.
     *
     * @return array
     */
    public function generateHeader()
    {
        $header = array();
        if (isset($this->password) && isset($this->username)) {
            $now     = new \DateTime('now');
            $created = $now->format('Y-m-d H:i:s');

            $nonce  = $this->generateNonce();
            $digest = $this->generatePasswordDigest($nonce, $created);

            $header['HTTP_AUTHORISATION'] = 'WSSE profile="UsernameToken"';
            $header['HTTP_X-WSSE']        = sprintf('UsernameToken Username="%s", PasswordDigest="%s", Nonce="%s", Created="%s"',
                        $this->username, $digest, base64_encode($nonce), $created
            );

            return $header;
        }

        throw new \Exception('Username and password must be provided');
    }

    /**
     * Generates a random nonce for wsse token.
     *
     * @return string
     */
    protected function generateNonce()
    {
        $chars   = $this->options['nonce_chars'];
        $random  = "" . microtime();
        $random .= mt_rand();
        
        $mi = strlen($chars) - 1;
        for ($i = 0; $i < $this->options['nonce_length']; $i++) {
            $random .= $chars[mt_rand(0, $mi)];
        }
        $nonce = md5($random);
        
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
        $passwordDigest = sha1($nonce.$created.$this->password, true);

        if ($this->options['encode_as_64'] === true) {
            $passwordDigest = base64_encode($passwordDigest);
        }

        return $passwordDigest;
    }
}
