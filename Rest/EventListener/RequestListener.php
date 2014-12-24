<?php

/**
 * Listener for rest requests.
 * 
 * @package AMFWebServicesClientBundle
 * @subpackage EventListener
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */

namespace AMF\WebServicesClientBundle\Rest\EventListener;

use AMF\WebServicesClientBundle\Rest\Component\Request;
use AMF\WebServicesClientBundle\Rest\Event\GetResponseEvent;
use AMF\WebServicesClientBundle\Rest\Component\Response;
use AMF\WebServicesClientBundle\Rest\Encoder\EncoderProviderInterface;
use AMF\WebServicesClientBundle\Rest\Decoder\DecoderProviderInterface;

/**
 * Listener for rest requests.
 * 
 * @package AMFWebServicesClientBundle
 * @subpackage EventListener
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
class RequestListener
{
    
    /**
     * @var EncoderProviderInterface
     */
    protected $encoderProvider;
    
    /**
     * @var DecoderProviderInterface
     */
    protected $decoderProvider;
    
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
     * @param EncoderProviderInterface $encoderProvider Instance of provider for the encoder.
     * @param DecoderProviderInterface $decoderProvider Instance of provider for the decoder.
     * @param array                    $options         Options for curl (default empty).
     */
    public function __construct(EncoderProviderInterface $encoderProvider, DecoderProviderInterface $decoderProvider, array $options=array())
    {
        $this->encoderProvider = $encoderProvider;
        $this->decoderProvier  = $decoderProvider;
        $this->options         = $options;
        $this->curlHandle      = curl_init();
    }
    
    /**
     * Sends a GET request to the API.
     * 
     * @param GetResponseEvent $getResponseEvent The event for sharing rest response and request.
     * 
     * @return void
     */
    public function onGetRequest(GetResponseEvent $getResponseEvent)
    {
        curl_setopt($this->curlHandle, CURLOPT_HTTPGET, true);
        
        $this->execute($getResponseEvent);
    }

    /**
     * Sends a POST request to the API.
     * 
     * @param GetResponseEvent $getResponseEvent The event for sharing rest response and request.
     * 
     * @return void
     */
    public function onPostRequest(GetResponseEvent $getResponseEvent)
    {
        $request = $getResponseEvent->getRequest();
        
        curl_setopt($this->curlHandle, CURLOPT_POST, true);
        // Get data for the post
        $this->buildRequestData($request);
        $this->execute($getResponseEvent);
    }
    
    /**
     * Sends a PUT request to the API.
     * 
     * @param GetResponseEvent $getResponseEvent The event for sharing rest response and request.
     * 
     * @return void
     */
    public function onPutRequest(GetResponseEvent $getResponseEvent)
    {
        $request = $getResponseEvent->getRequest();
        
        curl_setopt($this->curlHandle, CURLOPT_CUSTOMREQUEST, 'PUT');
        
        $this->buildRequestData($request);
        $this->execute($getResponseEvent);
    }
    
    /**
     * Sends a DELETE request to the API.
     * 
     * @param GetResponseEvent $getResponseEvent The event for sharing rest response and request.
     * 
     * @return void
     */
    public function onDeleteRequest(GetResponseEvent $getResponseEvent)
    {
        curl_setopt($this->curlHandle, CURLOPT_CUSTOMREQUEST, 'DELETE');
        
        $this->execute($getResponseEvent);
    }
    
    /**
     * Executes a curl request to the given url. 
     * 
     * @param GetResponseEvent $event The event for sharing rest response and request.
     * 
     * @return void
     */
    protected function execute(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $server  = $request->getServer();
        $headers = $this->buildHttpHeaders($request);
        
        curl_setopt($this->curlHandle, CURLOPT_URL, $server->get('REQUEST_URI'));
        curl_setopt($this->curlHandle, CURLOPT_RETURNTRANSFER, $this->options['return_transfer']);
        curl_setopt($this->curlHandle, CURLOPT_TIMEOUT, $this->options['timeout']);
        curl_setopt($this->curlHandle, CURLOPT_SSL_VERIFYPEER, $this->options['ssl_verifypeer']);
        curl_setopt($this->curlHandle, CURLOPT_SSL_VERIFYHOST, $this->options['ssl_verifyhost']);
        curl_setopt($this->curlHandle, CURLOPT_HTTPHEADER, $headers);  

        $result = curl_exec($this->curlHandle);
        $info   = curl_getinfo($this->curlHandle);

        curl_close($this->curlHandle);
       
        $response = Response::create($result, $info['http_code']);
        
        $event->setResponse($response);
    }
    
    /**
     * Builds the list of request paramaters.
     * 
     * @param array $request The data to pass to the URL.
     * 
     * @return string
     */
    protected function buildRequestData(Request $request)
    {
//        $format  = $request->getFormat();
        $encoder = $this->encoderProvider->getEncoder('json');
        $request = $request->getRequest();

        if (!empty($request)) 
        {
            $data = $encoder->encode($request->all());
            if (is_scalar($data)) 
            {
                curl_setopt($this->curlHandle, CURLOPT_POSTFIELDS, $data);
            }
            
//            throw new BadRequestHttpException('Invalid ' . $format . ' message received');
        }
    }
    
    /**
     * Builds http headers.
     * 
     * @return array
     */
    protected function buildHttpHeaders(Request $request)
    {
        $headers = $request->getHeaders()->all();
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
}
