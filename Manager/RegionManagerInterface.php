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

use IR\Bundle\ZoneBundle\Model\RegionInterface;
use IR\Bundle\ZoneBundle\Model\CountryInterface;

/**
 * Region Manager Interface.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
interface RegionManagerInterface 
{
    /**
     * Creates an empty region instance.
     *
     * @param CountryInterface|null $country
     * 
     * @return RegionInterface
     */
    public function createRegion(CountryInterface $country = null);    

    /**
     * Finds a region by the given criteria.
     *
     * @param array $criteria
     *
     * @return RegionInterface|null
     */
    public function findRegionBy(array $criteria);      

    /**
     * Returns the region's fully qualified class name.
     *
     * @return string
     */
    public function getClass();    
}
