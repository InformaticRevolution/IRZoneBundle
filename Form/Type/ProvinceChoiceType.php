<?php

/*
 * This file is part of the IRZoneBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ZoneBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\ChoiceList\ObjectChoiceList;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Province Choice Type.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ProvinceChoiceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */       
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {   
        $choiceList = function (Options $options) {
            return new ObjectChoiceList($options['country']->getProvinces());
        };        
        
        $resolver
            ->setDefaults(array(
                'choice_list' => $choiceList
            ))
            ->setRequired(array(
                'country'
            ))
            ->addAllowedTypes(array(
                'country' => 'IR\Bundle\ZoneBundle\Model\ProvinceInterface'
            )); 
    } 
    
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'choice';
    }    
    
    /**
     * {@inheritdoc}
     */        
    public function getName()
    {
        return 'ir_zone_province_choice';
    }    
}
