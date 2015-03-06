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

use AMF\WebServicesClientBundle\Rest\Constant\Schemes;

/**
 * This class represents a ReST Url.
 *
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
class Url
{
    /**
     * @var string
     */
    protected $hostname;

    /**
     * @var string
     */
    protected $scheme;

    /**
     * @var integer
     */
    protected $port;

    /**
     * @var string
     */
    protected $queryDelimiter;

    /**
     * The constructor class.
     *
     * @param string  $hostname       The hostname for url of Rest.
     * @param string  $scheme         The scheme for url of Rest.
     * @param integer $port           The port for url of Rest.
     * @param string  $queryDelimiter The query delimiter for url of Rest.
     */
    public function __construct($hostname, $scheme, $port, $queryDelimiter)
    {
        $this->hostname       = $hostname;
        $this->scheme         = $scheme;
        $this->port           = $port;
        $this->queryDelimiter = $queryDelimiter;
    }

    /**
     * The getter for hostname.
     *
     * @return string
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * The getter for scheme.
     *
     * @return string
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * The getter for port.
     *
     * @return integer
     */
    public function getPort()
    {
        if (isset($this->port) === false) {
            return Schemes::HTTPS === $this->getScheme() ? 443 : 80;
        }

        return (int) $this->port;
    }

    /**
     * The getter for queryDelimiter.
     *
     * @return string
     */
    public function getQueryDelimiter()
    {
        return $this->queryDelimiter;
    }

    /**
     * The getter for uri.
     *
     * @param string $path  The path of the url.
     * @param array  $query The query to pass to the URL (default empty).
     *
     * @return string
     */
    public function getUriForPath($path, array $query = array())
    {
        $formattedQuery = $this->buildQuery($query);
        $fullUri        = $this->buildBaseUrl().'/'.ltrim($path, '/').(isset($formattedQuery) && strlen($formattedQuery) > 0 ? $this->queryDelimiter.$formattedQuery : '');

        return $fullUri;
    }

    /**
     * Builds the full base url.
     *
     * @return string
     */
    protected function buildBaseUrl()
    {
        $hostname = $this->getHostname();

        if (strpos($hostname, '/') === false) {
            $hostname .= ':'.$this->getPort();
        }

        $baseUrl = $this->getScheme().'://'.$hostname;

        return trim($baseUrl, '/');
    }

    /**
     * Builds the list of query paramaters.
     *
     * @param array $query The data to pass to the URL (default empty).
     *
     * @return string
     */
    protected function buildQuery(array $query = array())
    {
        $formattedQuery = '';
        if (isset($query) && !empty($query)) {
            if ($this->queryDelimiter === '/') {
                $formattedQuery = implode($this->queryDelimiter, $query);
            } else {
                $formattedQuery = http_build_query($query, '', '&');
            }
        }

        return $formattedQuery;
    }
}
