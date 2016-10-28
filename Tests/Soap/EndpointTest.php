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

use AMF\WebServicesClientBundle\Soap\Endpoint;
use AMF\WebServicesClientBundle\Soap\Security\Wsse;

/**
 * Test suite for Endpoint class.
 *
 * @author Amine Fattouch <amine.fattouch@gmail.com>
 */
class EndpointTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Setups current tests.
     */
    public function setUp()
    {
        $this->endpoint = \Phake::partialMock(Endpoint::class);
        $this->wsse     = \Phake::mock(Wsse::class);
    }

    /**
     * @test
     */
    public function shouldGenerateWsseHeaderIfRequestIsSecured()
    {
        $this->endpoint->call($this->anything(), $this->anything());

        \Phake::verify($this->wsse)->generateHeader();
    }
}
