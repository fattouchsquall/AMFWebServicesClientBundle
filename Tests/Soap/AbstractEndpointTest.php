<?php

/*
 * This file is part of the AMFWebServicesClientBundle package.
 *
 * (c) Amine Fattouch <http://github.com/fattouchsquall>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Soap;

use AMF\WebServicesClientBundle\Soap\AbstractEndpoint;
use AMF\WebServicesClientBundle\Soap\Security\Wsse;

/**
 * Test suite for Endpoint class.
 *
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
class AbstractEndpointTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Phake_IMock
     */
    private $soapClient;

    /**
     * @var \Phake_IMock
     */
    private $wsse;

    /**
     * Setups current tests.
     */
    public function setUp()
    {
        $this->soapClient = \Phake::mock(\SoapClient::class);
        $this->wsse       = \Phake::mock(Wsse::class);
    }

    /**
     * @test
     */
    public function shouldGenerateWsseHeaderIfRequestIsSecured()
    {
        $endpoint = \Phake::partialMock(AbstractEndpoint::class, $this->soapClient, $this->wsse, true);

        $endpoint->call($this->anything(), []);

        \Phake::verify($this->wsse)->generateHeader();
        \Phake::verify($this->soapClient)->__setSoapHeaders($this->anything());
    }
}
