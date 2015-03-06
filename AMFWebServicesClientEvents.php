<?php

/*
 * This file is part of the AMFWebServicesClientBundle package.
 *
 * (c) Amine Fattouch <http://github.com/fattouchsquall>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AMF\WebServicesClientBundle;

/**
 * The list of events.
 *
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
final class AMFWebServicesClientEvents
{
    const REST_GET_REQUEST    = 'amf_web_services_client.rest.request.http_get';
    const REST_POST_REQUEST   = 'amf_web_services_client.rest.request.http_post';
    const REST_PUT_REQUEST    = 'amf_web_services_client.rest.request.http_put';
    const REST_DELETE_REQUEST = 'amf_web_services_client.rest.request.http_delete';
}
