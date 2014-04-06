<?php

/*
 * This file is part of the IRZoneBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ZoneBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use IR\Bundle\ZoneBundle\Model\ZoneInterface;

/**
 * Zone Event.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ZoneEvent extends Event
{
    /**
     * @var ZoneInterface
     */        
    protected $zone;
    
    
   /**
    * Constructor.
    *
    * @param ZoneInterface $zone
    */         
    public function __construct(ZoneInterface $zone)
    {
        $this->zone = $zone;
    }

    /**
     * Returns the zone.
     * 
     * @return ZoneInterface
     */
    public function getZone()
    {
        return $this->zone;
    }
}