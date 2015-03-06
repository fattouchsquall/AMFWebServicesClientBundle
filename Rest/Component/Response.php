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

/**
 * This class represents a ReST Response.
 *
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
class Response
{
    /**
     * @var mixed
     */
    protected $content;

    /**
     * @var integer
     */
    protected $statusCode;

    /**
     * Constructor class.
     *
     * @param mixed   $content    The content of response.
     * @param integer $statusCode The status code of response.
     */
    public function __construct($content, $statusCode)
    {
        $this->content    = $content;
        $this->statusCode = $statusCode;
    }

    /**
     * Getter for content.
     *
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Getter for status code.
     *
     * @return integer
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * The setter for response format.
     *
     * @param string $format The response format.
     *
     * @void
     */
    public function setResponseFormat($format = 'json')
    {
        $this->format = $format;
    }

    /**
     * The getter the response format.
     *
     * @return string The response format.
     */
    public function getResponseFormat()
    {
        return $this->format;
    }

    /**
     * Tests whether the response is a valid json or not.
     *
     * @return boolean
     */
    public function isJson()
    {
        json_decode($this->content);

        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * Tests whether the response is a valid xml or not.
     *
     * @return boolean
     */
    public function isXml()
    {
        $loaded = simplexml_load_string($this->content);

        if ($loaded === false) {
            return false;
        }

        return true;
    }

    /**
     * Tests whether the response is ok or not.
     *
     * @return boolean
     */
    public function isSuccess()
    {
        return $this->statusCode >= 200 && $this->statusCode < 300;
    }

    /**
     * Tests whether there's a froward or not.
     *
     * @return boolean
     */
    public function isForward()
    {
        return $this->statusCode >= 300 && $this->statusCode < 400;
    }

    /**
     * Tests whether there's a client error.
     *
     * @return boolean
     */
    public function isClientError()
    {
        return $this->statusCode >= 400 && $this->statusCode < 500;
    }

    /**
     * Tests whether there's an internal error or not.
     *
     * @return boolean
     */
    public function isInternetError()
    {
        return $this->statusCode >= 500 && $this->statusCode < 600;
    }

    /**
     * Creates a response.
     *
     * @param mixed   $content    The content of response.
     * @param integer $statusCode The code status of response.
     *
     * @return \static
     */
    public static function create($content, $statusCode)
    {
        return new static($content, $statusCode);
    }
}
