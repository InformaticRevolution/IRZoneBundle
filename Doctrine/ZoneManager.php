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

use IR\Bundle\ZoneBundle\Model\ZoneInterface;
use IR\Bundle\ZoneBundle\Manager\ZoneManager as AbstractZoneManager;

/**
 * Doctrine Zone Manager.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ZoneManager extends AbstractZoneManager
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
     * Updates a zone.
     *
     * @param ZoneInterface $zone
     * @param Boolean       $andFlush Whether to flush the changes (default true)
     */    
    public function updateZone(ZoneInterface $zone, $andFlush = true)
    { 
        $this->objectManager->persist($zone);
   
        if ($andFlush) {
            $this->objectManager->flush();
        }        
    }    

    /**
     * {@inheritDoc}
     */     
    public function deleteZone(ZoneInterface $zone)
    {
        $this->objectManager->remove($zone);
        $this->objectManager->flush();      
    }         
    
    /**
     * {@inheritDoc}
     */
    public function findZoneBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }         
    
    /**
     * {@inheritdoc}
     */    
    public function findZonesBy(array $criteria, array $orderBy = null, $limite = null, $offset = null) 
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
