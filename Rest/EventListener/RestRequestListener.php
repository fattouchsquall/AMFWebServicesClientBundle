<?php

/**
 * Handler of rest request.
 * 
 * @package AMFWebServicesClientBundle
 * @subpackage EventListener
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */

namespace AMF\WebServicesClientBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use AMF\WebServicesClientBundle\Event\RestResponseEvent;
use AMF\WebServicesClientBundle\Rest\Component\RestResponse;
use AMF\WebServicesClientBundle\Rest\Constant\RESTMethods;

/**
 * Handler of rest request.
 * 
 * @package AMFWebServicesClientBundle
 * @subpackage EventListener
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
class RestRequestListener implements EventSubscriberInterface
{
    
    /**
     * Sends a GET request to the webservice.
     * 
     * @param RestResponseEvent $restResponseEvent The rest response event.
     * 
     * @return void
     */
    public function onGetRequest(RestResponseEvent $restResponseEvent)
    {
        $this->performRequest($restResponseEvent, RESTMethods::HTTP_GET);
    }

    /**
     * Sends a POST request to the webservice.
     * 
     * @param RestResponseEvent $restResponseEvent The rest response event.
     * 
     * @return void
     */
    public function onPostRequest(RestResponseEvent $restResponseEvent)
    {
        $this->performRequest($restResponseEvent, RESTMethods::HTTP_POST);
    }
    
    /**
     * Sends a PUT request to the webservice.
     * 
     * @param RestResponseEvent $restResponseEvent The rest response event.
     * 
     * @return void
     */
    public function onPutRequest(FilterResponseEvent $restResponseEvent)
    {
        $this->performRequest($restResponseEvent, RESTMethods::HTTP_PUT);
    }
    
    /**
     * Sends a DELETE request to the webservice.
     * 
     * @param RestResponseEvent $restResponseEvent The rest response event.
     * 
     * @return void
     */
    public function onDeleteRequest(RestResponseEvent $restResponseEvent)
    {
        $this->performRequest($restResponseEvent, RESTMethods::HTTP_DELETE);
    }
}
