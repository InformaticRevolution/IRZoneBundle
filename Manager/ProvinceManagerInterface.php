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
use IR\Bundle\ZoneBundle\Model\ProvinceInterface;

/**
 * Province Manager Interface.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
interface ProvinceManagerInterface 
{
    /**
     * Creates an empty province instance.
     *
     * @param CountryInterface|null $country
     * 
     * @return ProvinceInterface
     */
    public function createProvince(CountryInterface $country = null);    

    /**
     * Finds a province by the given criteria.
     *
     * @param array $criteria
     *
     * @return ProvinceInterface|null
     */
    public function findProvinceBy(array $criteria);      

    /**
     * Returns the province's fully qualified class name.
     *
     * @return string
     */
    public function getClass();    
}
