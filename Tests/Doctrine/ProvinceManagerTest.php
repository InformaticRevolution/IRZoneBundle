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

use IR\Bundle\ZoneBundle\Model\ProvinceInterface;
use IR\Bundle\ZoneBundle\Doctrine\ProvinceManager;

/**
 * Province Manager Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ProvinceManagerTest extends \PHPUnit_Framework_TestCase
{
    const PROVINCE_CLASS = 'IR\Bundle\ZoneBundle\Tests\TestProvince';
 
    /**
     * @var ProvinceManager
     */
    protected $provinceManager;      
    
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
            ->with($this->equalTo(static::PROVINCE_CLASS))
            ->will($this->returnValue($this->repository));        

        $this->objectManager->expects($this->any())
            ->method('getClassMetadata')
            ->with($this->equalTo(static::PROVINCE_CLASS))
            ->will($this->returnValue($class));        
        
        $class->expects($this->any())
            ->method('getName')
            ->will($this->returnValue(static::PROVINCE_CLASS));        
        
        $this->provinceManager = new ProvinceManager($this->objectManager, static::PROVINCE_CLASS);
    } 
    
    public function testFindProvinceBy()
    {
        $criteria = array("foo" => "bar");
        
        $this->repository->expects($this->once())
            ->method('findOneBy')
            ->with($this->equalTo($criteria))
            ->will($this->returnValue(array()));

        $this->provinceManager->findProvinceBy($criteria);
    }

    public function testGetClass()
    {
        $this->assertEquals(static::PROVINCE_CLASS, $this->provinceManager->getClass());
    }    

    /**
     * @return ProvinceInterface
     */
    protected function getProvince()
    {
        $class = static::PROVINCE_CLASS;

        return new $class();
    }      
}
