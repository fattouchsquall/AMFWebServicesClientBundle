<?php

/**
 * The event for sharing request and response into listener.
 * 
 * @package AMFWebServicesClientBundle
 * @subpackage Event
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */

namespace AMF\WebServicesClientBundle\Rest\Event;

use Symfony\Component\EventDispatcher\Event;

use AMF\WebServicesClientBundle\Rest\Component\Request;
use AMF\WebServicesClientBundle\Rest\Component\Response;

/**
 * The event for sharing request and response into listener.
 * 
 * @package AMFWebServicesClientBundle
 * @subpackage Event
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
     * 
     * @return void
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;
    }
}

