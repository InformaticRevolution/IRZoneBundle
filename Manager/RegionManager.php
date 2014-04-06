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
 * Abstract Region Manager.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
abstract class RegionManager implements RegionManagerInterface
{
    /**
     * {@inheritDoc}
     */    
    public function createRegion(CountryInterface $country = null)
    {
        $class = $this->getClass();
        $region = new $class();
        $region->setCountry($country);
        
        return $region;
    }      
}
