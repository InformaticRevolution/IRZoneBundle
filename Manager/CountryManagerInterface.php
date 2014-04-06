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
 * Country Manager Interface.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
interface CountryManagerInterface 
{
    /**
     * Creates an empty country instance.
     *
     * @return CountryInterface
     */
    public function createCountry();    

    /**
     * Updates a country.
     *
     * @param CountryInterface $country
     */
    public function updateCountry(CountryInterface $country);    

    /**
     * Deletes a country.
     *
     * @param CountryInterface $country
     */
    public function deleteCountry(CountryInterface $country);       
    
    /**
     * Finds a country by the given criteria.
     *
     * @param array $criteria
     *
     * @return CountryInterface|null
     */
    public function findCountryBy(array $criteria);      
    
    /**
     * Finds countries by given criteria.
     * 
     * @param array        $criteria
     * @param array|null   $orderBy
     * @param integer|null $limite
     * @param integer|null $offset
     * 
     * @return array
     */
    public function findCountriesBy(array $criteria, array $orderBy = null, $limite = null, $offset = null);      
    
    /**
     * Returns the country's fully qualified class name.
     *
     * @return string
     */
    public function getClass();    
}
