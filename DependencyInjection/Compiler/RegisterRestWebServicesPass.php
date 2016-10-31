<?php

/*
 * This file is part of the AMFWebServicesClientBundle package.
 *
 * (c) Amine Fattouch <http://github.com/fattouchsquall>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AMF\WebServicesClientBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Pass of compilation to register Rest webservices.
 *
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
class RegisterRestWebServicesPass implements CompilerPassInterface
{

    /**
     * Register rest webservices definition.
     *
     * @param ContainerBuilder $container Instance of container.
     */
    public function process(ContainerBuilder $container)
    {
        if ($container->hasParameter('amf_web_services_client.rest.endpoints') === false) {
            return;
        }

        $endpoints = $container->getParameter('amf_web_services_client.rest.endpoints');
        foreach ($endpoints as $key => $endpoint) {
            $restEndpoint = 'amf_web_services_client.rest.'.$key;
            $container->setDefinition($restEndpoint, new DefinitionDecorator('amf_web_services_client.rest.endpoint'))
                    ->setClass($endpoint['class'])
                    ->replaceArgument(3, $this->addUrlDefinition($container, $key, $endpoint['url']))
                    ->replaceArgument(4, $this->addWsseDefinition($container, $key, $endpoint['wsse']))
                    ->replaceArgument(5, $endpoint['request_format'])
                    ->replaceArgument(6, $endpoint['response_format']);
        }
    }

    /**
     * Adds wsse defintion to container only if it's enabled..
     *
     * @param ContainerInterface $container
     * @param string             $key
     * @param array              $wsse
     *
     * @return Reference|null
     */
    private function addWsseDefinition(ContainerInterface $container, $key, array $wsse)
    {
        if (($wsse['enabled'] === true)) {
            $restWsse = 'amf_web_services_client.rest.wsse.'.$key;
            $container
                    ->setDefinition($restWsse, new DefinitionDecorator('amf_web_services_client.rest.wsse'))
                    ->replaceArgument(0, $wsse['username'])
                    ->replaceArgument(1, $wsse['password'])
                    ->replaceArgument(2, $wsse['options']);

            return new Reference($restWsse);
        }

        return null;
    }

    /**
     * Adds url defintion to container only if it's enabled.
     *
     * @param ContainerInterface $container
     * @param string             $key
     * @param array              $wsse
     *
     * @return Reference|null
     */
    private function addUrlDefinition(ContainerInterface $container, $key, $url)
    {
        if (($url['enabled'] === true)) {
            $restUrl = 'amf_web_services_client.rest.url.'.$key;
            $container
                    ->setDefinition($restUrl, new DefinitionDecorator('amf_web_services_client.rest.url'))
                    ->replaceArgument(0, $url['hostname'])
                    ->replaceArgument(1, $url['scheme'])
                    ->replaceArgument(2, $url['port'])
                    ->replaceArgument(3, $url['query_delimiter']);

            return new Reference($restUrl);
        }

        return null;
    }
}
