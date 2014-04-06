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
use IR\Bundle\ZoneBundle\Event\ZoneEvent;
use IR\Bundle\ZoneBundle\Model\ZoneInterface;

/**
 * Admin controller managing the zones.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ZoneController extends ContainerAware
{
    /**
     * List all the zones.
     */
    public function listAction()
    {
        $zones = $this->container->get('ir_zone.manager.zone')->findZonesBy(array(), array('name' => 'asc'));

        return $this->container->get('templating')->renderResponse('IRZoneBundle:Admin/Zone:list.html.'.$this->getEngine(), array(
            'zones' => $zones,
        ));
    }
    
    /**
     * Show zone details.
     */
    public function showAction($id)
    {
        $zone = $this->findZoneById($id);

        return $this->container->get('templating')->renderResponse('IRZoneBundle:Admin/Zone:show.html.'.$this->getEngine(), array(
            'zone' => $zone
        ));
    }       
    
    /**
     * Create a new zone: show the new form.
     */
    public function newAction(Request $request)
    {       
        /* @var $zoneManager \IR\Bundle\ZoneBundle\Manager\ZoneManagerInterface */
        $zoneManager = $this->container->get('ir_zone.manager.zone');
        $zone = $zoneManager->createZone();
        
        $form = $this->container->get('ir_zone.form.zone'); 
        $form->setData($zone);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $zoneManager->updateZone($zone);
            
            /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
            $dispatcher = $this->container->get('event_dispatcher');                      
            $dispatcher->dispatch(IRZoneEvents::ZONE_CREATE_COMPLETED, new ZoneEvent($zone));
                
            return new RedirectResponse($this->container->get('router')->generate('ir_zone_admin_zone_show', array('id' => $zone->getId())));                      
        }
        
        return $this->container->get('templating')->renderResponse('IRZoneBundle:Admin/Zone:new.html.'.$this->getEngine(), array(
            'zone' => $zone,
            'form' => $form->createView(),
        ));          
    }    
    
    /**
     * Edit a zone: show the edit form.
     */
    public function editAction(Request $request, $id)
    {
        $zone = $this->findZoneById($id);

        $form = $this->container->get('ir_zone.form.zone');      
        $form->setData($zone);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $this->container->get('ir_zone.manager.zone')->updateZone($zone);
            
            /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
            $dispatcher = $this->container->get('event_dispatcher');               
            $dispatcher->dispatch(IRZoneEvents::ZONE_EDIT_COMPLETED, new ZoneEvent($zone));
                
            return new RedirectResponse($this->container->get('router')->generate('ir_zone_admin_zone_show', array('id' => $zone->getId())));                     
        }        
        
        return $this->container->get('templating')->renderResponse('IRZoneBundle:Admin/Zone:edit.html.'.$this->getEngine(), array(
            'zone' => $zone,
            'form' => $form->createView(),
        ));          
    }  
    
    /**
     * Delete a product.
     */
    public function deleteAction($id)
    {
        $zone = $this->findZoneById($id);
        $this->container->get('ir_zone.manager.zone')->deleteZone($zone);
        
        /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');          
        $dispatcher->dispatch(IRZoneEvents::ZONE_DELETE_COMPLETED, new ZoneEvent($zone));
        
        return new RedirectResponse($this->container->get('router')->generate('ir_zone_admin_zone_list'));   
    }       
    
    /**
     * Finds a zone by id.
     *
     * @param mixed $id
     *
     * @return ZoneInterface
     * 
     * @throws NotFoundHttpException When zone does not exist
     */
    protected function findZoneById($id)
    {
        $zone = $this->container->get('ir_zone.manager.zone')->findZoneBy(array('id' => $id));

        if (null === $zone) {
            throw new NotFoundHttpException(sprintf('The zone with id %s does not exist', $id));
        }

        return $zone;
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
