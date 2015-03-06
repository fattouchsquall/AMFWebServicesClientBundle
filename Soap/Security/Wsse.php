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
 * Add security wsse layer to soap webservices.
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
     * The constructor class.
     *
     * @param string $username The username of wsse security.
     * @param string $password The password of wsse security.
     */
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Generates WSSE header for SOAP.
     *
     * @return \SoapHeader
     */
    public function generateHeader()
    {
        if (isset($this->username)
                && strlen($this->username) > 0
                && isset($this->password)
                && strlen($this->password) > 0) {
            $xsdNamespace = "http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd";

            $usernameSoapVar  = new \SoapVar($this->username, XSD_STRING, null,
                                                $xsdNamespace, null, $xsdNamespace);
            $passwordSoapVar  = new \SoapVar($this->password, XSD_STRING, null,
                                                $xsdNamespace, null, $xsdNamespace);
            $wsseAuth         = new WsseAuth($usernameSoapVar, $passwordSoapVar);
            $wsseAuthSoapVar  = new \SoapVar($wsseAuth, SOAP_ENC_OBJECT, null,
                                                $xsdNamespace, 'UsernameToken',
                                                $xsdNamespace);
            $wsseToken        = new WsseToken($wsseAuthSoapVar);
            $wsseTokenSoapVar = new \SoapVar($wsseToken, SOAP_ENC_OBJECT,
                                                null, $xsdNamespace,
                                                'UsernameToken', $xsdNamespace);
            $secHeaderValue   = new \SoapVar($wsseTokenSoapVar,
                                                SOAP_ENC_OBJECT, null,
                                                $xsdNamespace, 'Security',
                                                $xsdNamespace);

            $soapHeader = new \SoapHeader($xsdNamespace, 'Security', $secHeaderValue);

            return $soapHeader;
        }

        throw new \Exception('Username and password cannot be empty');
    }
}
