<?php

/*
 * This file is part of the IRZoneBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ZoneBundle\Tests\Model;

use IR\Bundle\ZoneBundle\Model\ZoneInterface;
use IR\Bundle\ZoneBundle\Model\RegionInterface;
use IR\Bundle\ZoneBundle\Model\CountryInterface;

/**
 * Country Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class CountryTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $country = $this->getCountry();
        
        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $country->getRegions());
    }     
    
    public function testAddRegion()
    {
        $country = $this->getCountry();
        $region = $this->getRegion();
        
        $this->assertNotContains($region, $country->getRegions());
        $this->assertNull($region->getCountry());
        
        $country->addRegion($region);
        
        $this->assertContains($region, $country->getRegions());
        $this->assertSame($country, $region->getCountry());
    }    
    
    public function testRemoveRegion()
    {
        $country = $this->getCountry();
        $region = $this->getRegion();
        $country->addRegion($region);
        
        $this->assertContains($region, $country->getRegions());
        $this->assertSame($country, $region->getCountry());
        
        $country->removeRegion($region);
        
        $this->assertNotContains($region, $country->getRegions());
        $this->assertNull($region->getCountry());
    }      
    
    public function testHasRegion()
    {
        $country = $this->getCountry();
        $region = $this->getRegion();
        
        $this->assertFalse($country->hasRegion($region));
        $country->addRegion($region);
        $this->assertTrue($country->hasRegion($region));
    }    
    
    public function testEnabled()
    {
        $country = $this->getCountry();
        
        $this->assertTrue($country->isEnabled());
        $country->setEnabled(false);
        $this->assertFalse($country->isEnabled());
    }
    
    /**
     * @dataProvider getSimpleTestData
     */
    public function testSimpleSettersGetters($property, $value, $default)
    {
        $getter = 'get'.$property;
        $setter = 'set'.$property;
        
        $country = $this->getCountry();
        
        $this->assertEquals($default, $country->$getter());
        $country->$setter($value);
        $this->assertEquals($value, $country->$getter());
    }
    
    public function getSimpleTestData()
    {
        return array(
            array('name', 'France', null),
            array('isoCode', 'FR', null),
            array('zone', $this->getZone() , null),
        );
    }      
    
    public function testToString()
    {
        $country = $this->getCountry();
        
        $this->assertEquals('', $country);
        $country->setName('France');
        $this->assertEquals('France', $country);
    }       
    
    /**
     * @return CountryInterface
     */
    protected function getCountry()
    {
        return $this->getMockForAbstractClass('IR\Bundle\ZoneBundle\Model\Country');
    }  
    
    /**
     * @return RegionInterface
     */
    protected function getRegion()
    {
        return $this->getMockForAbstractClass('IR\Bundle\ZoneBundle\Model\Region');
    }      
    
    /**
     * @return ZoneInterface
     */
    protected function getZone()
    {
        return $this->getMockForAbstractClass('IR\Bundle\ZoneBundle\Model\Zone');
    }        
}
