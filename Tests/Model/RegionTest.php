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

use IR\Bundle\ZoneBundle\Model\RegionInterface;
use IR\Bundle\ZoneBundle\Model\CountryInterface;

/**
 * Region Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class RegionTest extends \PHPUnit_Framework_TestCase
{
    public function testEnabled()
    {
        $region = $this->getRegion();
        
        $this->assertTrue($region->isEnabled());
        $region->setEnabled(false);
        $this->assertFalse($region->isEnabled());
    }
    
    /**
     * @dataProvider getSimpleTestData
     */
    public function testSimpleSettersGetters($property, $value, $default)
    {
        $getter = 'get'.$property;
        $setter = 'set'.$property;
        
        $region = $this->getRegion();
        
        $this->assertEquals($default, $region->$getter());
        $region->$setter($value);
        $this->assertEquals($value, $region->$getter());
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
        $region = $this->getRegion();
        
        $this->assertEquals('', $region);
        $region->setName('New York');
        $this->assertEquals('New York', $region);
    }    
    
    /**
     * @return RegionInterface
     */
    protected function getRegion()
    {
        return $this->getMockForAbstractClass('IR\Bundle\ZoneBundle\Model\Region');
    }
    
    /**
     * @return CountryInterface
     */
    protected function getCountry()
    {
        return $this->getMock('IR\Bundle\ZoneBundle\Model\CountryInterface');
    }       
}
