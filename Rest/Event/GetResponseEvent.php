<?php

/*
 * This file is part of the AMFWebServicesClientBundle package.
 *
 * (c) Amine Fattouch <http://github.com/fattouchsquall>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AMF\WebServicesClientBundle\Rest\Event;

use Symfony\Component\EventDispatcher\Event;
use AMF\WebServicesClientBundle\Rest\Component\Request;
use AMF\WebServicesClientBundle\Rest\Component\Response;

/**
 * The event for sharing request and response into listener.
 *
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
class GetResponseEvent extends Event
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * The constructor class.
     *
     * @param Request $request Instance of api request.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Getter for request.
     *
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Getter for response.
     *
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Setter for response.
     *
     * @param Response $response Instance of api response.
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;
    }
}
