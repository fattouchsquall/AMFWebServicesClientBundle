<?php

/*
 * This file is part of the AMFWebServicesClientBundle package.
 *
 * (c) Amine Fattouch <http://github.com/fattouchsquall>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AMF\WebServicesClientBundle\Soap\Security;

/**
 * The soap wsse login informations.
 *
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
