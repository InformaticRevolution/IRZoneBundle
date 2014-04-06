<?php

/*
 * This file is part of the IRZoneBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ZoneBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

use IR\Bundle\ZoneBundle\Model\CountryInterface;
use IR\Bundle\ZoneBundle\Manager\CountryManager as AbstractCountryManager;

/**
 * Doctrine Country Manager.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class CountryManager extends AbstractCountryManager
{
    /**
     * @var ObjectRepository
     */          
    protected $objectManager;
    
    /**
     * @var ObjectRepository
     */           
    protected $repository;    

    /**
     * @var string
     */           
    protected $class;  
    
    
   /**
    * Constructor.
    *
    * @param ObjectManager $om
    * @param string        $class
    */        
    public function __construct(ObjectManager $om, $class)
    {                   
        $this->objectManager = $om;
        $this->repository = $om->getRepository($class);
        
        $metadata = $om->getClassMetadata($class);
        $this->class = $metadata->getName();       
    }    

    /**
     * Updates a country.
     *
     * @param CountryInterface $country
     * @param Boolean          $andFlush Whether to flush the changes (default true)
     */    
    public function updateCountry(CountryInterface $country, $andFlush = true)
    { 
        $this->objectManager->persist($country);
   
        if ($andFlush) {
            $this->objectManager->flush();
        }        
    }    

    /**
     * {@inheritDoc}
     */     
    public function deleteCountry(CountryInterface $country)
    {
        $this->objectManager->remove($country);
        $this->objectManager->flush();      
    }         
    
    /**
     * {@inheritDoc}
     */
    public function findCountryBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }         
    
    /**
     * {@inheritdoc}
     */    
    public function findCountriesBy(array $criteria, array $orderBy = null, $limite = null, $offset = null) 
    {
        return $this->repository->findBy($criteria, $orderBy, $limite, $offset);
    }     
    
    /**
     * {@inheritDoc}
     */
    public function getClass()
    {
        return $this->class;
    }    
}
