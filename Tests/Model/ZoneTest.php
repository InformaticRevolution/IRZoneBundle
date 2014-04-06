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

/**
 * Zone Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ZoneTest extends \PHPUnit_Framework_TestCase
{
    public function testName()
    {
        $zone = $this->getZone();
        
        $this->assertNull($zone->getName());
        $zone->setName('Europe');
        $this->assertEquals('Europe', $zone->getName());
    }
    
    public function testEnabled()
    {
        $zone = $this->getZone();
        
        $this->assertTrue($zone->isEnabled());
        $zone->setEnabled(false);
        $this->assertFalse($zone->isEnabled());
    }
    
    public function testToString()
    {
        $zone = $this->getZone();
        
        $this->assertEquals('', $zone);
        $zone->setName('Europe');
        $this->assertEquals('Europe', $zone);
    }    
    
    /**
     * @return ZoneInterface
     */
    protected function getZone()
    {
        return $this->getMockForAbstractClass('IR\Bundle\ZoneBundle\Model\Zone');
    }      
}
