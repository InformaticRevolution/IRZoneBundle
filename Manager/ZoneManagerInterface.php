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

use IR\Bundle\ZoneBundle\Model\ZoneInterface;

/**
 * Zone Manager Interface.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
interface ZoneManagerInterface 
{
    /**
     * Creates an empty zone instance.
     *
     * @return ZoneInterface
     */
    public function createZone();    

    /**
     * Updates a zone.
     *
     * @param ZoneInterface $zone
     */
    public function updateZone(ZoneInterface $zone);    

    /**
     * Deletes a zone.
     *
     * @param ZoneInterface $zone
     */
    public function deleteZone(ZoneInterface $zone);       
    
    /**
     * Finds a zone by the given criteria.
     *
     * @param array $criteria
     *
     * @return ZoneInterface|null
     */
    public function findZoneBy(array $criteria);      
    
    /**
     * Finds zones by given criteria.
     * 
     * @param array        $criteria
     * @param array|null   $orderBy
     * @param integer|null $limite
     * @param integer|null $offset
     * 
     * @return array
     */
    public function findZonesBy(array $criteria, array $orderBy = null, $limite = null, $offset = null);      
    
    /**
     * Returns the zone's fully qualified class name.
     *
     * @return string
     */
    public function getClass();    
}
