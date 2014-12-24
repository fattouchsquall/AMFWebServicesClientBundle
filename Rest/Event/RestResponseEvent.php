<?php

/**
 * The event for sharing request and response into listener.
 * 
 * @package AMFWebServicesClientBundle
 * @subpackage Event
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */

namespace AMF\WebServicesClientBundle\Event;

use Symfony\Component\EventDispatcher\Event;

use AMF\WebServicesClientBundle\Rest\Component\RestRequest;
use AMF\WebServicesClientBundle\Rest\Component\RestResponse;

/**
 * The event for sharing request and response into listener.
 * 
 * @package AMFWebServicesClientBundle
 * @subpackage Event
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
class RestResponseEvent extends Event
{
    
    /**
     * @var RestRequest
     */
    protected $restRequest;
    
    /**
     * @var RestResponse
     */
    protected $restResponse;

    
    /**
     * The constructor class.
     * 
     * @param RestRequest $restRequest Instance of api restRequest.
     */
    public function __construct(Request $restRequest)
    {
        $this->restRequest = $restRequest;
    }
            
    /**
     * Getter for restRequest.
     * 
     * @return RestRequest
     */
    public function getRestRequest()
    {
        return $this->restRequest;
    }

    /**
     * Getter for restResponse.
     * 
     * @return RestResponse
     */
    public function getRestResponse()
    {
        return $this->restResponse;
    }
    
    /**
     * Setter for restResponse.
     * 
     * @param RestResponse $restResponse Instance of api restResponse.
     * 
     * @return void
     */
    public function setRestResponse(RestResponse $restResponse)
    {
        $this->restResponse = $restResponse;
    }
}