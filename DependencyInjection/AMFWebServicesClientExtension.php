<?php

namespace AMF\WebServicesClientBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Config\Loader\LoaderInterface;

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
        
        $this->registerRestConfiguration($loader, $config, $container);
        $this->registerSoapConfiguration($loader, $config, $container);
    }
    
    /**
     * Loads Soap config.
     * 
     * @param LoaderInterface  $loader    The loader of file.
     * @param array            $config    The gloabl config of this bundle.
     * @param ContainerBuilder $container The container for dependency injection.
     * 
     * @return void
     */
    protected function registerSoapConfiguration(LoaderInterface $loader, array $config, ContainerBuilder $container)
    {
        if (!empty($config['soap']))
        {
            $loader->load('soap.yml');
            $container->setParameter('amf_web_services_client.soap.endpoints', $config['soap']['endpoints']);
            foreach ($config['soap']['endpoints'] as $key => $value)
            {
                if ($value['wsse']['enabled'] === true)
                {   
                    $this->remapParametersNamespaces($value, $container, array('wsse' => "amf_web_services_client.soap.$key.wsse.%s")); 
                    unset($value['wsse']);
                }
                
                $this->remapParametersNamespaces($value, $container, array('' => "amf_web_services_client.soap.$key.%s"));
            }
        }
    }
    
    /**
     * Loads ReST config.
     * 
     * @param LoaderInterface  $loader    The loader of file.
     * @param array            $config    The gloabl config of this bundle.
     * @param ContainerBuilder $container The container for dependency injection.
     * 
     * @return void
     */
    protected function registerRestConfiguration(LoaderInterface $loader, array $config, ContainerBuilder $container)
    {
        if (!empty($config['rest']))
        {
            $loader->load('listeners.yml');
            $loader->load('rest.yml');
            $container->setParameter('amf_web_services_client.rest.endpoints', $config['rest']['endpoints']);
            foreach ($config['rest']['endpoints'] as $key => $value)
            {
                if ($value['wsse']['enabled'] === true)
                {
                    $this->remapParametersNamespaces($value, $container, array('wsse' => "amf_web_services_client.rest.$key.wsse.%s")); 
                    unset($value['wsse']);
                }
                if ($value['url']['enabled'] === true)
                {
                    $this->remapParametersNamespaces($value, $container, array('url' => "amf_web_services_client.rest.$key.url.%s")); 
                    unset($value['url']);
                }
                
                $this->remapParametersNamespaces($value, $container, array('' => "amf_web_services_client.rest.$key.%s"));
            }
            
            $container->setParameter('amf_web_services_client.rest.decoders', $config['rest']['decoders']);
            $container->setParameter('amf_web_services_client.rest.encoders', $config['rest']['encoders']);
            $container->setParameter('amf_web_services_client.rest.curl_options', $config['rest']['curl_options']);
        }
    }


    /**
     * Maps parameters to add them in container.
     * 
     * @param array            $config     The gloabl config of this bundle.
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

