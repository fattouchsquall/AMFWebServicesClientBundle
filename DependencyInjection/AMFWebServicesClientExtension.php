<?php

namespace AMF\WebServicesClientBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AMFWebServicesClientExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        
//        if (!empty($config['rest_endpoints']))
//        {
//            $loader->load('rest_listeners.yml');
//            $loader->load('rest_endpoints.yml');
//            foreach ($config['rest_endpoints'] as $key => $value)
//            {
//                if (!empty($value['wsse']))
//                {
//                    $this->remapParametersNamespaces($value, $container, array('wsse' => "amf_webservices_client.rest.$key.wsse.%s")); 
//                    unset($value);
//                }
//                $this->remapParametersNamespaces($value, $container, array('' => "amf_webservices_client.rest.$key.%s"));
//            }
//        }
        
        if (!empty($config['soap_endpoints']))
        {
            $loader->load('soap_endpoint.yml');
            $container->setParameter('amf_webservices_client.soap.endpoints', $config['soap_endpoints']);
            foreach ($config['soap_endpoints'] as $key => $value)
            {
                if (($value['wsse']['enabled'] === true))
                {   
                    $this->remapParametersNamespaces($value, $container, array('wsse' => "amf_webservices_client.soap.$key.wsse.%s")); 
                    unset($value['wsse']);
                }
                
                $this->remapParametersNamespaces($value, $container, array('' => "amf_webservices_client.soap.$key.%s"));
            }
        }
        
    }
    
    /**
     * Maps parameters to add them in container.
     * 
     * @param array            $config     The gloabl config of the security bundle.
     * @param ContainerBuilder $container  The container for dependency injection.
     * @param array            $namespaces Config namespaces to add as parameters in the container.
     * 
     * @return void
     */
    protected function remapParametersNamespaces(array $config, ContainerBuilder $container, array $namespaces) 
    {
        foreach ($namespaces as $namespace => $map) 
        {
            if (isset($namespace) && strlen($namespace) > 0) 
            {
                if (!array_key_exists($namespace, $config)) 
                {
                    continue;
                }
                $namespaceConfig = $config[$namespace];
            }
            else
            {
                $namespaceConfig = $config;
            }
            
            foreach ($namespaceConfig as $name => $value) 
            {
                $container->setParameter(sprintf($map, $name), $value);
            }
        }
    }
}
