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
use IR\Bundle\ZoneBundle\Model\ProvinceInterface;
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
        
        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $country->getProvinces());
    }     
    
    public function testHasProvinces()
    {
        $country = $this->getCountry();
        $province = $this->getProvince();
        
        $this->assertFalse($country->hasProvinces());
        $country->addProvince($province);
        $this->assertTrue($country->hasProvinces());
    }    
    
    public function testAddProvince()
    {
        $country = $this->getCountry();
        $province = $this->getProvince();
        
        $this->assertNotContains($province, $country->getProvinces());
        $this->assertNull($province->getCountry());
        
        $country->addProvince($province);
        
        $this->assertContains($province, $country->getProvinces());
        $this->assertSame($country, $province->getCountry());
    }    
    
    public function testRemoveProvince()
    {
        $country = $this->getCountry();
        $province = $this->getProvince();
        $country->addProvince($province);
        
        $this->assertContains($province, $country->getProvinces());
        $this->assertSame($country, $province->getCountry());
        
        $country->removeProvince($province);
        
        $this->assertNotContains($province, $country->getProvinces());
        $this->assertNull($province->getCountry());
    }      
    
    public function testHasProvince()
    {
        $country = $this->getCountry();
        $province = $this->getProvince();
        
        $this->assertFalse($country->hasProvince($province));
        $country->addProvince($province);
        $this->assertTrue($country->hasProvince($province));
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
     * @return ProvinceInterface
     */
    protected function getProvince()
    {
        return $this->getMockForAbstractClass('IR\Bundle\ZoneBundle\Model\Province');
    }      
    
    /**
     * @return ZoneInterface
     */
    protected function getZone()
    {
        return $this->getMockForAbstractClass('IR\Bundle\ZoneBundle\Model\Zone');
    }        
}
