<?php

/**
 * The list of events.
 * 
 * @package AMFWebServicesClientBundle
 * @subpackage WebServicesClientBundle
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */

namespace AMF\WebServicesClientBundle;

/**
 * The list of events.
 * 
 * @package AMFWebServicesClientBundle
 * @subpackage WebServicesClientBundle
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
final class AMFWebServicesClientEvents
{
    const REST_GET_REQUEST    = 'amf_webservices_client.rest.request.http_get';
    const REST_POST_REQUEST   = 'amf_webservices_client.rest.request.http_post';
    const REST_PUT_REQUEST    = 'amf_webservices_client.rest.request.http_put';
    const REST_DELETE_REQUEST = 'amf_webservices_client.rest.request.http_delete';
}
