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
        foreach ($endpoints as $key => $value) {
            $soapWsseReference = null;
            $soapWsse          = null;
            if (($value['wsse']['enabled'] === true)) {
                $soapWsse = 'amf_web_services_client.soap.wsse.'.$key;
                $container
                        ->setDefinition($soapWsse,
                                new DefinitionDecorator('amf_web_services_client.soap.wsse'))
                        ->replaceArgument(0, $value['wsse']['username'])
                        ->replaceArgument(1, $value['wsse']['password']);
                
                $soapWsseReference = new Reference($soapWsse);
            }

            $soapEndpoint = 'amf_web_services_client.soap.'.$key;
            $container->setDefinition($soapEndpoint,
                            new DefinitionDecorator('amf_web_services_client.soap.endpoint'))
                    ->setClass($value['class'])
                    ->replaceArgument(0, $value['wsdl'])
                    ->replaceArgument(1, $soapWsseReference)
                    ->replaceArgument(2, $value['options'])
                    ->replaceArgument(3, $value['wsse']['enabled']);
        }
    }
}
