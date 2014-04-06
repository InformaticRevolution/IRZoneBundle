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

use IR\Bundle\ZoneBundle\Model\CountryInterface;
use IR\Bundle\ZoneBundle\Doctrine\CountryManager;

/**
 * Country Manager Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class CountryManagerTest extends \PHPUnit_Framework_TestCase
{
    const COUNTRY_CLASS = 'IR\Bundle\ZoneBundle\Tests\TestCountry';
 
    /**
     * @var CountryManager
     */
    protected $countryManager;      
    
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
            ->with($this->equalTo(static::COUNTRY_CLASS))
            ->will($this->returnValue($this->repository));        

        $this->objectManager->expects($this->any())
            ->method('getClassMetadata')
            ->with($this->equalTo(static::COUNTRY_CLASS))
            ->will($this->returnValue($class));        
        
        $class->expects($this->any())
            ->method('getName')
            ->will($this->returnValue(static::COUNTRY_CLASS));        
        
        $this->countryManager = new CountryManager($this->objectManager, static::COUNTRY_CLASS);
    } 
    
    public function testUpdateCountry()
    {
        $country = $this->getCountry();
        
        $this->objectManager->expects($this->once())
            ->method('persist')
            ->with($this->equalTo($country));
        
        $this->objectManager->expects($this->once())
            ->method('flush');

        $this->countryManager->updateCountry($country);
    } 

    public function testDeleteCountry()
    {
        $country = $this->getCountry();
        
        $this->objectManager->expects($this->once())
            ->method('remove')
            ->with($this->equalTo($country));
        
        $this->objectManager->expects($this->once())
            ->method('flush');

        $this->countryManager->deleteCountry($country);
    }   

    public function testFindCountryBy()
    {
        $criteria = array("foo" => "bar");
        
        $this->repository->expects($this->once())
            ->method('findOneBy')
            ->with($this->equalTo($criteria))
            ->will($this->returnValue(array()));

        $this->countryManager->findCountryBy($criteria);
    } 
    
    public function testFindCountriesBy()
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

        $this->countryManager->findCountriesBy($criteria, $orderBy, $limit, $offset);
    }       

    public function testGetClass()
    {
        $this->assertEquals(static::COUNTRY_CLASS, $this->countryManager->getClass());
    }    

    /**
     * @return CountryInterface
     */
    protected function getCountry()
    {
        $class = static::COUNTRY_CLASS;

        return new $class();
    }      
}
