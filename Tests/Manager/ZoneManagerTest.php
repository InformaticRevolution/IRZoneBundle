<?php

/*
 * This file is part of the IRZoneBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ZoneBundle\Tests\Manager;

use IR\Bundle\ZoneBundle\Manager\ZoneManagerInterface;

/**
 * Zone Manager Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ZoneManagerTest extends \PHPUnit_Framework_TestCase
{
    const ZONE_CLASS = 'IR\Bundle\ZoneBundle\Tests\TestZone';
 
    /**
     * @var ZoneManagerInterface
     */
    protected $zoneManager;      
    
    
    public function setUp()
    {
        $this->zoneManager = $this->getMockForAbstractClass('IR\Bundle\ZoneBundle\Manager\ZoneManager');
        
        $this->zoneManager->expects($this->any())
            ->method('getClass')
            ->will($this->returnValue(static::ZONE_CLASS));        
    }
    
    public function testCreateZone()
    {        
        $zone = $this->zoneManager->createZone();
        
        $this->assertInstanceOf(static::ZONE_CLASS, $zone);
    }    
}
