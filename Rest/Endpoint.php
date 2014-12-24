<?php

/**
 * The endpoint of rest webservice.
 * 
 * @package AMFWebServicesClientBundle
 * @subpackage Security
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */

namespace AMF\WebServicesClientBundle\Rest;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use AMF\WebServicesClientBundle\Rest\Exception\RestException;
use AMF\WebServicesClientBundle\Rest\Event\GetResponseEvent;
use AMF\WebServicesClientBundle\Rest\Component\Request;
use AMF\WebServicesClientBundle\Rest\Component\Url;
use AMF\WebServicesClientBundle\Rest\Security\Wsse;

/**
 * The endpoint of rest webservice.
 * 
 * @package AMFWebServicesClientBundle
 * @subpackage Security
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
abstract class Endpoint
{
    
    /**
     * @var EventDispatcherInterface 
     */
    protected $dispatcher;
    
    /**
     * @var Url
     */
    protected $url;
    
    /**
     * @var Wsse
     */
    protected $wsse;
    
    /**
     * @var boolean
     */
    protected $isSecure;


    /**
     * Constructor class.
     * 
     * @param EventDispatcherInterface $dispatcher The service of dispatcher (default null).
     * @param Url                      $url        The url component for rest API (default null).
     * @param Wsse                     $wsse       The generator of wsse header (default null).
     * @param boolean                  $isSecure   Whether the rest api is secured or not (default false).
     */
    public function __construct(EventDispatcherInterface $dispatcher=null,
                                Url $url=null,
                                Wsse $wsse=null,
                                $isSecure=false)
    {
        $this->dispatcher = $dispatcher;
        $this->url        = $url;
        $this->wsse       = $wsse;
        $this->isSecure   = $isSecure;
    }
    
    /**
     * Calls Rest API method.
     * 
     * @param Request $request The current ReST request.
     * 
     * @return RestResponse
     */
    protected function call($event, $path, array $query=array(), array $request=array(), array $server=array())
    {   
        $request = $this->prepareRequest($path, $query, $request, $server);
        
        $getResponseEvent = new GetResponseEvent($request);
        $this->dispatcher->dispatch($event, $getResponseEvent);

        $response = $getResponseEvent->getResponse();
        
        if ($response->isSuccess() === true)
        {
            return $response->getContent();
        }
        
        throw new RestException($response->getContent());
    }
    
    /**
     * Prepares a request.
     * 
     * @param string $actionPath The path of action.
     * @param string $method     The http method.
     * @param array  $data       The parameters of action.
     * @param array  $server     The server parameters.
     * 
     * @return Request
     */
    protected function prepareRequest($actionPath, array $query=array(), array $request=array(), array $server=array())
    {   
        if ($this->isSecure === true)
        {
            $wsseHeader = $this->wsse->generateHeader();
            $server = array_merge($wsseHeader, $server);
        }
        
        $request = Request::create($this->url, $actionPath, $query, $request, $server);
        
        return $request;
    }
}