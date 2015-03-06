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
 * The soap token for wsse.
 *
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
class WsseToken
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
