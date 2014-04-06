<?php

/*
 * This file is part of the IRZoneBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ZoneBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use IR\Bundle\ZoneBundle\IRZoneEvents;
use IR\Bundle\ZoneBundle\Event\RegionEvent;
use IR\Bundle\ZoneBundle\Model\RegionInterface;
use IR\Bundle\ZoneBundle\Model\CountryInterface;

/**
 * Admin controller managing the regions.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class RegionController extends ContainerAware
{
    /**
     * Create a new region: show the new form.
     */
    public function newAction(Request $request, $countryId)
    {   
        $country = $this->findCountryById($countryId);
        $region = $this->container->get('ir_zone.manager.region')->createRegion($country);
        
        $form = $this->container->get('ir_zone.form.region'); 
        $form->setData($region);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $country->addRegion($region);
            $this->container->get('ir_zone.manager.country')->updateCountry($country);

            /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
            $dispatcher = $this->container->get('event_dispatcher');                      
            $dispatcher->dispatch(IRZoneEvents::REGION_CREATE_COMPLETED, new RegionEvent($region));
                
            return new RedirectResponse($this->container->get('router')->generate('ir_zone_admin_country_show', array('id' => $country->getId())));                      
        }
        
        return $this->container->get('templating')->renderResponse('IRZoneBundle:Admin/Region:new.html.'.$this->getEngine(), array(
            'region' => $region,
            'form'   => $form->createView(),
        ));          
    } 
    
    /**
     * Edit a region: show the edit form.
     */
    public function editAction(Request $request, $id)
    {
        $region = $this->findRegionById($id);

        $form = $this->container->get('ir_zone.form.region');      
        $form->setData($region);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $this->container->get('ir_zone.manager.country')->updateCountry($region->getCountry());
            
            /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
            $dispatcher = $this->container->get('event_dispatcher');               
            $dispatcher->dispatch(IRZoneEvents::REGION_EDIT_COMPLETED, new RegionEvent($region));
                
            return new RedirectResponse($this->container->get('router')->generate('ir_zone_admin_country_show', array('id' => $region->getCountry()->getId())));                     
        }        
        
        return $this->container->get('templating')->renderResponse('IRZoneBundle:Admin/Region:edit.html.'.$this->getEngine(), array(
            'region' => $region,
            'form'   => $form->createView(),
        ));          
    }    
    
    /**
     * Delete a region.
     */
    public function deleteAction($id)
    {
        $region = $this->findRegionById($id);
        $country = $region->getCountry();
        
        $country->removeRegion($region);
        $this->container->get('ir_zone.manager.country')->updateCountry($country);
        
        /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');          
        $dispatcher->dispatch(IRZoneEvents::REGION_DELETE_COMPLETED, new RegionEvent($region));
        
        return new RedirectResponse($this->container->get('router')->generate('ir_zone_admin_country_show', array('id' => $country->getId())));    
    }    
    
    /**
     * Finds a country by id.
     *
     * @param mixed $id
     *
     * @return CountryInterface
     * 
     * @throws NotFoundHttpException When country does not exist
     */
    protected function findCountryById($id)
    {
        $country = $this->container->get('ir_zone.manager.country')->findCountryBy(array('id' => $id));

        if (null === $country) {
            throw new NotFoundHttpException(sprintf('The country with id %s does not exist', $id));
        }

        return $country;
    }
    
    /**
     * Finds a region by id.
     *
     * @param mixed $id
     *
     * @return RegionInterface
     * 
     * @throws NotFoundHttpException When region does not exist
     */
    protected function findRegionById($id)
    {
        $region = $this->container->get('ir_zone.manager.region')->findRegionBy(array('id' => $id));

        if (null === $region) {
            throw new NotFoundHttpException(sprintf('The region with id %s does not exist', $id));
        }

        return $region;
    }    
    
    /**
     * Returns the template engine.
     * 
     * @return string
     */    
   protected function getEngine()
    {
        return $this->container->getParameter('ir_zone.template.engine');
    }        
}
