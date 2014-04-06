<?php

/*
 * This file is part of the IRZoneBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ZoneBundle\Tests\Doctrine;

use IR\Bundle\ZoneBundle\Model\RegionInterface;
use IR\Bundle\ZoneBundle\Doctrine\RegionManager;

/**
 * Region Manager Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class RegionManagerTest extends \PHPUnit_Framework_TestCase
{
    const REGION_CLASS = 'IR\Bundle\ZoneBundle\Tests\TestRegion';
 
    /**
     * @var RegionManager
     */
    protected $regionManager;      
    
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $objectManager;
    
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $repository;    
    
    
    public function setUp()
    {
        if (!interface_exists('Doctrine\Common\Persistence\ObjectManager')) {
            $this->markTestSkipped('Doctrine Common has to be installed for this test to run.');
        }  
                
        $class = $this->getMock('Doctrine\Common\Persistence\Mapping\ClassMetadata');
        $this->objectManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $this->repository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
                
        $this->objectManager->expects($this->any())
            ->method('getRepository')
            ->with($this->equalTo(static::REGION_CLASS))
            ->will($this->returnValue($this->repository));        

        $this->objectManager->expects($this->any())
            ->method('getClassMetadata')
            ->with($this->equalTo(static::REGION_CLASS))
            ->will($this->returnValue($class));        
        
        $class->expects($this->any())
            ->method('getName')
            ->will($this->returnValue(static::REGION_CLASS));        
        
        $this->regionManager = new RegionManager($this->objectManager, static::REGION_CLASS);
    } 
    
    public function testFindRegionBy()
    {
        $criteria = array("foo" => "bar");
        
        $this->repository->expects($this->once())
            ->method('findOneBy')
            ->with($this->equalTo($criteria))
            ->will($this->returnValue(array()));

        $this->regionManager->findRegionBy($criteria);
    }

    public function testGetClass()
    {
        $this->assertEquals(static::REGION_CLASS, $this->regionManager->getClass());
    }    

    /**
     * @return RegionInterface
     */
    protected function getRegion()
    {
        $class = static::REGION_CLASS;

        return new $class();
    }      
}
