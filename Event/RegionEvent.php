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
use IR\Bundle\ZoneBundle\Model\RegionInterface;

/**
 * Region Event.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class RegionEvent extends Event
{
    /**
     * @var RegionInterface
     */        
    protected $region;
    
    
   /**
    * Constructor.
    *
    * @param RegionInterface $region
    */         
    public function __construct(RegionInterface $region)
    {
        $this->region = $region;
    }

    /**
     * Returns the region.
     * 
     * @return RegionInterface
     */
    public function getRegion()
    {
        return $this->region;
    }
}