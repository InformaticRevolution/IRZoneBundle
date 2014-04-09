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
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Abstract Country implementation.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
abstract class Country implements CountryInterface
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
     * @var string
     */
    protected $isoCode;

    /**
     * @var ZoneInterface
     */
    protected $zone;    
    
    /**
     * @var Collection
     */
    protected $provinces;    
    
    /**
     * @var Boolean
     */
    protected $enabled = true;
    
 
    /**
     * Constructor.
     */    
    public function __construct() 
    {        
        $this->provinces = new ArrayCollection();
    }     
    
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
    public function getIsoCode()
    {
        return $this->isoCode;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setIsoCode($isoCode)
    {
        $this->isoCode = $isoCode;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getZone()
    {
        return $this->zone;
    }

    /**
     * {@inheritdoc}
     */
    public function setZone(ZoneInterface $zone = null)
    {
        $this->zone = $zone;
    }
    
    /**
     * {@inheritdoc}
     */
    public function hasProvinces()
    {
        return !$this->provinces->isEmpty();        
    }      
    
    /**
     * {@inheritdoc}
     */
    public function getProvinces()
    {
        return $this->provinces;
    }
    
    /**
     * {@inheritdoc}
     */
    public function addProvince(ProvinceInterface $province)
    {
        if (!$this->hasProvince($province)) {
            $province->setCountry($this);
            $this->provinces->add($province);
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function removeProvince(ProvinceInterface $province)
    {
        if ($this->provinces->removeElement($province)) {
            $province->setCountry(null);
        }        
    }
    
    /**
     * {@inheritdoc}
     */
    public function hasProvince(ProvinceInterface $province)
    {
        return $this->provinces->contains($province);
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
     * Returns the country name.
     *
     * @return string
     */         
    public function __toString()
    {
        return (string) $this->getName();
    }    
}
