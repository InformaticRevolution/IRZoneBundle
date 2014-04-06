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

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

/**
 * Zone Extension.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class IRZoneExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config')); 
        
        foreach (array('zone', 'country', 'province') as $basename) {
            $loader->load(sprintf('driver/%s/%s.xml', $config['db_driver'], $basename));
        }
        
        $loader->load('listener.xml');
        
        $container->setParameter('ir_zone.db_driver', $config['db_driver']);
        $container->setParameter('ir_zone.model.zone.class', $config['zone_class']);
        $container->setParameter('ir_zone.model.country.class', $config['country_class']);
        $container->setParameter('ir_zone.model.province.class', $config['province_class']);
        $container->setParameter('ir_zone.template.engine', $config['template']['engine']);
        $container->setParameter('ir_zone.backend_type_' . $config['db_driver'], true);
        
        $container->setAlias('ir_zone.manager.zone', $config['zone_manager']);
        $container->setAlias('ir_zone.manager.country', $config['country_manager']);
        $container->setAlias('ir_zone.manager.province', $config['province_manager']);

        if (!empty($config['zone'])) {
            $this->loadZone($config['zone'], $container, $loader);
        }            
        
        if (!empty($config['country'])) {
            $this->loadCountry($config['country'], $container, $loader);
        }  
        
        if (!empty($config['province'])) {
            $this->loadProvince($config['province'], $container, $loader);
        }          
    }    

    private function loadZone(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {        
        $loader->load('zone.xml');
        
        $container->setParameter('ir_zone.form.name.zone', $config['form']['name']);
        $container->setParameter('ir_zone.form.type.zone', $config['form']['type']);
        $container->setParameter('ir_zone.form.validation_groups.zone', $config['form']['validation_groups']);
    }     
    
    private function loadCountry(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {        
        $loader->load('country.xml');
        
        $container->setParameter('ir_zone.form.name.country', $config['form']['name']);
        $container->setParameter('ir_zone.form.type.country', $config['form']['type']);
        $container->setParameter('ir_zone.form.validation_groups.country', $config['form']['validation_groups']);
    }   
    
    private function loadProvince(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {        
        $loader->load('province.xml');
        
        $container->setParameter('ir_zone.form.name.province', $config['form']['name']);
        $container->setParameter('ir_zone.form.type.province', $config['form']['type']);
        $container->setParameter('ir_zone.form.validation_groups.province', $config['form']['validation_groups']);
    }       
}
