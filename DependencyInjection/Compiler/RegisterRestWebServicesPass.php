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
        foreach ($endpoints as $key => $value) {
            $restWsseReference = null;
            $restUrlReference  = null;
            if (($value['wsse']['enabled'] === true)) {
                $restWsse = 'amf_web_services_client.rest.wsse.'.$key;
                $container
                        ->setDefinition($restWsse,
                                new DefinitionDecorator('amf_web_services_client.rest.wsse'))
                        ->replaceArgument(0, $value['wsse']['username'])
                        ->replaceArgument(1, $value['wsse']['password'])
                        ->replaceArgument(2, $value['wsse']['options']);

                $restWsseReference = new Reference($restWsse);
            }

            if (($value['url']['enabled'] === true)) {
                $restUrl = 'amf_web_services_client.rest.url.'.$key;
                $container
                        ->setDefinition($restUrl,
                                new DefinitionDecorator('amf_web_services_client.rest.url'))
                        ->replaceArgument(0, $value['url']['hostname'])
                        ->replaceArgument(1, $value['url']['scheme'])
                        ->replaceArgument(2, $value['url']['port'])
                        ->replaceArgument(3, $value['url']['query_delimiter']);

                $restUrlReference = new Reference($restUrl);
            }

            $restEndpoint = 'amf_web_services_client.rest.'.$key;
            $container->setDefinition($restEndpoint,
                            new DefinitionDecorator('amf_web_services_client.rest.endpoint'))
                    ->setClass($value['class'])
                    ->replaceArgument(3, $restUrlReference)
                    ->replaceArgument(4, $restWsseReference)
                    ->replaceArgument(5, $value['request_format'])
                    ->replaceArgument(6, $value['response_format']);
        }
    }
}
