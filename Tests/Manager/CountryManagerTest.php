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

use IR\Bundle\ZoneBundle\Manager\CountryManagerInterface;

/**
 * Country Manager Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class CountryManagerTest extends \PHPUnit_Framework_TestCase
{
    const COUNTRY_CLASS = 'IR\Bundle\ZoneBundle\Tests\TestCountry';
 
    /**
     * @var CountryManagerInterface
     */
    protected $countryManager;      
    
    
    public function setUp()
    {
        $this->countryManager = $this->getMockForAbstractClass('IR\Bundle\ZoneBundle\Manager\CountryManager');
        
        $this->countryManager->expects($this->any())
            ->method('getClass')
            ->will($this->returnValue(static::COUNTRY_CLASS));        
    }
    
    public function testCreateCountry()
    {        
        $country = $this->countryManager->createCountry();
        
        $this->assertInstanceOf(static::COUNTRY_CLASS, $country);
    }    
}
