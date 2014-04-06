<?php

/*
 * This file is part of the IRZoneBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ZoneBundle;

/**
 * Contains all events thrown in the IRZoneBundle.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
final class IRZoneEvents
{    
    /**
     * The ZONE_CREATE_COMPLETED event occurs after saving the zone in the zone creation process.
     *
     * The event listener method receives a IR\Bundle\ZoneBundle\Event\ZoneEvent instance.
     */
    const ZONE_CREATE_COMPLETED = 'ir_zone.admin.zone.create.completed';
    
    /**
     * The ZONE_EDIT_COMPLETED event occurs after saving the zone in the zone edit process.
     *
     * The event listener method receives a IR\Bundle\ZoneBundle\Event\ZoneEvent instance.
     */
    const ZONE_EDIT_COMPLETED = 'ir_zone.admin.zone.edit.completed';
    
    /**
     * The ZONE_DELETE_COMPLETED event occurs after deleting the zone.
     *
     * The event listener method receives a IR\Bundle\ZoneBundle\Event\ZoneEvent instance.
     */
    const ZONE_DELETE_COMPLETED = 'ir_zone.admin.zone.delete.completed';
    
    /**
     * The COUNTRY_CREATE_COMPLETED event occurs after saving the country in the country creation process.
     *
     * The event listener method receives a IR\Bundle\ZoneBundle\Event\CountryEvent instance.
     */
    const COUNTRY_CREATE_COMPLETED = 'ir_zone.admin.country.create.completed';
    
    /**
     * The COUNTRY_EDIT_COMPLETED event occurs after saving the country in the country edit process.
     *
     * The event listener method receives a IR\Bundle\ZoneBundle\Event\CountryEvent instance.
     */
    const COUNTRY_EDIT_COMPLETED = 'ir_zone.admin.country.edit.completed';
    
    /**
     * The COUNTRY_DELETE_COMPLETED event occurs after deleting the country.
     *
     * The event listener method receives a IR\Bundle\ZoneBundle\Event\CountryEvent instance.
     */
    const COUNTRY_DELETE_COMPLETED = 'ir_zone.admin.country.delete.completed';    
    
    /**
     * The REGION_CREATE_COMPLETED event occurs after saving the region in the region creation process.
     *
     * The event listener method receives a IR\Bundle\ZoneBundle\Event\RegionEvent instance.
     */
    const REGION_CREATE_COMPLETED = 'ir_zone.admin.region.create.completed';
    
    /**
     * The REGION_EDIT_COMPLETED event occurs after saving the region in the region edit process.
     *
     * The event listener method receives a IR\Bundle\ZoneBundle\Event\RegionEvent instance.
     */
    const REGION_EDIT_COMPLETED = 'ir_zone.admin.region.edit.completed';
    
    /**
     * The REGION_DELETE_COMPLETED event occurs after deleting the region.
     *
     * The event listener method receives a IR\Bundle\ZoneBundle\Event\RegionEvent instance.
     */
    const REGION_DELETE_COMPLETED = 'ir_zone.admin.region.delete.completed';        
}