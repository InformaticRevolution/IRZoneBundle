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
use IR\Bundle\ZoneBundle\Event\ProvinceEvent;
use IR\Bundle\ZoneBundle\Model\ProvinceInterface;
use IR\Bundle\ZoneBundle\Model\CountryInterface;

/**
 * Admin controller managing the provinces.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ProvinceController extends ContainerAware
{
    /**
     * Create a new province: show the new form.
     */
    public function newAction(Request $request, $countryId)
    {   
        $country = $this->findCountryById($countryId);
        $province = $this->container->get('ir_zone.manager.province')->createProvince($country);
        
        $form = $this->container->get('ir_zone.form.province'); 
        $form->setData($province);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $country->addProvince($province);
            $this->container->get('ir_zone.manager.country')->updateCountry($country);

            /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
            $dispatcher = $this->container->get('event_dispatcher');                      
            $dispatcher->dispatch(IRZoneEvents::PROVINCE_CREATE_COMPLETED, new ProvinceEvent($province));
                
            return new RedirectResponse($this->container->get('router')->generate('ir_zone_admin_country_show', array('id' => $country->getId())));                      
        }
        
        return $this->container->get('templating')->renderResponse('IRZoneBundle:Admin/Province:new.html.'.$this->getEngine(), array(
            'province' => $province,
            'form'     => $form->createView(),
        ));          
    } 
    
    /**
     * Edit a province: show the edit form.
     */
    public function editAction(Request $request, $id)
    {
        $province = $this->findProvinceById($id);

        $form = $this->container->get('ir_zone.form.province');      
        $form->setData($province);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $this->container->get('ir_zone.manager.country')->updateCountry($province->getCountry());
            
            /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
            $dispatcher = $this->container->get('event_dispatcher');               
            $dispatcher->dispatch(IRZoneEvents::PROVINCE_EDIT_COMPLETED, new ProvinceEvent($province));
                
            return new RedirectResponse($this->container->get('router')->generate('ir_zone_admin_country_show', array('id' => $province->getCountry()->getId())));                     
        }        
        
        return $this->container->get('templating')->renderResponse('IRZoneBundle:Admin/Province:edit.html.'.$this->getEngine(), array(
            'province' => $province,
            'form'     => $form->createView(),
        ));          
    }    
    
    /**
     * Delete a province.
     */
    public function deleteAction($id)
    {
        $province = $this->findProvinceById($id);
        $country = $province->getCountry();
        
        $country->removeProvince($province);
        $this->container->get('ir_zone.manager.country')->updateCountry($country);
        
        /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');          
        $dispatcher->dispatch(IRZoneEvents::PROVINCE_DELETE_COMPLETED, new ProvinceEvent($province));
        
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
     * Finds a province by id.
     *
     * @param mixed $id
     *
     * @return ProvinceInterface
     * 
     * @throws NotFoundHttpException When province does not exist
     */
    protected function findProvinceById($id)
    {
        $province = $this->container->get('ir_zone.manager.province')->findProvinceBy(array('id' => $id));

        if (null === $province) {
            throw new NotFoundHttpException(sprintf('The province with id %s does not exist', $id));
        }

        return $province;
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
