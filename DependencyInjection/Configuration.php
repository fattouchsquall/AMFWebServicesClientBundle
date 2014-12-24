<?php

namespace AMF\WebServicesClientBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('amf_webservices_client');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.
        $this->addSoapEndpointSection($rootNode);
        $this->addRestEndpointSection($rootNode);
        return $treeBuilder;
    }
    
    /**
     * Adds the config of soap webservice to global config.
     * 
     * @param ArrayNodeDefinition $node The root element for the config nodes.
     * 
     * @return void
     */
    protected function addSoapEndpointSection(ArrayNodeDefinition $node)
    {
        $node->children()
                ->arrayNode('soap_endpoints')
                ->useAttributeAsKey('name')
                ->prototype('array')
                    ->children()
                        ->scalarNode('class')->defaultNull()->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('wsdl')->defaultNull()->isRequired()->cannotBeEmpty()->end()
                        ->arrayNode('options')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->booleanNode('trace')->defaultTrue()->end()
                                ->booleanNode('exceptions')->defaultTrue()->end()
                                ->scalarNode("encoding")->defaultValue("UTF-8")->end()
                            ->end()
                        ->end()
                        ->arrayNode('wsse')
                            ->addDefaultsIfNotSet()
                            ->canBeEnabled()
                            ->children()
                                ->scalarNode('username')->defaultNull()->end()
                                ->scalarNode('password')->defaultNull()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
    
    /**
     * Adds the config of rest webservice to global config.
     * 
     * @param ArrayNodeDefinition $node The root node of the config for this bundle.
     * 
     * @return void
     */
    private function addRestEndpointSection(ArrayNodeDefinition $node)
    {       
        $schemes = array('https', 'http');
        
        $node->children()
                ->arrayNode('rest_endpoints')
                ->useAttributeAsKey('identifier')
                ->addDefaultsIfNotSet()
                ->prototype('array')
                    ->children()
                        ->scalarNode('hostname')->defaultNull()->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('scheme')
                            ->defaultValue("http")
                            ->cannotBeEmpty()
                            ->validate()
                            ->ifNotInArray($schemes)
                                ->thenInvalid('Invalid scheme "%s", there must be http or https')
                            ->end()
                        ->end()
                        ->integerNode('port')->defaultValue(80)->min(0)->end()
                        ->arrayNode('wsse')
                            ->addDefaultsIfNotSet()
                            ->canBeEnabled()
                            ->children()
                                ->integerNode('nonce_length')->defaultValue(8)->min(1)->end()
                                ->scalarNode('nonce_chars')->defaultValue('0123456789abcdef')->end()
                                ->integerNode('encode_as_64')->defaultTrue->end()
                                ->scalarNode('username')->defaultNull()->end()
                                ->scalarNode('password')->defaultNull()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
