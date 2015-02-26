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
        $rootNode = $treeBuilder->root('amf_web_services_client');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.
        $this->addSoapSection($rootNode);
        $this->addRestSection($rootNode);
        return $treeBuilder;
    }
    
    /**
     * Adds the config of soap to global config.
     * 
     * @param ArrayNodeDefinition $node The root element for the config nodes.
     * 
     * @return void
     */
    protected function addSoapSection(ArrayNodeDefinition $node)
    {
        $node->children()
                ->arrayNode('soap')
                ->addDefaultsIfNotSet()
                ->children()
                    ->arrayNode('endpoints')
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
                ->end()
            ->end();
    }
    
    /**
     * Adds the config of rest to global config.
     * 
     * @param ArrayNodeDefinition $node The root node of the config for this bundle.
     * 
     * @return void
     */
    private function addRestSection(ArrayNodeDefinition $node)
    {       
        $schemes    = array('https', 'http');
        $delimiters = array('/', '?');
        
        $node->children()
                ->arrayNode('rest')
                ->addDefaultsIfNotSet()
                ->children()
                    ->arrayNode('decoders')
                        ->useAttributeAsKey('name')
                        ->defaultValue(array('json' => 'amf_web_services_client.rest.decoder.json', 'xml' => 'amf_web_services_client.rest.decoder.xml'))
                        ->prototype('scalar')->end()
                    ->end()
                    ->arrayNode('encoders')
                        ->useAttributeAsKey('name')
                        ->defaultValue(array('json' => 'amf_web_services_client.rest.encoder.json', 'xml' => 'amf_web_services_client.rest.encoder.xml'))
                        ->prototype('scalar')->end()
                    ->end()
                    ->arrayNode('curl_options')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->booleanNode('return_transfer')->defaultTrue()->end()
                            ->integerNode('timeout')->defaultValue(30)->end()
                            ->booleanNode("ssl_verifypeer")->defaultFalse()->end()
                            ->booleanNode("ssl_verifyhost")->defaultFalse()->end()
                        ->end()
                    ->end()
                    ->arrayNode('endpoints')
                    ->useAttributeAsKey('identifier')
                    ->prototype('array')
                        ->children()
                            ->arrayNode('url')
                                ->addDefaultsIfNotSet()
                                ->canBeEnabled()
                                ->children()
                                    ->scalarNode('hostname')->defaultNull()->isRequired()->cannotBeEmpty()->end()
                                    ->scalarNode('scheme')
                                        ->defaultValue("http")
                                        ->cannotBeEmpty()
                                        ->validate()
                                        ->ifNotInArray($schemes)
                                            ->thenInvalid('Invalid scheme: "%s", there must be http or https')
                                        ->end()
                                    ->end()
                                    ->integerNode('port')->defaultValue(80)->min(0)->end()
                                    ->scalarNode('query_delimiter')
                                        ->defaultValue("?")
                                        ->cannotBeEmpty()
                                        ->validate()
                                        ->ifNotInArray($delimiters)
                                            ->thenInvalid('Invalid query separator: "%s", there must be ? or /')
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                            ->arrayNode('wsse')
                                ->addDefaultsIfNotSet()
                                ->canBeEnabled()
                                ->children()
                                    ->scalarNode('username')->defaultNull()->end()
                                    ->scalarNode('password')->defaultNull()->end()
                                    ->arrayNode('options')
                                        ->addDefaultsIfNotSet()
                                        ->children()
                                            ->integerNode('nonce_length')->defaultValue(8)->min(1)->isRequired()->cannotBeEmpty()->end()
                                            ->scalarNode('nonce_chars')->defaultValue('0123456789abcdef')->end()
                                            ->booleanNode('encode_as_64')->defaultTrue()->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                            ->scalarNode('class')->defaultNull()->isRequired()->cannotBeEmpty()->end()
                            ->scalarNode('request_format')->defaultValue('json')->end()
                            ->scalarNode('response_format')->defaultValue('json')->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
