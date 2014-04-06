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
 * Zone Interface.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
interface ZoneInterface 
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
     * Checks whether the zone is enabled.
     * 
     * @return Boolean
     */
    public function isEnabled();
    
    /**
     * Sets the enabled status of the zone.
     * 
     * @param Boolean $enabled
     */
    public function setEnabled($enabled);
}
