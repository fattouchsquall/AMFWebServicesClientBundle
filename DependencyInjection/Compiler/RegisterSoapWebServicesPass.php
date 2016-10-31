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
 * Pass of compilation to register Soap webservices.
 *
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
class RegisterSoapWebServicesPass implements CompilerPassInterface
{
    /**
     * Register soap webservices definition.
     *
     * @param ContainerBuilder $container Instance of container.
     */
    public function process(ContainerBuilder $container)
    {
        if ($container->hasParameter('amf_web_services_client.soap.endpoints') === false) {
            return;
        }

        $endpoints = $container->getParameter('amf_web_services_client.soap.endpoints');
        foreach ($endpoints as $key => $endpoint) {
            $soapClient = $container->getDefinition('amf_web_services_client.soap')
                                    ->replaceArgument(0, $endpoint['wsdl'])
                                    ->replaceArgument(0, $endpoint['options']);

            $soapEndpoint = 'amf_web_services_client.soap.'.$key;
            $container->setDefinition(
                $soapEndpoint,
                new DefinitionDecorator('amf_web_services_client.soap.endpoint')
            )
                    ->setClass($endpoint['class'])
                    ->replaceArgument(0, $soapClient)
                    ->replaceArgument(1, $this->addWsseDefinition($container, $key, $wsse))
                    ->replaceArgument(3, $endpoint['wsse']['enabled']);
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
            $soapWsse = 'amf_web_services_client.soap.wsse.'.$key;
            $container
                    ->setDefinition($soapWsse, new DefinitionDecorator('amf_web_services_client.soap.wsse'))
                    ->replaceArgument(0, $wsse['wsse']['username'])
                    ->replaceArgument(1, $wsse['wsse']['password']);

            return new Reference($restWsse);
        }

        return null;
    }
}
