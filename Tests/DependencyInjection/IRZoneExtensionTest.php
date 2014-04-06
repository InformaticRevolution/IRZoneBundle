<?php

/*
 * This file is part of the IRZoneBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ZoneBundle\Tests\DependencyInjection;

use Symfony\Component\Yaml\Parser;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use IR\Bundle\ZoneBundle\DependencyInjection\IRZoneExtension;

/**
 * Zone Extension Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class IRZoneExtensionTest extends \PHPUnit_Framework_TestCase
{
    /** 
     * @var ContainerBuilder
     */
    protected $configuration;
    
    
    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testZoneLoadThrowsExceptionUnlessDatabaseDriverSet()
    {
        $loader = new IRZoneExtension();
        $config = $this->getEmptyConfig();
        unset($config['db_driver']);
        $loader->load(array($config), new ContainerBuilder());
    }  
    
    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testZoneLoadThrowsExceptionUnlessDatabaseDriverIsValid()
    {
        $loader = new IRZoneExtension();
        $config = $this->getEmptyConfig();
        $config['db_driver'] = 'foo';
        $loader->load(array($config), new ContainerBuilder());
    }    

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testZoneLoadThrowsExceptionUnlessZoneModelClassSet()
    {
        $loader = new IRZoneExtension();
        $config = $this->getEmptyConfig();
        unset($config['zone_class']);
        $loader->load(array($config), new ContainerBuilder());
    }       
    
    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testZoneLoadThrowsExceptionUnlessCountryModelClassSet()
    {
        $loader = new IRZoneExtension();
        $config = $this->getEmptyConfig();
        unset($config['country_class']);
        $loader->load(array($config), new ContainerBuilder());
    }  
    
    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testZoneLoadThrowsExceptionUnlessRegionModelClassSet()
    {
        $loader = new IRZoneExtension();
        $config = $this->getEmptyConfig();
        unset($config['region_class']);
        $loader->load(array($config), new ContainerBuilder());
    }      

    public function testDisableZone()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new IRZoneExtension();
        $config = $this->getEmptyConfig();
        $config['zone'] = false;
        $loader->load(array($config), $this->configuration);
        $this->assertNotHasDefinition('ir_zone.form.zone');
    }     
    
    public function testDisableCountry()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new IRZoneExtension();
        $config = $this->getEmptyConfig();
        $config['country'] = false;
        $loader->load(array($config), $this->configuration);
        $this->assertNotHasDefinition('ir_zone.form.country');
    }  
    
    public function testDisableRegion()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new IRZoneExtension();
        $config = $this->getEmptyConfig();
        $config['region'] = false;
        $loader->load(array($config), $this->configuration);
        $this->assertNotHasDefinition('ir_zone.form.region');
    }      
    
    public function testZoneLoadModelClassWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('Acme\ZoneBundle\Entity\Zone', 'ir_zone.model.zone.class');
        $this->assertParameter('Acme\ZoneBundle\Entity\Country', 'ir_zone.model.country.class');
        $this->assertParameter('Acme\ZoneBundle\Entity\Region', 'ir_zone.model.region.class');
    }        
    
    public function testZoneLoadModelClass()
    {
        $this->createFullConfiguration();

        $this->assertParameter('Acme\ZoneBundle\Entity\Zone', 'ir_zone.model.zone.class');
        $this->assertParameter('Acme\ZoneBundle\Entity\Country', 'ir_zone.model.country.class');
        $this->assertParameter('Acme\ZoneBundle\Entity\Region', 'ir_zone.model.region.class');
    }      

    public function testZoneLoadManagerClassWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('orm', 'ir_zone.db_driver');
        $this->assertAlias('ir_zone.manager.zone.default', 'ir_zone.manager.zone');
        $this->assertAlias('ir_zone.manager.country.default', 'ir_zone.manager.country');
        $this->assertAlias('ir_zone.manager.region.default', 'ir_zone.manager.region');
    }   
    
    public function testZoneLoadManagerClass()
    {
        $this->createFullConfiguration();

        $this->assertParameter('orm', 'ir_zone.db_driver');
        $this->assertAlias('acme_zone.manager.zone', 'ir_zone.manager.zone');
        $this->assertAlias('acme_zone.manager.country', 'ir_zone.manager.country');
        $this->assertAlias('acme_zone.manager.region', 'ir_zone.manager.region');
    }       
    
    public function testZoneLoadFormClassWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('ir_zone', 'ir_zone.form.type.zone');
        $this->assertParameter('ir_zone_country', 'ir_zone.form.type.country');
        $this->assertParameter('ir_zone_region', 'ir_zone.form.type.region');
    }     
    
    public function testZoneLoadFormClass()
    {
        $this->createFullConfiguration();

        $this->assertParameter('acme_zone', 'ir_zone.form.type.zone');
        $this->assertParameter('acme_zone_country', 'ir_zone.form.type.country');
        $this->assertParameter('acme_zone_region', 'ir_zone.form.type.region');
    }    
   
    public function testZoneLoadFormNameWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('ir_zone_form', 'ir_zone.form.name.zone');
        $this->assertParameter('ir_zone_country_form', 'ir_zone.form.name.country');
        $this->assertParameter('ir_zone_region_form', 'ir_zone.form.name.region');
    }
    
    public function testZoneLoadFormName()
    {
        $this->createFullConfiguration();

        $this->assertParameter('acme_zone_form', 'ir_zone.form.name.zone');
        $this->assertParameter('acme_zone_country_form', 'ir_zone.form.name.country');
        $this->assertParameter('acme_zone_region_form', 'ir_zone.form.name.region');
    }
    
    public function testZoneLoadFormServiceWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertHasDefinition('ir_zone.form.zone');
        $this->assertHasDefinition('ir_zone.form.country');
        $this->assertHasDefinition('ir_zone.form.region');
    }
    
    public function testZoneLoadFormService()
    {
        $this->createFullConfiguration();

        $this->assertHasDefinition('ir_zone.form.zone'); 
        $this->assertHasDefinition('ir_zone.form.country'); 
        $this->assertHasDefinition('ir_zone.form.region'); 
    }
    
    public function testZoneLoadTemplateConfigWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('twig', 'ir_zone.template.engine');
    }      
    
    public function testZoneLoadTemplateConfig()
    {
        $this->createFullConfiguration();

        $this->assertParameter('php', 'ir_zone.template.engine');
    }      
    
    protected function createEmptyConfiguration()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new IRZoneExtension();
        $config = $this->getEmptyConfig();
        $loader->load(array($config), $this->configuration);
        $this->assertTrue($this->configuration instanceof ContainerBuilder);
    }      
    
    protected function createFullConfiguration()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new IRZoneExtension();
        $config = $this->getFullConfig();
        $loader->load(array($config), $this->configuration);
        $this->assertTrue($this->configuration instanceof ContainerBuilder);
    }       
    
    /**
     * @return array
     */
    protected function getEmptyConfig()
    {
        $parser = new Parser();
        
        return $parser->parse(file_get_contents(__DIR__.'/Fixtures/minimal_config.yml'));
    }    
    
    /**
     * @return array
     */    
    protected function getFullConfig()
    {
        $parser = new Parser();

        return $parser->parse(file_get_contents(__DIR__.'/Fixtures/full_config.yml'));
    }     
    
    /**
     * @param string $value
     * @param string $key
     */
    private function assertAlias($value, $key)
    {
        $this->assertEquals($value, (string) $this->configuration->getAlias($key), sprintf('%s alias is correct', $key));
    }      
     
    /**
     * @param mixed  $value
     * @param string $key
     */
    private function assertParameter($value, $key)
    {
        $this->assertEquals($value, $this->configuration->getParameter($key), sprintf('%s parameter is incorrect', $key));
    }    
    
    /**
     * @param string $id
     */
    private function assertHasDefinition($id)
    {
        $this->assertTrue(($this->configuration->hasDefinition($id) ?: $this->configuration->hasAlias($id)));
    }      
    
    /**
     * @param string $id
     */
    private function assertNotHasDefinition($id)
    {
        $this->assertFalse(($this->configuration->hasDefinition($id) ?: $this->configuration->hasAlias($id)));
    }    
            
    protected function tearDown()
    {
        unset($this->configuration);
    }     
}
