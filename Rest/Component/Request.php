<?php

/**
 * This class represents a ReST Request.
 * 
 * @package AMFWebServicesClientBundle
 * @subpackage Component
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */

namespace AMF\WebServicesClientBundle\Rest\Component;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\ServerBag;

/**
 * This class represents a ReST Request.
 * 
 * @package AMFWebServicesClientBundle
 * @subpackage Component
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
class Request
{

    /**
     * @var ParameterBag 
     */
    protected $request;

    /**
     * @var ParameterBag 
     */
    protected $query;

    /**
     * @var ParameterBag 
     */
    protected $server;

    /**
     * @var HeaderBag 
     */
    protected $headers;
    
    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $format;
    
    /**
     * @var array
     */
    protected static $formats;

    /**
     * The constructor class.
     * 
     * @param array $request The request parameters (default empty).
     * @param array $query   The query parameters (default empty).
     * @param array $server  The server parameters (default empty).
     */
    public function __construct(array $request=array(), array $query=array(), array $server=array())
    {
        $this->init($query, $request, $server);
    }
    
    /**
     * Sets the parameters for this request.
     *
     * @param array  $request The POST parameters
     * @param array  $query   The GET parameters.
     * @param array  $server  The SERVER parameters.
     *
     * @return void
     */
    public function init(array $request=array(), array $query=array(), array $server=array())
    {
        $this->request = new ParameterBag($request);
        $this->query   = new ParameterBag($query);
        $this->server  = new ServerBag($server);
        $this->headers = new HeaderBag($this->server->getHeaders());

        $this->requestUri = null;
        $this->baseUrl    = null;
        $this->basePath   = null;
        $this->method     = null;
        $this->format     = null;
    }
    
    /**
     * Create a static instance of this class.
     * 
     * @param Url    $url     The url component.
     * @param string $path    The path for request.
     * @param string $query   The method of request.
     * @param array  $request The parameters of request.
     * @param array  $server  The server parameters.
     * 
     * @return \static
     */
    public static function create(Url $url=null, $path=null, array $query=array(),
            array $request=array(),
            array $server=array())
    {   
        
        switch (strtoupper($method)) 
        {
            case 'POST':
            case 'PUT':
            case 'DELETE':
                if (!isset($server['CONTENT_TYPE'])) {
                    $server['CONTENT_TYPE'] = 'application/x-www-form-urlencoded';
                }
                // no break
            case 'PATCH':
                $request = $parameters;
                $query = array();
                break;
            default:
                $request = array();
                $query = $parameters;
                break;
        }
        if (!isset($server['HTTP_CONTENT_TYPE']))
        {
            $server['HTTP_CONTENT_TYPE'] = 'application/json';
        }

        if (!isset($server['REQUEST_URI']))
        {
            $server['REQUEST_URI'] = $url->getUriForPath($path, $query);
        }

        return new static($request, $query, $server);
    }

    /**
     * The getter for request.
     * 
     * @return ParameterBag
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * The getter for query.
     * 
     * @return ParameterBag
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * The getter for server.
     * 
     * @return ParameterBag
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * The getter for headers.
     * 
     * @return HeaderBag
     */
    public function getHeaders()
    {
        return $this->headers;
    }
     
    /**
     * Builds http headers.
     * 
     * @return array
     */
    public static function buildHttpHeaders()
    {
        $headers = $this->headers->all();
        if (empty($headers) === true)
        {
            return '';
        }

        $content = array();
        ksort($headers);
        foreach ($headers as $name => $values)
        {
            // capitalize each character
            $name = implode('-', array_map('ucfirst', explode('-', $name)));
            foreach ($values as $value)
            {
                $content[] = sprintf("%s: %s", $name, $value);
            }
        }
        return $content;
    }
    
    /**
     * Initilizes the list of formats.
     * 
     * @return void
     */
    protected static function initFormats()
    {
        static::$formats = array(
            'html' => array('text/html', 'application/xhtml+xml'),
            'json' => array('application/json', 'application/x-json'),
            'xml' => array('text/xml', 'application/xml', 'application/x-xml'),
        );
    }
}

