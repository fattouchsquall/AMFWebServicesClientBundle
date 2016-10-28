<?php

/*
 * This file is part of the AMFWebServicesClientBundle package.
 *
 * (c) Amine Fattouch <http://github.com/fattouchsquall>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Soap\Security;

use AMF\WebServicesClientBundle\Soap\Security\Wsse;

/**
 * Test suite for Endpoint class.
 *
 * @author Amine Fattouch <amine.fattouch@gmail.com>
 */
class WsseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldThrowAnExceptionIfUsernameAndPasswordAreNotProvided()
    {
        $this->expectException(\Exception::class);

        $wsse = \Phake::partialMock(Wsse::class, null, null);

        $wsse->generateHeader();
    }

    /**
     * @test
     */
    public function shouldGenerateAHeaderForWsse()
    {
        $wsse = \Phake::partialMock(Wsse::class, 'test', 'test');

        $this->assertInstanceOf(\SoapHeader::class, $wsse->generateHeader());
    }
}
