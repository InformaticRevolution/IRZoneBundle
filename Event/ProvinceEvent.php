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
use IR\Bundle\ZoneBundle\Model\ProvinceInterface;

/**
 * Province Event.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ProvinceEvent extends Event
{
    /**
     * @var ProvinceInterface
     */        
    protected $province;
    
    
   /**
    * Constructor.
    *
    * @param ProvinceInterface $province
    */         
    public function __construct(ProvinceInterface $province)
    {
        $this->province = $province;
    }

    /**
     * Returns the province.
     * 
     * @return ProvinceInterface
     */
    public function getProvince()
    {
        return $this->province;
    }
}