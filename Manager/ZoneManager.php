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

/**
 * Abstract Zone Manager.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
abstract class ZoneManager implements ZoneManagerInterface
{
    /**
     * {@inheritDoc}
     */    
    public function createZone()
    {
        $class = $this->getClass();

        return new $class();
    }      
}
