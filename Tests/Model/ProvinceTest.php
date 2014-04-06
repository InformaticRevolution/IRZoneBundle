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

use IR\Bundle\ZoneBundle\Model\CountryInterface;
use IR\Bundle\ZoneBundle\Model\ProvinceInterface;

/**
 * Province Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ProvinceTest extends \PHPUnit_Framework_TestCase
{
    public function testEnabled()
    {
        $province = $this->getProvince();
        
        $this->assertTrue($province->isEnabled());
        $province->setEnabled(false);
        $this->assertFalse($province->isEnabled());
    }
    
    /**
     * @dataProvider getSimpleTestData
     */
    public function testSimpleSettersGetters($property, $value, $default)
    {
        $getter = 'get'.$property;
        $setter = 'set'.$property;
        
        $province = $this->getProvince();
        
        $this->assertEquals($default, $province->$getter());
        $province->$setter($value);
        $this->assertEquals($value, $province->$getter());
    }
    
    public function getSimpleTestData()
    {
        return array(
            array('name', 'New York', null),
            array('code', 'NY', null),
            array('country', $this->getCountry() , null),
        );
    }
    
    public function testToString()
    {
        $province = $this->getProvince();
        
        $this->assertEquals('', $province);
        $province->setName('New York');
        $this->assertEquals('New York', $province);
    }    
    
    /**
     * @return ProvinceInterface
     */
    protected function getProvince()
    {
        return $this->getMockForAbstractClass('IR\Bundle\ZoneBundle\Model\Province');
    }
    
    /**
     * @return CountryInterface
     */
    protected function getCountry()
    {
        return $this->getMock('IR\Bundle\ZoneBundle\Model\CountryInterface');
    }       
}
