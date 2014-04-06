<?php

/*
 * This file is part of the IRZoneBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ZoneBundle\Model;

/**
 * Province Interface.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
interface ProvinceInterface 
{
    /**
     * Returns the id.
     * 
     * @return mixed
     */
    public function getId(); 

    /**
     * Returns the name.
     * 
     * @return string
     */
    public function getName();
    
    /**
     * Sets the name.
     * 
     * @param string $name
     */
    public function setName($name);
    
    /**
     * Returns the code.
     * 
     * @return string
     */
    public function getCode();
    
    /**
     * Sets the code.
     * 
     * @param string $code
     */
    public function setCode($code);
    
    /**
     * Returns the country.
     * 
     * @return CountryInterface
     */
    public function getCountry();

    /**
     * Sets the country.
     * 
     * @param CountryInterface|null $country
     */
    public function setCountry(CountryInterface $country = null);    
    
    /**
     * Returns the zone.
     * 
     * @return ZoneInterface
     */
    public function getZone();

    /**
     * Sets the zone.
     * 
     * @param ZoneInterface $zone
     */
    public function setZone(ZoneInterface $zone);    
    
    /**
     * Checks whether the province is enabled.
     * 
     * @return Boolean
     */
    public function isEnabled();
    
    /**
     * Sets the enabled status of the province.
     * 
     * @param Boolean $enabled
     */
    public function setEnabled($enabled);
}
