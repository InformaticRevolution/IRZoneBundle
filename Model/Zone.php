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
 * Abstract Zone implementation.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
abstract class Zone implements ZoneInterface
{
    /**
     * @var mixed
     */
    protected $id;
    
    /**
     * @var string
     */
    protected $name;

    /**
     * @var Boolean
     */
    protected $enabled = true;
    
 
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled()
    {
        return $this->enabled;
    }    
    
    /**
     * {@inheritdoc}
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }    
    
    /**
     * Returns the zone name.
     *
     * @return string
     */         
    public function __toString()
    {
        return (string) $this->getName();
    }    
}
