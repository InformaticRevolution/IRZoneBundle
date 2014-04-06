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
use IR\Bundle\ZoneBundle\Manager\RegionManager as AbstractRegionManager;

/**
 * Doctrine Region Manager.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class RegionManager extends AbstractRegionManager
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
     * {@inheritDoc}
     */
    public function findRegionBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }         

    /**
     * {@inheritDoc}
     */
    public function getClass()
    {
        return $this->class;
    }    
}
