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

use IR\Bundle\ZoneBundle\Manager\RegionManagerInterface;

/**
 * Region Manager Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class RegionManagerTest extends \PHPUnit_Framework_TestCase
{
    const REGION_CLASS = 'IR\Bundle\ZoneBundle\Tests\TestRegion';
 
    /**
     * @var RegionManagerInterface
     */
    protected $regionManager;      
    
    
    public function setUp()
    {
        $this->regionManager = $this->getMockForAbstractClass('IR\Bundle\ZoneBundle\Manager\RegionManager');
        
        $this->regionManager->expects($this->any())
            ->method('getClass')
            ->will($this->returnValue(static::REGION_CLASS));        
    }
    
    public function testCreateRegion()
    {        
        $region = $this->regionManager->createRegion();
        
        $this->assertInstanceOf(static::REGION_CLASS, $region);
    }    
}
