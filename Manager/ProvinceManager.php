<?php

/*
 * This file is part of the IRZoneBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ZoneBundle\Manager;

use IR\Bundle\ZoneBundle\Model\CountryInterface;

/**
 * Abstract Province Manager.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
abstract class ProvinceManager implements ProvinceManagerInterface
{
    /**
     * {@inheritDoc}
     */    
    public function createProvince(CountryInterface $country = null)
    {
        $class = $this->getClass();
        $province = new $class();
        $province->setCountry($country);
        
        return $province;
    }      
}
