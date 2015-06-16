Getting started with AMFWebServiceClientBundle
=======================================

1) Installation
----------------------------------

> ***Note*** AMFWebServiceClientBundle requires curl to be installed to correctly run.

The first step is to tell composer that you want to download AMFWebServiceClientBundle which can
be achieved by entering the following line at the command prompt:

```bash
    $ php composer.phar require amf/webservices-client-bundle: ~1.0
```

Then, run Composer to download and install the bundle:

```bash
    $ php composer.phar update amf/webservices-client-bundle
```

After the download of the files is achieved, register the bundle in `app/AppKernel.php`:

```php
# app/AppKernel.php

public function registerBundles()
{
    return array(
        // ...
        new AMF\WebServicesClientBundle\AMFWebServicesClientBundle(),
    );
}
```

2) Configuration
-------------------------------

Now that you have properly installed the bundle, the next step is to configure it to work with the specific needs of your application.

> ***Note*** This conf can change between environments (production, development, release...). 

First of all, you must add the following minimal configuration to your `config.yml` file:

```yaml
# app/config/config.yml
    
amf_web_services_client:
    # SOAP section
    soap:
        endpoints:
            my_client:                                                       # This key's node will be used to name your service
                class: MyCompany\MyBundle\Soap\MyClient
                wsdl: http://my_webservice.com/file.wsdl
                wsse:
                    username: 'test'                                      # The username for soap client, do not set this if there's no security
                    password: 'test'                                      # The password for soap client, do not set this if there's no security
    # ReST section
    rest:
        endpoints: 
            my_client:                                                      # This key's node will be used to name your service
                class: MyCompany\MyBundle\Rest\MyClient
                url:
                    hostname: http://my_webservice.com
                wsse:
                    username: 'my username'                      # The username for rest client, do not set this if there's no security
                    password: 'my password'                       # The password for rest client, do not set this if there's no security
```

[Read the whole configuration reference](01-config-reference.md)

In SOAP section, If you declare the key of your web service in this config "my\_client", the id of service to be used for SOAP will be generated like this: `amf_web_services_client.soap.my_client`
The same thing for ReST section, if you use "my\_client" as key, you'll have a service with an id `amf_web_services_client.rest.my_client` for this web service.

3) Usage
-------------------------------

### SOAP
#### Step 1: Create the client class of web service

First of all, you must create a client class that extends the base endpoint class for SOAP client.

> ***Note*** This is just an prototype, all methods are used here only for illustrate the way of implementing a SOAP client.

```php
# src/MyCompany/MyBundle/Soap

<?php

namespace MyCompany\MyBundle\Soap;

use AMF\WebServicesClientBundle\Soap\Endpoint;
use AMF\WebServicesClientBundle\Soap\Security\Wsse;

class MyClient extends Endpoint
{
    
    /**
     * Only a protoype.
     * 
     * @param array $data The param's data.
     * 
     * @return boolean
     */
    public function myMethod(array $data=array())
    {
        // build the request array to send
        $params = array('params' => $data);
        
        $methodName = __FUNCTION__;        
        $success    = true;
        try
        {
            $this->call($methodName, $params);
        }
        catch (\SoapFault $exception)
        {
            $reflexiveMyClient = new \ReflectionObject($this);
            $className         = $reflexiveMyClient->getName();
            $this->wsLogger->logException($className, $methodName, $exception->getMessage());
            
            $success = false;
            throw $exception;
        }
        return $success; 
    }
}
```

#### Step 2: Using inside your Controller

After creating the class of client, all services are automatically generated in accordance with keys in your `config.yml`.  

Now you can use it to call your SOAP API as below:

```php
# src/MyCompoany/MyBundle/Controller/MyController.php

    public function myAction(Request $request)
    {
        $data = $request->get('data');
        // be sure to use the same key as defined in `config.yml` to call your service
        $responseData = $this->get('amf_web_services_client.soap.my_client')->myMethod($data);
    }
```
### ReST
#### Step 1: Create the client class of web service

First of all, you must create a client class that extends the base endpoint class for ReST client.

> ***Note*** This is just an prototype, all methods are used here only for illustrate the way of implementing a ReST client.

```php
# src/MyCompany/MyBundle/Rest

<?php

namespace MyCompany\MyBundle\Rest;

use AMF\WebServicesClientBundle\AMFWebServicesClientEvents;
use AMF\WebServicesClientBundle\Rest\Endpoint;

class MyClient extends Endpoint
{
    
    /**
     * Only a protoype.
     * 
     * @param array $data The query data.
     * 
     * @return \stdClass
     */
    public function myGetMethod(array $data=array())
    {
        // build the request array to send
        $queryData = array('params' => $data);
        
        // you must provide the relative path of webservice method
        $responseData = $this->call(AMFWebServicesClientEvents::REST_GET_REQUEST, /relative_path_rest_client, $queryData, array());
        
        return $responseData;
    }

  /**
     * Only a prototype.
     * 
     * @param array $data The request data.
     * 
     * @return \stdClass
     */
    public function myPostMethod(array $data=array())
    {   
        $requestData = array('params' => $data);
        // you must provide the relative path of webservice method
        $responseData = $this->call(AMFWebServicesClientEvents::REST_POST_REQUEST, /relative_path_rest_client, array(), $requestData);
        
        return $responseData;
    }
}
```

#### Step 2: Using inside your Controller

After creating the class of client, all services are automatically generated in accordance with keys in your `config.yml`.  

Now you can use it to call your ReST API as below:

```php
# src/MyCompoany/MyBundle/Controller/MyController.php

    public function myAction(Request $request)
    {
        $data = $request->get('data');
        // be sure to use the same key as defined in `config.yml` to call your service
        $responsePostData = $this->get('amf_web_services_client.rest.my_client')->myPostMethod($data);
        $responseGetData = $this->get('amf_web_services_client.rest.my_client')->myGetMethod($data);
    }
```

4) Dependency
-------------------------------

This bundle needs that the extension php curl to be installed to correctly run.