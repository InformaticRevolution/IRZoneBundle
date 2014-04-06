<?php

/*
 * This file is part of the IRZoneBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ZoneBundle\EventListener;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Translation\TranslatorInterface;
use IR\Bundle\ZoneBundle\IRZoneEvents;

/**
 * Flash Listener.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class FlashListener implements EventSubscriberInterface
{
    private static $successMessages = array(               
        IRZoneEvents::ZONE_CREATE_COMPLETED    => 'ir_zone.admin.zone.flash.created',
        IRZoneEvents::ZONE_EDIT_COMPLETED      => 'ir_zone.admin.zone.flash.updated',
        IRZoneEvents::ZONE_DELETE_COMPLETED    => 'ir_zone.admin.zone.flash.deleted',   
        IRZoneEvents::COUNTRY_CREATE_COMPLETED => 'ir_zone.admin.country.flash.created',
        IRZoneEvents::COUNTRY_EDIT_COMPLETED   => 'ir_zone.admin.country.flash.updated',
        IRZoneEvents::COUNTRY_DELETE_COMPLETED => 'ir_zone.admin.country.flash.deleted',
        IRZoneEvents::REGION_CREATE_COMPLETED  => 'ir_zone.admin.region.flash.created',
        IRZoneEvents::REGION_EDIT_COMPLETED    => 'ir_zone.admin.region.flash.updated',
        IRZoneEvents::REGION_DELETE_COMPLETED  => 'ir_zone.admin.region.flash.deleted',           
    );

    /**
     * @var SessionInterface
     */    
    protected $session;
    
    /**
     * @var TranslatorInterface
     */    
    protected $translator;

    
   /**
    * Constructor.
    *
    * @param SessionInterface    $session
    * @param TranslatorInterface $translator
    */            
    public function __construct(SessionInterface $session, TranslatorInterface $translator)
    {
        $this->session = $session;
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */        
    public static function getSubscribedEvents()
    {
        return array(            
            IRZoneEvents::ZONE_CREATE_COMPLETED    => 'addSuccessFlash',
            IRZoneEvents::ZONE_EDIT_COMPLETED      => 'addSuccessFlash',
            IRZoneEvents::ZONE_DELETE_COMPLETED    => 'addSuccessFlash',   
            IRZoneEvents::COUNTRY_CREATE_COMPLETED => 'addSuccessFlash',
            IRZoneEvents::COUNTRY_EDIT_COMPLETED   => 'addSuccessFlash',
            IRZoneEvents::COUNTRY_DELETE_COMPLETED => 'addSuccessFlash',
            IRZoneEvents::REGION_CREATE_COMPLETED  => 'addSuccessFlash',
            IRZoneEvents::REGION_EDIT_COMPLETED    => 'addSuccessFlash',
            IRZoneEvents::REGION_DELETE_COMPLETED  => 'addSuccessFlash',              
        );
    }

    /**
     * Adds a success flash message.
     * 
     * @param Event $event
     */            
    public function addSuccessFlash(Event $event)
    {
        if (!isset(self::$successMessages[$event->getName()])) {
            throw new \InvalidArgumentException('This event does not correspond to a known flash message');
        }

        $this->session->getFlashBag()->add('success', $this->translator->trans(self::$successMessages[$event->getName()]));
    }
}