<?php

/*
 * This file is part of the IRZoneBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ZoneBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * This class contains the configuration information for the bundle.
 *
 * This information is solely responsible for how the different configuration
 * sections are normalized, and merged.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ir_zone');

        $supportedDrivers = array('orm');
        
        $rootNode
            ->children()
                ->scalarNode('db_driver')
                    ->validate()
                        ->ifNotInArray($supportedDrivers)
                        ->thenInvalid('The driver %s is not supported. Please choose one of '.json_encode($supportedDrivers))
                    ->end()
                    ->cannotBeOverwritten()
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()  
                ->scalarNode('zone_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('country_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('province_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('zone_manager')->defaultValue('ir_zone.manager.zone.default')->end()
                ->scalarNode('country_manager')->defaultValue('ir_zone.manager.country.default')->end()
                ->scalarNode('province_manager')->defaultValue('ir_zone.manager.province.default')->end()
            ->end();        
        
        $this->addZoneSection($rootNode);
        $this->addCountrySection($rootNode);
        $this->addProvinceSection($rootNode);
        $this->addTemplateSection($rootNode);
        
        return $treeBuilder;
    } 

    private function addZoneSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('zone')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('type')->defaultValue('ir_zone')->end()
                                ->scalarNode('name')->defaultValue('ir_zone_form')->end()
                                ->arrayNode('validation_groups')
                                    ->prototype('scalar')->end()
                                    ->defaultValue(array('Zone', 'Default'))
                                ->end()                
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }     
    
    private function addCountrySection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('country')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('type')->defaultValue('ir_zone_country')->end()
                                ->scalarNode('name')->defaultValue('ir_zone_country_form')->end()
                                ->arrayNode('validation_groups')
                                    ->prototype('scalar')->end()
                                    ->defaultValue(array('Country', 'Default'))
                                ->end()                
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    } 
    
    private function addProvinceSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('province')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('type')->defaultValue('ir_zone_province')->end()
                                ->scalarNode('name')->defaultValue('ir_zone_province_form')->end()
                                ->arrayNode('validation_groups')
                                    ->prototype('scalar')->end()
                                    ->defaultValue(array('Province', 'Default'))
                                ->end()                
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }     
    
    private function addTemplateSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('template')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('engine')->defaultValue('twig')->end()
                    ->end()
                ->end()
            ->end();
    }      
}
