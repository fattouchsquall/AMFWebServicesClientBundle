Configuration Reference
=======================

All configuration options with default values are listed below:

```yaml
# app/config/config.yml

    amf_web_services_client:
        soap:
            endpoints
                my_client1:                    # This key's node will be used to name your service
                    class: ~
                    wsdl: ~
                    options:
                        trace:      true
                        exceptions: true
                        encoding:   "UTF-8"
                    wsse:
                        username: ~            # The username for soap client, do not set this if there's no security
                        password: ~            # The password for soap client, do not set this if there's no security
                my_client2:                                                   
                    class: ~
                    wsdl: ~
                ...
        rest:
            endpoints:
                my_client1:                         # This key's node will be used to name your service
                    class: ~
                    url:
                        hostname:        ~                    # The hostname for ReST web service to consume
                        scheme:          "http"               # can be only "http" or "https"
                        query_delimiter: "?"                  # can be only ? or /
                        port:            80                   # only integers allowed
                    wsse:
                        username: ~       # The wsse username of ReST web service, do not set this if there's no security
                        password: ~       # The wsse password of ReST web service, do not set this if there's no security
                        options:
                            nonce_length: 8
                            nonce_chars:  "0123456789abcdef"
                            encode_as_64: true
                    encoders:
                        json: amf_web_services_client.rest.encoder.json
                        xml:  amf_web_services_client.rest.encoder.xml
                    decoders:
                        json: amf_web_services_client.rest.decoder.json
                        xml:  amf_web_services_client.rest.decoder.xml
                    curl_options:
                        return_transfer: true
                        timeout:         30
                        ssl_verifypeer:  false
                        ssl_verifyhost:  false
                my_client2:                             # This key's node will be used to name your service
                    class: ~
                    wsdl: ~
                ...
```