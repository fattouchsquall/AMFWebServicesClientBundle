<?php

/**
 * This file is part of the AMFWebServicesClientBundle package.
 *
 * (c) Amine Fattouch <http://github.com/fattouchsquall>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AMF\WebServicesClientBundle\Rest\Component;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\ServerBag;

/**
 * This class represents a ReST Request.
 *
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
    public function __construct(array $request = array(), array $query = array(), array $server = array())
    {
        $this->init($request, $query, $server);
    }

    /**
     * Initializes current request.
     *
     * @param array $request The POST parameters (default empty).
     * @param array $query   The GET parameters (default empty).
     * @param array $server  The SERVER parameters (default empty).
     */
    public function init(array $request = array(), array $query = array(), array $server = array())
    {
        $this->request = new ParameterBag($request);
        $this->query   = new ParameterBag($query);
        $this->server  = new ServerBag($server);
        $this->headers = new HeaderBag($this->server->getHeaders());
    }

    /**
     * Create a static instance of this class.
     *
     * @param string $url     The uri.
     * @param string $query   The method of request.
     * @param array  $request The parameters of request.
     * @param array  $server  The server parameters.
     * @param string $format  The format of current request.
     *
     * @return \static
     */
    public static function create($uri = null, array $query = array(), array $request = array(), array $server = array(), $format = null)
    {
        if (!isset($server['HTTP_CONTENT_TYPE'])) {
            if (null === static::$formats) {
                static::initFormats();
            }
            if (array_key_exists($format, static::$formats)) {
                $server['HTTP_CONTENT_TYPE'] = static::$formats[$format];
            }
        }

        if (isset($server['REQUEST_STRING'])) {
            $server['HTTP_CONTENT_LENGTH'] = strlen($server['REQUEST_STRING']);
        }

        if (!isset($server['REQUEST_URI'])) {
            if (isset($uri)) {
                $server['REQUEST_URI'] = $uri;
            }
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
    public function buildHttpHeaders()
    {
        $headers = $this->headers->all();
        if (!isset($headers)) {
            return'';
        }

        $content = array();
        ksort($headers);
        foreach ($headers as $name => $values) {
            $name = implode('-', array_map('ucfirst', explode('-', $name)));
            foreach ($values as $value) {
                $content[] = sprintf("%s: %s", $name, $value);
            }
        }

        return $content;
    }
    /**
     * Initilizes the list of formats.
     */
    protected static function initFormats()
    {
        static::$formats = array(
            'html' => array('text/html'),
            'json' => array('application/json'),
            'xml' => array('application/xml'),
        );
    }
}
