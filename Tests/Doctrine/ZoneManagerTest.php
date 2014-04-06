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

use IR\Bundle\ZoneBundle\Model\ZoneInterface;
use IR\Bundle\ZoneBundle\Doctrine\ZoneManager;

/**
 * Zone Manager Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ZoneManagerTest extends \PHPUnit_Framework_TestCase
{
    const ZONE_CLASS = 'IR\Bundle\ZoneBundle\Tests\TestZone';
 
    /**
     * @var ZoneManager
     */
    protected $zoneManager;      
    
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
            ->with($this->equalTo(static::ZONE_CLASS))
            ->will($this->returnValue($this->repository));        

        $this->objectManager->expects($this->any())
            ->method('getClassMetadata')
            ->with($this->equalTo(static::ZONE_CLASS))
            ->will($this->returnValue($class));        
        
        $class->expects($this->any())
            ->method('getName')
            ->will($this->returnValue(static::ZONE_CLASS));        
        
        $this->zoneManager = new ZoneManager($this->objectManager, static::ZONE_CLASS);
    } 
    
    public function testUpdateZone()
    {
        $zone = $this->getZone();
        
        $this->objectManager->expects($this->once())
            ->method('persist')
            ->with($this->equalTo($zone));
        
        $this->objectManager->expects($this->once())
            ->method('flush');

        $this->zoneManager->updateZone($zone);
    } 
    
    public function testDeleteZone()
    {
        $zone = $this->getZone();
        
        $this->objectManager->expects($this->once())
            ->method('remove')
            ->with($this->equalTo($zone));
        
        $this->objectManager->expects($this->once())
            ->method('flush');

        $this->zoneManager->deleteZone($zone);
    }   
    
    public function testFindZoneBy()
    {
        $criteria = array("foo" => "bar");
        
        $this->repository->expects($this->once())
            ->method('findOneBy')
            ->with($this->equalTo($criteria))
            ->will($this->returnValue(array()));

        $this->zoneManager->findZoneBy($criteria);
    } 
    
    public function testFindZonesBy()
    {
        $criteria = array("foo" => "bar");
        $orderBy = array("foo" => "asc");
        $limit = 3;
        $offset = 0;
        
        $this->repository->expects($this->once())
            ->method('findBy')
            ->with(
                $this->equalTo($criteria), 
                $this->equalTo($orderBy), 
                $this->equalTo($limit), 
                $this->equalTo($offset)
            )
            ->will($this->returnValue(array()));

        $this->zoneManager->findZonesBy($criteria, $orderBy, $limit, $offset);
    }       
    
    public function testGetClass()
    {
        $this->assertEquals(static::ZONE_CLASS, $this->zoneManager->getClass());
    }    
    
    /**
     * @return ZoneInterface
     */
    protected function getZone()
    {
        $class = static::ZONE_CLASS;

        return new $class();
    }      
}
