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
use IR\Bundle\ZoneBundle\Model\CountryInterface;

/**
 * Country Event.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class CountryEvent extends Event
{
    /**
     * @var CountryInterface
     */        
    protected $country;
    
    
   /**
    * Constructor.
    *
    * @param CountryInterface $country
    */         
    public function __construct(CountryInterface $country)
    {
        $this->country = $country;
    }

    /**
     * Returns the country.
     * 
     * @return CountryInterface
     */
    public function getCountry()
    {
        return $this->country;
    }
}