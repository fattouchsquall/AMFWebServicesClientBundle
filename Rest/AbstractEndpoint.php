<?php

/*
 * This file is part of the AMFWebServicesClientBundle package.
 *
 * (c) Amine Fattouch <http://github.com/fattouchsquall>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AMF\WebServicesClientBundle\Rest;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use AMF\WebServicesClientBundle\Rest\Exception\RestException;
use AMF\WebServicesClientBundle\Rest\Event\GetResponseEvent;
use AMF\WebServicesClientBundle\Rest\Component\Request;
use AMF\WebServicesClientBundle\Rest\Component\Url;
use AMF\WebServicesClientBundle\Rest\Security\Wsse;
use AMF\WebServicesClientBundle\Rest\Encoder\EncoderProviderInterface;
use AMF\WebServicesClientBundle\Rest\Decoder\DecoderProviderInterface;
use AMF\WebServicesClientBundle\Rest\Encoder\EncoderInterface;
use AMF\WebServicesClientBundle\Rest\Decoder\DecoderInterface;

/**
 * The endpoint of rest webservice.
 *
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
abstract class AbstractEndpoint
{
    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @var EncoderInterface
     */
    protected $encoder;

    /**
     * @var DecoderInterface
     */
    protected $decoder;

    /**
     * @var Url
     */
    protected $url;

    /**
     * @var Wsse
     */
    protected $wsse;

    /**
     * Constructor class.
     *
     * @param EventDispatcherInterface $dispatcher      The service of dispatcher.
     * @param EncoderProviderInterface $encoderProvider Instance of provider for the encoder.
     * @param DecoderProviderInterface $decoderProvider Instance of provider for the decoder.
     * @param Url                      $url             The url component for rest API.
     * @param Wsse                     $wsse            The generator of wsse header.
     * @param string                   $requestFormat   The format of request (default json).
     * @param string                   $responseFormat  The format of response (default json).
     */
    public function __construct(
        EventDispatcherInterface $dispatcher,
        EncoderProviderInterface $encoderProvider,
        DecoderProviderInterface $decoderProvider,
        Url $url = null,
        Wsse $wsse = null,
        $requestFormat = 'json',
        $responseFormat = 'json'
    ) {
        $this->dispatcher = $dispatcher;
        $this->encoder    = $encoderProvider->getEncoder($requestFormat);
        $this->decoder    = $decoderProvider->getDecoder($responseFormat);
        $this->url        = $url;
        $this->wsse       = $wsse;
    }

    /**
     * Calls Rest API method.
     *
     * @param string $event
     * @param string $path
     * @param array  $query
     * @param array  $request
     * @param array  $server
     *
     * @return RestResponse
     */
    public function call($event, $path = null, array $query = [], array $request = [], array $server = [])
    {
        $request = $this->prepareRequest($path, $query, $request, $server);

        $getResponseEvent = new GetResponseEvent($request);
        $this->dispatcher->dispatch($event, $getResponseEvent);

        $response = $getResponseEvent->getResponse();

        $content = $response->getContent();
        if ($response->isSuccess() === true) {
            $data = $this->decodeResponse($content);

            return $data;
        }

        throw new RestException($content);
    }

    /**
     * Prepares a request.
     *
     * @param string $actionPath The path of action.
     * @param array  $query      The query of url.
     * @param array  $request    The body post of request.
     * @param array  $server     The server parameters.
     *
     * @return Request
     */
    protected function prepareRequest($actionPath = null, array $query = [], array $request = [], array $server = [])
    {
        $uri = null;
        if (isset($this->wsse)) {
            $wsseHeader = $this->wsse->generateHeader();
            $server = array_merge($wsseHeader, $server);
        }

        if (isset($this->url)) {
            $uri = $this->url->getUriForPath($actionPath, $query);
        }

        if (!empty($request) && !isset($server['REQUEST_STRING'])) {
            $server['REQUEST_STRING'] = $this->encodeRequest($request);
        }

        $request = Request::create($uri, $query, $request, $server, 'json');

        return $request;
    }

    /**
     * Encodes request.
     *
     * @param array $request The request data (default empty).
     *
     * @return mixed
     */
    protected function encodeRequest(array $request = [])
    {
        return $this->encoder->encode($request);
    }

    /**
     * Decodes response.
     *
     * @param string $content The response's content (default null).
     *
     * @return mixed
     */
    protected function decodeResponse($content = null)
    {
        return $this->decoder->decode($content);
    }
}
