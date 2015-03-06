<?php

/*
 * This file is part of the AMFWebServicesClientBundle package.
 *
 * (c) Amine Fattouch <http://github.com/fattouchsquall>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AMF\WebServicesClientBundle\Rest\EventListener;

use AMF\WebServicesClientBundle\Rest\Event\GetResponseEvent;
use AMF\WebServicesClientBundle\Rest\Component\Response;

/**
 * Listener for http rest requests.
 *
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
class HttpListener
{
    /**
     * @var array
     */
    protected $options;

    /**
     * @var resource
     */
    protected $curlHandle;

    /**
     * The constructor class.
     *
     * @param array $options Options for curl (default empty).
     */
    public function __construct(array $options = array())
    {
        $this->options = $options;
    }

    /**
     * Sends a GET request to the API.
     *
     * @param GetResponseEvent $getResponseEvent The event for sharing rest response and request.
     */
    public function onGetRequest(GetResponseEvent $getResponseEvent)
    {
        $this->curlHandle = curl_init();
        curl_setopt($this->curlHandle, CURLOPT_HTTPGET, true);

        $this->execute($getResponseEvent);
    }

    /**
     * Sends a POST request to the API.
     *
     * @param GetResponseEvent $getResponseEvent The event for sharing rest response and request.
     */
    public function onPostRequest(GetResponseEvent $getResponseEvent)
    {
        $this->curlHandle = curl_init();
        curl_setopt($this->curlHandle, CURLOPT_POST, true);

        $this->execute($getResponseEvent);
    }

    /**
     * Sends a PUT request to the API.
     *
     * @param GetResponseEvent $getResponseEvent The event for sharing rest response and request.
     */
    public function onPutRequest(GetResponseEvent $getResponseEvent)
    {
        $this->curlHandle = curl_init();
        curl_setopt($this->curlHandle, CURLOPT_CUSTOMREQUEST, 'PUT');

        $this->execute($getResponseEvent);
    }

    /**
     * Sends a DELETE request to the API.
     *
     * @param GetResponseEvent $getResponseEvent The event for sharing rest response and request.
     */
    public function onDeleteRequest(GetResponseEvent $getResponseEvent)
    {
        $this->curlHandle = curl_init();
        curl_setopt($this->curlHandle, CURLOPT_CUSTOMREQUEST, 'DELETE');

        $this->execute($getResponseEvent);
    }

    /**
     * Executes a curl request to the given url.
     *
     * @param GetResponseEvent $event The event for sharing rest response and request.
     */
    protected function execute(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $server  = $request->getServer();
        $headers = $request->buildHttpHeaders();

        $requestString = $server->get('REQUEST_STRING');
        if (!empty($requestString) && strlen($requestString) > 0) {
            curl_setopt($this->curlHandle, CURLOPT_POSTFIELDS, $requestString);
        }
        curl_setopt($this->curlHandle, CURLOPT_URL, $server->get('REQUEST_URI'));
        curl_setopt($this->curlHandle, CURLOPT_RETURNTRANSFER, $this->options['return_transfer']);
        curl_setopt($this->curlHandle, CURLOPT_TIMEOUT, $this->options['timeout']);
        curl_setopt($this->curlHandle, CURLOPT_SSL_VERIFYPEER, $this->options['ssl_verifypeer']);
        curl_setopt($this->curlHandle, CURLOPT_SSL_VERIFYHOST, $this->options['ssl_verifyhost']);
        curl_setopt($this->curlHandle, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($this->curlHandle);
        $info   = curl_getinfo($this->curlHandle);

        curl_close($this->curlHandle);
        unset($this->curlHandle);

        $response = Response::create($result, $info['http_code']);

        $event->setResponse($response);
    }
}
