Configuration Reference
=======================

All configuration options with default values are listed below:

```yaml
# app/config/config.yml

    nordnet_web_services_gateway:
        rest_clients:
            whatever:                               # Whatever you want but the name of webservice's client is recommanded.
                url:
                    host: ""                        # The host for webservice to consume.
                    scheme: "http"                  # can be only http or https
                    separator: "?"                  # can be only ? or /
                    port: 80                        # only integer
                wsse_security:
                    username: ~                     # The wsse username of webservice to consume.
                    password: ~                     # The wsse password of webservice to consume.
                options:
                    decode: false                   # Whether to json decode the returned response.
                    assoc: true                     # Whether to convert the decoded data to object
```