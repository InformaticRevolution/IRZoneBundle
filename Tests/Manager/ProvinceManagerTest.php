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

use IR\Bundle\ZoneBundle\Manager\ProvinceManagerInterface;

/**
 * Province Manager Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ProvinceManagerTest extends \PHPUnit_Framework_TestCase
{
    const PROVINCE_CLASS = 'IR\Bundle\ZoneBundle\Tests\TestProvince';
 
    /**
     * @var ProvinceManagerInterface
     */
    protected $provinceManager;      
    
    
    public function setUp()
    {
        $this->provinceManager = $this->getMockForAbstractClass('IR\Bundle\ZoneBundle\Manager\ProvinceManager');
        
        $this->provinceManager->expects($this->any())
            ->method('getClass')
            ->will($this->returnValue(static::PROVINCE_CLASS));        
    }
    
    public function testCreateProvince()
    {        
        $province = $this->provinceManager->createProvince();
        
        $this->assertInstanceOf(static::PROVINCE_CLASS, $province);
    }    
}
