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

use Doctrine\Common\Collections\Collection;

/**
 * Country Interface.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
interface CountryInterface 
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
     * Returns the ISO code.
     * 
     * @return string
     */
    public function getIsoCode();
    
    /**
     * Sets the ISO code.
     * 
     * @param string $isoCode
     */
    public function setIsoCode($isoCode);
    
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
     * Returns all the provinces.
     *
     * @return Collection
     */
    public function getProvinces(); 
    
    /**
     * Adds a province.
     *
     * @param ProvinceInterface $province
     */
    public function addProvince(ProvinceInterface $province);
    
    /**
     * Removes a province.
     *
     * @param ProvinceInterface $province
     */
    public function removeProvince(ProvinceInterface $province);    
    
    /**
     * Checks whether country has given province.
     *
     * @param ProvinceInterface $province
     *
     * @return Boolean
     */
    public function hasProvince(ProvinceInterface $province);    
    
    /**
     * Checks whether the country is enabled.
     * 
     * @return Boolean
     */
    public function isEnabled();
    
    /**
     * Sets the enabled status of the country.
     * 
     * @param Boolean $enabled
     */
    public function setEnabled($enabled);
}
