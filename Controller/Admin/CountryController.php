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
use IR\Bundle\ZoneBundle\Event\CountryEvent;
use IR\Bundle\ZoneBundle\Model\CountryInterface;

/**
 * Admin controller managing the countries.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class CountryController extends ContainerAware
{
    /**
     * List all the countries.
     */
    public function listAction()
    {
        $countries = $this->container->get('ir_zone.manager.country')->findCountriesBy(array(), array('name' => 'asc'));

        return $this->container->get('templating')->renderResponse('IRZoneBundle:Admin/Country:list.html.'.$this->getEngine(), array(
            'countries' => $countries,
        ));
    }
    
    /**
     * Show country details.
     */
    public function showAction($id)
    {
        $country = $this->findCountryById($id);

        return $this->container->get('templating')->renderResponse('IRZoneBundle:Admin/Country:show.html.'.$this->getEngine(), array(
            'country' => $country
        ));
    }       
    
    /**
     * Create a new country: show the new form.
     */
    public function newAction(Request $request)
    {       
        /* @var $countryManager \IR\Bundle\ZoneBundle\Manager\CountryManagerInterface */
        $countryManager = $this->container->get('ir_zone.manager.country');
        $country = $countryManager->createCountry();
        
        $form = $this->container->get('ir_zone.form.country'); 
        $form->setData($country);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $countryManager->updateCountry($country);

            /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
            $dispatcher = $this->container->get('event_dispatcher');                      
            $dispatcher->dispatch(IRZoneEvents::COUNTRY_CREATE_COMPLETED, new CountryEvent($country));
                
            return new RedirectResponse($this->container->get('router')->generate('ir_zone_admin_country_show', array('id' => $country->getId())));                      
        }
        
        return $this->container->get('templating')->renderResponse('IRZoneBundle:Admin/Country:new.html.'.$this->getEngine(), array(
            'country' => $country,
            'form' => $form->createView(),
        ));          
    }    
    
    /**
     * Edit a country: show the edit form.
     */
    public function editAction(Request $request, $id)
    {
        $country = $this->findCountryById($id);

        $form = $this->container->get('ir_zone.form.country');      
        $form->setData($country);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $this->container->get('ir_zone.manager.country')->updateCountry($country);
            
            /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
            $dispatcher = $this->container->get('event_dispatcher');               
            $dispatcher->dispatch(IRZoneEvents::COUNTRY_EDIT_COMPLETED, new CountryEvent($country));
                
            return new RedirectResponse($this->container->get('router')->generate('ir_zone_admin_country_show', array('id' => $country->getId())));                     
        }        
        
        return $this->container->get('templating')->renderResponse('IRZoneBundle:Admin/Country:edit.html.'.$this->getEngine(), array(
            'country' => $country,
            'form'    => $form->createView(),
        ));          
    }  
    
    /**
     * Delete a product.
     */
    public function deleteAction($id)
    {
        $country = $this->findCountryById($id);
        $this->container->get('ir_zone.manager.country')->deleteCountry($country);
        
        /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');          
        $dispatcher->dispatch(IRZoneEvents::COUNTRY_DELETE_COMPLETED, new CountryEvent($country));
        
        return new RedirectResponse($this->container->get('router')->generate('ir_zone_admin_country_list'));   
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
     * Returns the template engine.
     * 
     * @return string
     */    
   protected function getEngine()
    {
        return $this->container->getParameter('ir_zone.template.engine');
    }        
}
